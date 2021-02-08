<?php

namespace Lukasyelle\AlpacaSdk\Requests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Lukasyelle\AlpacaSdk\Contracts\Alpaca;
use Lukasyelle\AlpacaSdk\Exceptions\InvalidData;

abstract class BaseRequest
{
    public string $endpoint = '';

    protected string $method = 'GET';

    public array $bodyParams = [];

    public array $queryParams = [];

    protected array $requiredBodyParams = [];

    protected array $requiredQueryParams = [];

    protected Alpaca $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function setClient(Alpaca $client): self
    {
        $this->api = $client;

        return $this;
    }

    /**
     * @throws InvalidData
     */
    public function send(): Collection
    {
        $this->validateParams('queryParams');
        $this->validateParams('bodyParams');

        $request = new Request($this->method, $this->getFullEndpoint(), [], json_encode($this->bodyParams));

        $response = $this->api->send($request, ['query' => $this->queryParams]);

        return collect(json_decode($response->getBody()->getContents()));
    }

    /**
     * @throws InvalidData
     */
    public function get(): Collection
    {
        $this->method = 'GET';

        return $this->send();
    }

    /**
     * @throws InvalidData
     *
     * @return Collection
     */
    public function post(): Collection
    {
        $this->method = 'POST';

        if (empty($this->payload)) {
            throw InvalidData::emptyPayloadOnPost();
        }

        return $this->send();
    }

    /**
     * Parse the endpoint string and resolve any {tokens} to a public property
     * on the $this object.
     *
     * @return string
     */
    public function getFullEndpoint(): string
    {
        $results = [];
        preg_match_all('/\{(.*?)\}/', $this->endpoint, $results);
        // preg_match_all will populate $results with a 2-d array with two keys.
        // the first key will be an array of all of the matches, the second key
        // will be an array of only the strings between '{}'.

        if ($results) {
            // go over each result and check if a property exists with the name
            // specified. If it does, replace it in the endpoint string.
            foreach ($results[1] as $index => $urlParam) {
                if (property_exists($this, $urlParam)) {
                    $keyToReplace = '{'.$results[0][$index].'}';
                    $this->endpoint = (string) preg_replace($keyToReplace, $this->$urlParam, $this->endpoint);
                }
            }
        }

        return $this->endpoint;
    }

    /**
     * @param string $params
     *
     * @throws InvalidData
     *
     * @return void
     */
    protected function validateParams(string $params): void
    {
        $requiredString = 'required'.ucfirst($params);
        if ($this->$requiredString) {
            $missingParams = array_filter($this->$requiredString, function ($param) use ($params) {
                return in_array($param, $this->$params);
            });
            if ($missingParams) {
                throw InvalidData::missingParams($missingParams);
            }
        }
    }
}
