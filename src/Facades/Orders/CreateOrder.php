<?php

namespace Lukasyelle\AlpacaSdk\Facades\Orders;

use Lukasyelle\AlpacaSdk\Facades\BaseRequestFacade;
use Lukasyelle\AlpacaSdk\Orders\Order;

/**
 * @method static \Lukasyelle\AlpacaSdk\Orders\CreateOrder from(Order|array $order)
 */
class CreateOrder extends BaseRequestFacade
{
    protected static function getFacadeAccessor()
    {
        return \Lukasyelle\AlpacaSdk\Orders\CreateOrder::class;
    }
}
