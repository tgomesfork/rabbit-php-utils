<?php

namespace gotchapt\RabbitPhpUtils;

class Config
{
    const CONFIG_FILE = 'config.json';

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $port;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $vhost;

    /**
     * @var string
     */
    private $exchange;

    public function __construct()
    {
        $this->readFromConfigFile();
    }

    /**
     * Get the value of Host.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the value of Host.
     *
     * @param string host
     * @param mixed $host
     *
     * @return self
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get the value of Port.
     *
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the value of Port.
     *
     * @param string port
     * @param mixed $port
     *
     * @return self
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get the value of User.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of User.
     *
     * @param string user
     * @param mixed $user
     *
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of Password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of Password.
     *
     * @param string password
     * @param mixed $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of Vhost.
     *
     * @return string
     */
    public function getVhost()
    {
        return $this->vhost;
    }

    /**
     * Set the value of Vhost.
     *
     * @param string vhost
     * @param mixed $vhost
     *
     * @return self
     */
    public function setVhost($vhost)
    {
        $this->vhost = $vhost;

        return $this;
    }

    /**
     * Get the value of Exchange.
     *
     * @return string
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * Set the value of Exchange.
     *
     * @param string exchange
     * @param mixed $exchange
     *
     * @return self
     */
    public function setExchange($exchange)
    {
        $this->exchange = $exchange;

        return $this;
    }

    private function readFromConfigFile()
    {
        $json = file_get_contents(self::CONFIG_FILE);

        $jsonIterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator(
                json_decode($json, true)
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($jsonIterator as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
    }
}
