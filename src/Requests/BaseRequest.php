<?php

namespace Lukasyelle\AlpacaSdk\Requests;

use Lukasyelle\AlpacaSdk\Exceptions\InvalidData;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use function PHPUnit\Framework\throwException;

abstract class BaseRequest
{
    const ENDPOINT = '';

    protected string $method = 'GET';

    protected array $payload = [];

    protected array $requiredParams = [];

    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * @throws InvalidData
     */
    public function send(): Collection
    {
        $this->validateParams();

        $request = new Request($this->method, $this->getFullEndpoint(), [], json_encode($this->payload));

        $response = $this->api->send($request);

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
    protected function getFullEndpoint(): string
    {
        return self::ENDPOINT;
    }

    /**
     * @return void
     * @throws InvalidData
     */
    protected function validateParams(): void
    {
        if ($this->requiredParams) {
            $missingParams = array_diff($this->requiredParams, array_keys($this->payload));
            if ($missingParams) {
                throw InvalidData::missingParams($missingParams);
            }
        }
    }
}