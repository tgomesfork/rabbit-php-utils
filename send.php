<?php

require_once __DIR__.'/vendor/autoload.php';

use gotchapt\RabbitPhpUtils\Message;
use gotchapt\RabbitPhpUtils\MessageSender;
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

class Send extends CLI
{
    const INDEX_ROUTING_KEY = 0;
    const INDEX_EXCHANGE = 1;

    protected function setup(Options $options)
    {
        $options->setHelp('Simple command to send a message with a given payload and routing key');
        $options->registerArgument('routing-key', 'Message routing key');
        $options->registerArgument('exchange', 'Exchange where message is sent to', false);
        $options->registerOption('stdin-payload', 'Message payload');
        $options->registerOption('file-payload', 'File with json payload', 'p', 'file-payload');
        $options->registerOption('file-headers', 'File with json headers', 'h', 'file-headers');
    }

    protected function main(Options $options)
    {
        $args = $options->getArgs();
        $inputPayload = $options->getOpt('payload');
        $filePayload = $options->getOpt('file-payload');
        $fileHeaders = $options->getOpt('file-headers');

        $payload = $filePayload ? json_decode(trim(file_get_contents($filePayload)), true) : $inputPayload;

        if (empty($payload)) {
            throw new \Exception('Empty payload');
        }

        $headers = $fileHeaders
            ? json_decode(trim(file_get_contents($fileHeaders)), true)
            : [];
        ;

        if ($fileHeaders && empty($payload)) {
            throw new \Exception('Malformed headers');
        }

        try {
            $message = new Message(json_encode($payload, true), $headers);

            $messageSender = new MessageSender();
            $messageSender->send(
                $message,
                $args[self::INDEX_ROUTING_KEY],
                isset($args[self::INDEX_EXCHANGE]) ? $args[self::INDEX_EXCHANGE] : false
            );
        } catch (\Exception $e) {
            echo $e->getTraceAsString();

            throw $e;
        }
    }
}

// execute it
$cli = new Send();
$cli->run();
