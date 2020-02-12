<?php

namespace NotificationChannels\BotmanDriver;

class Message extends MessageAbstract
{
    public function getPayload()
    {
        return $this->payload;
    }

    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }
}
