<?php

namespace Lukasyelle\AlpacaSdk\Facades;

use Illuminate\Support\Facades\Facade;
use Ramsey\Collection\Collection;

/**
 * @method static Collection get()
 * @method static Collection post()
 * @method static string getFullEndpoint()
 */
abstract class BaseRequestFacade extends Facade
{
}
