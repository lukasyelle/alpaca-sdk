<?php

namespace Lukasyelle\AlpacaSdk;

use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Exceptions\InvalidData;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client implements AlpacaTrading
{
    /**
     * @var Guzzle|null
     */
    private $client = null;

    /**
     * Client constructor.
     *
     * @param  Guzzle  $client
     */
    public function __construct(Guzzle $client)
    {
        $this->client = $client;
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
            return $this->client->send($request);
        }
        catch (ClientException $e) {
            throw InvalidData::badData($e->getMessage());
        }
    }
}