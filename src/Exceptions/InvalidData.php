<?php

namespace Lukasyelle\AlpacaSdk\Exceptions;

use Exception;

class InvalidData extends Exception
{
    /**
     * @param array $params
     *
     * @return static
     */
    public static function missingParams(array $params)
    {
        return new static('Endpoint requires parameters: ' . implode(',', $params));
    }

    /**
     * @param array $params
     *
     * @return static
     */
    public static function emptyPayloadOnPost()
    {
        return new static('POST requests must have a payload.');
    }

    /**
     * @param string $message
     *
     * @return static
     */
    public static function badData(string $message)
    {
        return new static($message);
    }
}