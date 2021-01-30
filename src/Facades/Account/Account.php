<?php

namespace Lukasyelle\AlpacaSdk\Facades\Account;

use Illuminate\Support\Facades\Facade;

class Account extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return \Lukasyelle\AlpacaSdk\Account\Account::class;
    }
}