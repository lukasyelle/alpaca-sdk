<?php

namespace Lukasyelle\AlpacaSdk\Orders;

use Lukasyelle\AlpacaSdk\Exceptions\InvalidData;
use Lukasyelle\AlpacaSdk\Requests\Trading;

class ListOrders extends Trading
{
    public string $endpoint = '/v2/orders';

    /**
     * Sets the order status to be queried to open.
     *
     * @return ListOrders
     */
    public function open(): self
    {
        $this->queryParams['status'] = 'open';

        return $this;
    }

    /**
     * Sets the order status to be queried to closed.
     *
     * @return ListOrders
     */
    public function closed(): self
    {
        $this->queryParams['status'] = 'closed';

        return $this;
    }

    /**
     * Sets the order status to be queried to All and grabs the max number of
     * orders.
     *
     * @throws InvalidData
     *
     * @return ListOrders
     */
    public function all(): self
    {
        $this->queryParams['status'] = 'all';

        $this->take(500);

        return $this;
    }

    /**
     * Limit the number of orders returned by the API. Defaults to 50 Max is 500.
     *
     * @param int $num
     *
     * @throws InvalidData
     *
     * @return ListOrders
     */
    public function take(int $num): self
    {
        if ($num > 500) {
            throw InvalidData::badData('The maximum amount of orders you can list at once is 500.');
        }

        $this->queryParams['limit'] = $num;

        return $this;
    }

    /**
     * The response will include only ones submitted after this timestamp
     * (exclusive.).
     *
     * @param int $timestamp
     *
     * @return ListOrders
     */
    public function after(int $timestamp): self
    {
        $this->queryParams['after'] = $timestamp;

        return $this;
    }

    /**
     * The response will include only ones submitted until this timestamp
     * (exclusive.).
     *
     * @param int $timestamp
     *
     * @return ListOrders
     */
    public function until(int $timestamp): self
    {
        $this->queryParams['until'] = $timestamp;

        return $this;
    }

    /**
     * Set The chronological order of response based on the submission time to
     * ascending.
     *
     * @return ListOrders
     */
    public function asc(): self
    {
        $this->queryParams['direction'] = 'asc';

        return $this;
    }

    /**
     * Set The chronological order of response based on the submission time to
     * descending.
     *
     * @return ListOrders
     */
    public function desc(): self
    {
        $this->queryParams['direction'] = 'desc';

        return $this;
    }

    /**
     * Roll up multi-leg orders under the legs field of primary order.
     *
     * @return ListOrders
     */
    public function nested(): self
    {
        $this->queryParams['nested'] = true;

        return $this;
    }

    /**
     * Filter the orders query to only those which contain the given symbol.
     *
     * @param string $symbol
     *
     * @return ListOrders
     */
    public function whereSymbol(string $symbol): self
    {
        $symbol = strtoupper($symbol);

        $this->queryParams['symbols'] = $symbol;

        return $this;
    }

    /**
     *  Filter the orders query to only those which contain the given symbols.
     *
     * @param array $symbols
     *
     * @return ListOrders
     */
    public function whereSymbols(array $symbols): self
    {
        $symbols = array_map(function ($symbol) {
            return strtoupper($symbol);
        }, $symbols);

        $this->queryParams['symbols'] = join(',', $symbols);

        return $this;
    }
}
