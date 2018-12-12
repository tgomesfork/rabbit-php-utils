<?php

namespace gotchapt\RabbitPhpUtils;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class MessageSender
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    public function __construct()
    {
        $this->config = new Config();
        $this->connection = new AMQPStreamConnection(
            $this->config->getHost(),
            $this->config->getPort(),
            $this->config->getUser(),
            $this->config->getPassword(),
            $this->config->getVhost()
        );
    }

    public function send(Message $message, $routingKey, $exchange = false)
    {
        $exchange = $exchange ?: $this->config->getExchange();
        $channel = $this->connection->channel();
        $msg = new AMQPMessage($message->getPayload());
        if (!empty($message->getHeaders())) {
            $msg->set('application_headers', new AMQPTable($message->getHeaders()));
        }
        $channel->basic_publish($msg, $exchange, $routingKey);

        echo " [x] Sent message with key $routingKey to $exchange\n";

        $channel->close();
        $this->connection->close();
    }

    /**
     * Get the value of Config
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the value of Config
     *
     * @param Config config
     *
     * @return self
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the value of Message
     *
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of Message
     *
     * @param Message message
     *
     * @return self
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;

        return $this;
    }

}
