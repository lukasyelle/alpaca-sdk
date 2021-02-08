<?php

namespace Lukasyelle\AlpacaSdk\Facades\Orders;

use Illuminate\Support\Collection;
use Lukasyelle\AlpacaSdk\Facades\BaseRequestFacade;
use Lukasyelle\AlpacaSdk\Orders\Order;

/**
 * @method static Collection from(Order|array $order, string $replaceOrderId = null)
 * @method static \Lukasyelle\AlpacaSdk\Orders\CreateOrder replaceOrder(string $replaceOrderId)
 */
class CreateOrder extends BaseRequestFacade
{
    protected static function getFacadeAccessor()
    {
        return \Lukasyelle\AlpacaSdk\Orders\CreateOrder::class;
    }
}
