<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$host = 'localhost';
$port = 5672;
$user = 'lafourchette';
$password = 'lafourchette';
$vhost = '/lafourchette';
$exchange = 'lf.exchange.myfourchette';

$args = getopt("p:r:e");
$exchange = isset($args['e']) ? $args['e'] : $exchange;

if (!isset($args['p']) || !isset($args['r'])) {
    echo "Missing arguments. Command should be run like:\nphp send.php -p \"{}\" -r \"routing-key\" [-e \"exchange\"]\n";
    exit(1);
}

$payload = $args['p'];
$routingKey = $args['r'];

$connection = new AMQPStreamConnection('localhost', 5672, $user, $password, $vhost);
$channel = $connection->channel();

$msg = new AMQPMessage($payload);
$res = $channel->basic_publish($msg, $exchange, $routingKey);

echo " [x] Sent message with key $routingKey to $exchange\n";

$channel->close();
$connection->close();
