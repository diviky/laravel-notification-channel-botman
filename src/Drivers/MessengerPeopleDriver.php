<?php

namespace NotificationChannels\BotmanDriver\Drivers;

use BotMan\Drivers\MessengerPeople\MessengerPeopleDriver as BotMessengerPeopleDriver;

class MessengerPeopleDriver extends BotMessengerPeopleDriver
{
    public function getRecipients($message, $recipients)
    {
        $recipients = \is_array($recipients) ? $recipients : [$recipients];

        foreach ($recipients as &$recipient) {
            $recipient = preg_replace("/[^0-9]/", '', $recipient);
        }

        return $recipients;
    }
}
