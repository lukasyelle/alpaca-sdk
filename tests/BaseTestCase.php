<?php

namespace Lukasyelle\AlpacaSdk\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Lukasyelle\AlpacaSdk\AlpacaSdkServiceProvider;
use Lukasyelle\AlpacaSdk\Client;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected int $mockResponseCode = 200;
    protected string $mockResponse = '';

    protected function getPackageProviders($app): array
    {
        return [AlpacaSdkServiceProvider::class];
    }

    protected function getMockClient(): Client
    {
        $mock = new MockHandler([
            $this->mockResponse()
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new \GuzzleHttp\Client(['handler' => $handler]);

        return new Client($guzzle);
    }

    protected function mockResponse(): Response
    {
        return new Response($this->mockResponseCode, [], $this->mockResponse);
    }
}