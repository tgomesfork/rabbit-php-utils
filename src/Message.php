<?php

namespace gotchapt\RabbitPhpUtils;

class Message
{
    /**
     * @var string
     */
    private $payload;

    /**
     * @param string $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Get the value of Payload
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Set the value of Payload
     *
     * @param string payload
     *
     * @return self
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

}
