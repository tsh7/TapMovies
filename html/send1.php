<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('test', false, false, false, false);
$msg = new AMQPMessage('hello222');
$channel->basic_publish($msg, '', 'test');

$channel->close();
$connection->close();
?>
