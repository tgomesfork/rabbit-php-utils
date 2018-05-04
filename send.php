<?php

require_once __DIR__.'/vendor/autoload.php';

use gotchapt\RabbitPhpUtils\Message;
use gotchapt\RabbitPhpUtils\MessageSender;
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

class Send extends CLI
{
    const INDEX_PAYLOAD = 0;
    const INDEX_ROUTING_KEY = 1;
    const INDEX_EXCHANGE = 2;

    protected function setup(Options $options)
    {
        $options->setHelp('Simple command to send a message with a given payload and routing key');
        $options->registerArgument('payload', 'Message payload');
        $options->registerArgument('routing-key', 'Message routing key');
        $options->registerArgument('exchange', 'Exchange where message is sent to', false);
    }

    protected function main(Options $options)
    {
        $args = $options->getArgs();
        $message = new Message($args[self::INDEX_PAYLOAD]);

        $messageSender = new MessageSender($message);

        $messageSender->send(
            $message,
            $args[self::INDEX_ROUTING_KEY],
            isset($args[self::INDEX_EXCHANGE]) ? $args[self::INDEX_EXCHANGE] : false
        );
    }
}

// execute it
$cli = new Send();
$cli->run();
