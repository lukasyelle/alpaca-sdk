<?php

namespace Lukasyelle\AlpacaSdk\Requests;

use Lukasyelle\AlpacaSdk\Contracts\AlpacaMarketData;

abstract class MarketData extends BaseRequest
{
    public function __construct(AlpacaMarketData $dataApi)
    {
        parent::__construct($dataApi);
    }
}