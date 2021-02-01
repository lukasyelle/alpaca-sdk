<?php

namespace Lukasyelle\AlpacaSdk\Facades\Account;

use Lukasyelle\AlpacaSdk\Facades\BaseRequestFacade;

class Account extends BaseRequestFacade
{
    public static function getFacadeAccessor(): string
    {
        return \Lukasyelle\AlpacaSdk\Account\Details::class;
    }
}
