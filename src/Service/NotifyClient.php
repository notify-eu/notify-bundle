<?php

namespace NotifyEu\NotifyBundle\Service;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use NotifyEu\NotifyBundle\Entity\NotifyMessage;
use NotifyEu\NotifyBundle\Exceptions\CouldNotSendNotification;
use NotifyEu\NotifyBundle\Exceptions\InvalidConfiguration;
use NotifyEu\NotifyBundle\Exceptions\InvalidMessageObject;

class NotifyClient
{
    /**
     * @var string
     */
    protected $apiUrl = 'https://api.notify.eu/notification/send';

    /**
     * @var string
     */
    protected $config;

    /**
     * @var Client
     */
    protected $client;

    /**
     * NotifyClient constructor.
     * @param Client $client
     * @param array $config
     */
    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param NotifyMessage $message
     */
    public function validateMessage(NotifyMessage $message)
    {
        if (empty($message->getTo())) {
            throw InvalidMessageObject::missingRecipient();
        }
        if (empty($message->getClientId()) || empty($message->getSecret())) {
            throw InvalidConfiguration::configurationNotSet();
        }
        if (empty($message->getNotificationType())) {
            throw InvalidMessageObject::missingNotificationType();
        }
        if (empty($message->getTransport())) {
            throw InvalidMessageObject::missingTransport();
        }
        if (empty($message->getTo())) {
            throw InvalidMessageObject::missingRecipient();
        }
    }

    /**
     * @param NotifyMessage $message
     * @return string
     */
    public function send(NotifyMessage $message)
    {
        $message->setClientId($this->config['client_id']);
        $message->setSecret($this->config['secret']);
        if (empty($message->getTransport())) {
            $message->setTransport($this->config['transport']);
        }

        $this->validateMessage($message);
        $this->apiUrl = isset($this->config['url']) ? $this->config['url'] : $this->apiUrl;

        try {
            $response = $this->client->request('POST', $this->apiUrl, [
                'body' => json_encode($message),
            ]);

            if ($response) {
                return json_decode($response->getBody()->getContents(), true);
            }
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithNotify($exception);
        }
    }
}
