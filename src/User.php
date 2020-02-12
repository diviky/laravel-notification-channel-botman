<?php

namespace NotificationChannels\BotmanDriver;

class User
{
    /** @var string */
    protected $user = [];

    public function __construct($user = [])
    {
        $user->user_info = is_array($user->user_info) ? $user->user_info : json_decode($user->user_info, true);

        $this->user = (array) $user;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->user['id'];
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->user['username'];
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->user['first_name'];
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->user['last_name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getInfo()
    {
        return $this->user['user_info'];
    }

    public function toArray()
    {
        return $this->user;
    }
}
