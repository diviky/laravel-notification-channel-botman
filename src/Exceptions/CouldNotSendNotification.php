<?php

namespace NotificationChannels\BotmanDriver\Exceptions;

use NotificationChannels\BotmanDriver\SmsMessage;

class CouldNotSendNotification extends \Exception
{
    /**
     * @param mixed $message
     *
     * @return static
     */
    public static function invalidMessageObject($message)
    {
        $className = \get_class($message) ?: 'Unknown';

        return new static(
            "Notification was not sent. Message object class `{$className}` is invalid. It should
            be either `" . SmsMessage::class);
    }

    /**
     * @return static
     */
    public static function invalidReceiver()
    {
        return new static(
            'The notifiable did not have a recipients. Add a routeNotificationFor
            method or a recipients attribute to your notifiable.'
        );
    }

    public static function serviceRespondedWithAnError($response)
    {
        $className = \get_class($message) ?: 'Unknown';

        return new static($className . ' responded with an error: `' . $response->getBody()->getContents() . '`');
    }
}
