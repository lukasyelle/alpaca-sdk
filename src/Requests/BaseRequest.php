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

    /**
     * @throws InvalidData
     */
    protected function send(): Collection
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
     * @return string
     */
    public function getFullEndpoint(): string
    {
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
