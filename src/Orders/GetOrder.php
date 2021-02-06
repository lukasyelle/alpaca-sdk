<?php

namespace Lukasyelle\AlpacaSdk\Orders;

use Lukasyelle\AlpacaSdk\Contracts\AlpacaTrading;
use Lukasyelle\AlpacaSdk\Requests\Trading;

class GetOrder extends Trading
{
    public string $endpoint = '/v2/orders/{orderId}';

    public string $method = 'GET';

    protected string $orderId = '';

    public function __construct(AlpacaTrading $tradingApi, string $orderId = null)
    {
        parent::__construct($tradingApi);

        if ($orderId) {
            $this->setOrderId($orderId);
        }
    }

    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }
}