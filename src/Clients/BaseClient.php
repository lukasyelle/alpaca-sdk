<?php

namespace Lukasyelle\AlpacaSdk\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Lukasyelle\AlpacaSdk\Contracts\Alpaca;
use Lukasyelle\AlpacaSdk\Exceptions\InvalidData;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BaseClient implements Alpaca
{
    /**
     * @var Guzzle|null
     */
    private $client = null;

    /**
     * Client constructor.
     *
     * @param string            $baseUrl
     * @param string            $keyId
     * @param string            $secretKey
     * @param HandlerStack|null $handlerStack
     */
    public function __construct(string $baseUrl, string $keyId, string $secretKey, HandlerStack $handlerStack = null)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'APCA-API-KEY-ID' => $keyId,
                'APCA-API-SECRET-KEY' => $secretKey,
            ],
            'handler' => $handlerStack,
        ]);
    }

    /**
     * @param RequestInterface $request
     * @param array            $options
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        try {
            return $this->client->send($request, $options);
        }
        catch (ClientException $e) {
            throw InvalidData::badData($e->getMessage());
        }
    }
}