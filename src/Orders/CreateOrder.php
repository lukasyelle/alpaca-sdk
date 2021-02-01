<?php

namespace Lukasyelle\AlpacaSdk\Orders;

use Illuminate\Support\Collection;
use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Requests\Trading;

class CreateOrder extends Trading
{
    public string $endpoint = '/v2/orders';

    public string $method = 'POST';

    public Order $order;

    public function __construct(AlpacaTrading $tradingApi, array $order = null)
    {
        parent::__construct($tradingApi);

        return $order ? $this->from($order) : $this;
    }

    public function from(Order|array $order): Collection
    {
        $this->order = is_array($order) ? new Order($order) : $order;

        $this->bodyParams = $this->order->toArray();
        $this->requiredBodyParams = $this->order->requiredParams;

        return $this->send();
    }
}