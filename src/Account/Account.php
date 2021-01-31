<?php

namespace Lukasyelle\AlpacaSdk\Account;

use Lukasyelle\AlpacaSdk\Requests\Trading;

class Account extends Trading
{
    public string $endpoint = '/v2/account';
}
