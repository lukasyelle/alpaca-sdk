<?php

namespace Lukasyelle\AlpacaSdk\Requests;

use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;

abstract class Trading extends BaseRequest
{
    public function __construct(AlpacaTrading $tradingApi)
    {
        parent::__construct($tradingApi);
    }
}