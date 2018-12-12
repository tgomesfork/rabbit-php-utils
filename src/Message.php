<?php

namespace gotchapt\RabbitPhpUtils;

class Message
{
    /**
     * @var string
     */
    private $payload;

    /**
     * @var array
     */
    private $headers;

    /**
     * @param string $payload
     */
    public function __construct($payload, $headers)
    {
        $this->payload = $payload;
        $this->headers = $headers;
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
     * @param string $payload
     *
     * @return self
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Get the value of Headers
     *
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the value of Headers
     *
     * @param array $headers
     *
     * @return self
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

}
