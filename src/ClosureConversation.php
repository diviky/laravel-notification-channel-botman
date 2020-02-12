<?php

namespace NotificationChannels\BotmanDriver;

use BotMan\BotMan\Messages\Conversations\Conversation;
use Closure;

class ClosureConversation extends Conversation
{
    protected $closure = null;

    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function run()
    {
        $this->closure($this->bot);
    }
}
