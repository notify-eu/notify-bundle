<?php

namespace NotifyEu\NotifyBundle\Exceptions;

use Exception;

class InvalidMessageObject extends Exception
{
    /**
     * @return static
     */
    public static function missingNotificationType()
    {
        return new static('Notification was not sent. Missing `notificationType` param');
    }

    /**
     * @return static
     */
    public static function missingTransport()
    {
        return new static('Notification was not sent. Missing `transport` param');
    }

    /**
     * @return static
     */
    public static function missingRecipient()
    {
        return new static('Notification was not sent. Add a recipient to your message.');
    }

    /**
     * @return static
     */
    public static function misconfiguredRecipient()
    {
        return new static('Notification was not sent. The recipient needs to contain fields name & recipient');
    }
}
