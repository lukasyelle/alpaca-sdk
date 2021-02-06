<?php

namespace Lukasyelle\AlpacaSdk\Facades;

use Illuminate\Support\Facades\Facade;
use Lukasyelle\AlpacaSdk\Contracts\Alpaca;
use Lukasyelle\AlpacaSdk\Requests\BaseRequest;
use Ramsey\Collection\Collection;

/**
 * @method static Collection get()
 * @method static Collection post()
 * @method static string getFullEndpoint()
 * @method static BaseRequest setClient(Alpaca $client)
 */
abstract class BaseRequestFacade extends Facade
{
}
