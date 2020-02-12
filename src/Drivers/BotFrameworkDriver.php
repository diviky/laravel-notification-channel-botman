<?php

namespace NotificationChannels\BotmanDriver\Drivers;

use BotMan\Drivers\BotFramework\BotFrameworkDriver as BotManBotFrameworkDriver;

class BotFrameworkDriver extends BotManBotFrameworkDriver
{
    public function getRecipients($message, $recipients)
    {
        $info = $message->getUser()->getInfo();

        if ($info['cid']) {
            return $info['cid'];
        }

        $params = $message->getParams();

        $recipients = \is_array($recipients) ? $recipients : [$recipients];

        $members = [];

        foreach ($recipients as $recipient) {
            $members[] = ['id' => $recipient];
        }

        $parameters = [
            'bot'         => $info['bot'],
            'members'     => $members,
            'channelData' => [
                'tenant' => $info['tenant'],
            ],
        ];

        $headers = [
            'Content-Type:application/json',
            'Authorization:Bearer ' . $this->getAccessToken(),
        ];

        $apiURL   = $info['service_url'] ?: $params['serviceUrl'];
        $response = $this->http->post($apiURL . '/v3/conversations', [], $parameters, $headers, true);

        $responseData = json_decode($response->getContent());

        return $responseData->id;
    }
}
