<?php

namespace Lukasyelle\AlpacaSdk\Exceptions;

use Exception;

class InvalidConfig extends Exception
{
    public static function apiKeyNotSpecified()
    {
        return new static('An API key is required to access this data and no key was provided');
    }

    public static function baseUrlNotSpecified($api)
    {
        return new static("You must provide a valid Base URL for the $api API");
    }

    public static function improperTestingConfig($message)
    {
        return new static($message);
    }
}