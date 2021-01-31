<?php

namespace Lukasyelle\AlpacaSdk\Facades\Orders;

use Lukasyelle\AlpacaSdk\Facades\BaseRequestFacade;

/**
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders open()
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders closed()
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders all()
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders take(int $num)
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders after(int $timestamp)
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders until(int $timestamp)
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders asc()
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders desc()
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders nested()
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders whereSymbol(string $symbol)
 * @method static \Lukasyelle\AlpacaSdk\Orders\ListOrders whereSymbols(array $symbols)
 */
class ListOrders extends BaseRequestFacade
{
    protected static function getFacadeAccessor()
    {
        return \Lukasyelle\AlpacaSdk\Orders\ListOrders::class;
    }
}
