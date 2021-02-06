<?php

namespace Lukasyelle\AlpacaSdk\Facades\Orders;

use Lukasyelle\AlpacaSdk\Facades\BaseRequestFacade;

/**
 * @method static \Lukasyelle\AlpacaSdk\Orders\GetOrder setOrderId(string $orderId)
 */
class GetOrder extends BaseRequestFacade
{
    protected static function getFacadeAccessor()
    {
        return \Lukasyelle\AlpacaSdk\Orders\GetOrder::class;
    }
}