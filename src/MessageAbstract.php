<?php

namespace NotificationChannels\BotmanDriver;

use NotificationChannels\BotmanDriver\Drivers\BotFrameworkDriver;

abstract class MessageAbstract
{
    /**
     * The message content.
     *
     * @var string
     */
    public $payload;

    /**
     * The phone number the message should be sent driver.
     *
     * @var string
     */
    public $driver;

    /**
     * The phone number the message should be sent to.
     *
     * @var string
     */
    public $to;

    /**
     * @var array
     */
    public $params = [];

    protected $drivers = [
        'botframework' => BotFrameworkDriver::class,
    ];

    /**
     * Create a new message instance.
     *
     * @param string $text
     */
    public function __construct($payload = [])
    {
        $this->setPayload($payload);
    }

    /**
     * Create a message object.
     *
     * @param string $text
     *
     * @return static
     */
    public static function create($payload = [])
    {
        return new static($payload);
    }

    /**
     * Set the phone number the message should be sent driver.
     *
     * @param string $driver
     *
     * @return $this
     */
    public function driver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Set the phone number the message should be sent to.
     *
     * @param string $driver
     * @param mixed  $to
     *
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get the driver address.
     *
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    public function getDriverByName()
    {
        return $this->drivers[$this->driver] ?: $this->driver;
    }

    /**
     * Get the phone number the message should be sent to.
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Get the value of params.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set Param.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return self
     */
    public function setParam($key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * Set Param.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return self
     */
    public function getParam($key, $default = null)
    {
        if (isset($this->params[$key])) {
            return $this->params[$key];
        };

        return $default;
    }

    /**
     * Set the value of params.
     *
     * @param array $params
     *
     * @return self
     */
    public function setParams(array $params)
    {
        $this->params = \array_merge($this->params, $params);

        return $this;
    }
}
