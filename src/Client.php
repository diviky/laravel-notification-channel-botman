<?php

namespace NotificationChannels\BotmanDriver;

use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Closure;
use GuzzleHttp\Client as Guzzle;
use NotificationChannels\BotmanDriver\ClosureConversation;

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
     * @return \GuzzleHttp\Client
     */
    protected function sendMessage(MessageAbstract $message, $to)
    {
        $payload    = $message->getPayload();
        $recipients = $message->getTo() ?: $to;
        $driver     = $message->getDriverByName();

        $botman = $this->loadBotMan($driver);

        $recipients = $botman->getDriver()->getRecipients($message, $recipients);

        if ($payload instanceof Closure) {
            return $botman->startConversation(new ClosureConversation($payload), $recipients, $driver);
        }

        if ($payload instanceof Conversation) {
            return $botman->startConversation($payload->setMessage($message), $recipients, $driver);
        }

        $params = $message->getParams();

        $botman->say($payload, $recipients, $driver, $params);

        return $botman;
    }

    protected function loadBotMan($driver, $config = [])
    {
        DriverManager::loadDriver($driver);

        $botman = app('botman');
        $botman->loadDriver($driver);

        return $botman;
    }
}
