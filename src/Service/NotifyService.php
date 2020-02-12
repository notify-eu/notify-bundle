<?php

namespace NotifyEu\NotifyBundle\Service;

use NotifyEu\NotifyBundle\Entity\NotifyMessage;

class NotifyService
{
    /** @var NotifyClient */
    protected $client;

    public function __construct(NotifyClient $client)
    {
        $this->client = $client;
    }

    public function send(NotifyMessage $message)
    {
        return $this->client->send($message);
    }
}