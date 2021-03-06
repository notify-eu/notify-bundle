<?php

namespace NotifyEu\NotifyBundle\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    /**
     * @return static
     */
    public static function configurationNotSet()
    {
        return new static('In order to send notification via Notify you need to add credentials in the .env file');
    }
}
