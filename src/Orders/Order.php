<?php

namespace Lukasyelle\AlpacaSdk\Orders;

use Illuminate\Support\Collection;
use Lukasyelle\AlpacaSdk\Contracts\Alpaca;
use Lukasyelle\AlpacaSdk\Exceptions\InvalidData;

/**
 * Parameters.
 *
 * symbol          - string Required: symbol or asset ID to identify the asset to trade
 * qty             - string<int> Required: number of shares to trade
 * side            - string Required: buy or sell
 * type            - string Required: market, limit, stop, stop_limit, or trailing_stop
 * time_in_force   - string Required: day, gtc, opg, cls, ioc, fok. Please see Understand Orders for more info.
 * limit_price     - string<number> Required: required if type is limit or stop_limit
 * stop_price      - string<number> Required: required if type is stop or stop_limit
 * trail_price     - string<number> Required: this or trail_percent is required if type is trailing_stop
 * trail_percent   - string<number> Required: this or trail_price is required if type is trailing_stop
 * extended_hours  - boolean (default) false: If true, order will be eligible to execute in premarket/afterhours. Only works with type limit and time_in_force day.
 * client_order_id - string (<= 48 characters): A unique identifier for the order. Automatically generated if not sent.
 * order_class     - string: simple, bracket, oco or oto. For details of non-simple order classes, please see Bracket Order Overview
 * take_profit     - object: Additional parameters for take-profit leg of advanced orders.
 *                        limit_price - string<number> Required: required for bracket orders
 * stop_loss       - object: Additional parameters for stop-loss leg of advanced orders.
 *                        stop_price - string<number> Required: required for bracket orders
 *                        limit_price - string<number>: the stop-loss order becomes a stop-limit order if specified
 */
class Order
{
    protected array $order = [];

    // These parameters are only a tool to ensure that the data supplied is in
    // the appropriate type.
    protected string $symbol;
    protected int $qty;
    protected string $side;
    protected string $type;
    protected string $time_in_force;
    protected float | null $limit_price = null;
    protected float | null $stop_price = null;
    protected float | null $trail_price = null;
    protected float | null $trail_percent = null;

    public array $requiredParams = [
        'symbol'            => 'string',
        'qty'               => 'int',
        'side'              => ['buy', 'sell'],
        'type'              => ['market', 'limit', 'stop', 'stop_limit', 'trailing_stop'],
        'time_in_force'     => ['day', 'gtc', 'opg', 'cls', 'ioc', 'fok'],
    ];

    public function __construct(array $order = [])
    {
        $this->order = $order;
        $this->parseOrder();
        $this->setConditionalRequirements();
        $this->verifyRequiredParams();
    }

    public function toArray(): array
    {
        return $this->order;
    }

    /**
     * Helper method to the CreateOrder facade. Makes for a simple way to create
     * an order from the Order object itself.
     *
     * If needed, you can change the client it sends the request through, this
     * is only used in tests at the moment.
     *
     * @param Alpaca|null $client
     *
     * @return Collection
     */
    public function create(Alpaca $client = null): Collection
    {
        if ($client) {
            return \Lukasyelle\AlpacaSdk\Facades\Orders\CreateOrder::setClient($client)->from($this);
        }

        return \Lukasyelle\AlpacaSdk\Facades\Orders\CreateOrder::from($this);
    }

    /**
     * Helper method to the GetOrder facade. Makes for a simple way to get an
     * order from the Order class itself with just an ID.
     *
     * If needed, you can change the client it sends the request through, this
     * is only used in tests at the moment.
     *
     * @param string      $orderId
     * @param Alpaca|null $client
     *
     * @return Collection
     * @throws InvalidData
     */
    public static function get(string $orderId, Alpaca $client = null): Collection
    {
        $api = \Lukasyelle\AlpacaSdk\Facades\Orders\GetOrder::setOrderId($orderId);

        if ($client) {
            $api->setClient($client);
        }

        return $api->get();
    }
    
    private function verifyRequiredParams(): void
    {
        foreach ($this->requiredParams as $key => $value) {
            if (!array_key_exists($key, $this->order)) {
                throw new InvalidData("'$key' is required for new orders but was not passed.");
            } elseif ($this->order[$key] === null) {
                throw new InvalidData("'$key' is required for new orders but was null.");
            }

            if (is_array($value) && !in_array($this->order[$key], $value)) {
                throw new InvalidData("'$value' for '$key' is not allowed.");
            }
        }

        if (array_key_exists('take_profit', $this->order)) {
            $takeProfit = $this->order['take_profit'];
            $this->validateArrayHasKeys($takeProfit, ['limit_price']);
        }

        if (array_key_exists('stop_loss', $this->order)) {
            $takeProfit = $this->order['stop_loss'];
            $this->validateArrayHasKeys($takeProfit, ['stop_price']);
        }
    }

    private function validateArrayHasKeys($array, array $keys, bool $nullable = false): void
    {
        foreach ($keys as $key) {
            if (
                !is_array($array) ||
                !array_key_exists($key, $array) ||
                ($array[$key] == null && !$nullable)
            ) {
                throw new InvalidData("When adding an advanced parameter you must supply a valid $key as part of the object.");
            }
        }
    }

    private function parseOrder(): void
    {
        $this->verifyRequiredParams();
        foreach ($this->order as $param => $value) {
            $this->$param = $value;
        }
    }

    private function setConditionalRequirements(): void
    {
        if ($this->type == 'limit' || $this->type == 'stop_limit') {
            $this->requiredParams['limit_price'] = 'float';
        }
        if ($this->type == 'stop' || $this->type == 'stop_limit') {
            $this->requiredParams['stop_price'] = 'float';
        }
        if ($this->type == 'trailing_stop') {
            // Set one of either trail_price or trail_percent to required based
            // on which one is not present.
            if (!array_key_exists('trail_price', $this->order)) {
                $this->requiredParams['trail_percent'] = 'float';
            } else {
                $this->requiredParams['trail_price'] = 'float';
            }
        }
    }
}
