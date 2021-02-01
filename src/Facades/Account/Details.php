<?php

namespace Lukasyelle\AlpacaSdk\Facades\Account;

use Lukasyelle\AlpacaSdk\Facades\BaseRequestFacade;

class Details extends BaseRequestFacade
{
    public static function getFacadeAccessor(): string
    {
        return \Lukasyelle\AlpacaSdk\Account\Details::class;
    }
}
