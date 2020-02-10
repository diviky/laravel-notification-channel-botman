<?php

namespace NotificationChannels\BotmanDriver;

use GuzzleHttp\Client as Guzzle;

class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * @var ChannelConfig
     */
    protected $config;

    /**
     * Mobtexting constructor.
     *
     * @param \GuzzleHttp\Client $http
     * @param ChannelConfig     $config
     */
    public function __construct(ChannelConfig $config, $http = null)
    {
        $this->http   = $http ?: new Guzzle();
        $this->config = $config;
    }

    /**
     * Send a MessageAbstract to the a phone number.
     *
     * @param MessageAbstract $message
     * @param string          $to
     * @param bool            $useAlphanumericSender
     *
     * @throws CouldNotSendNotification
     *
     * @return mixed
     */
    public function send(MessageAbstract $message, $to)
    {
        if ($message instanceof MessageAbstract) {
            return $this->sendMessage($message, $to);
        }

        throw CouldNotSendNotification::invalidMessageObject($message);
    }

    /**
     * Send an sms message using the Mobtexting Service.
     *
     * @param Message $message
     * @param string  $to
     *
     * @throws CouldNotSendNotification
     *
     * @return \GuzzleHttp\Client
     */
    protected function sendMessage(MessageAbstract $message, $to)
    {
        $payload    = $message->getPayload();
        $recipients = $to ?: $message->getTo();
        $driver     = $message->getDriverByName();
        $params     = $this->getParams();

        $botman = app('botman');
        $botman->say('Microsoft Teams !', $recipients, $driver, $params);

        return $botman;
    }
}
