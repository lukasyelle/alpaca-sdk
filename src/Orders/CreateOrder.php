<?php

namespace Lukasyelle\AlpacaSdk\Orders;

use Illuminate\Support\Collection;
use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Requests\Trading;

class CreateOrder extends Trading
{
    public string $endpoint = '/v2/orders';

    public string $method = 'POST';

    public string $replaceOrderId;

    public Order $order;

    public function __construct(AlpacaTrading $tradingApi, array $order = null, string $replaceOrderId = null)
    {
        parent::__construct($tradingApi);

        return $order ? $this->from($order, $replaceOrderId) : $this;
    }

    public function from(Order | array $order, string $replaceOrderId = null): Collection
    {
        $this->order = is_array($order) ? new Order($order) : $order;

        $this->bodyParams = $this->order->toArray();
        $this->requiredBodyParams = $this->order->requiredParams;

        if ($replaceOrderId) {
            $this->replaceOrder($replaceOrderId);
        }

        return $this->send();
    }

    public function with(Order | array $order): Collection
    {
        return $this->from($order);
    }

    public function replaceOrder(string $replaceOrderId): self
    {
        $this->method = 'PATCH';
        $this->endpoint = $this->endpoint . '/{replaceOrderId}';
        $this->replaceOrderId = $replaceOrderId;

        return $this;
    }
}
