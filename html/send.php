<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('192.168.1.101', 5672, 'admin', 'guest');
$channel = $connection->channel();
$channel->queue_declare('test', false, false, false, false);
$msg = new AMQPMessage('hello111');
$channel->basic_publish($msg, '', 'test');

$channel->close();
$connection->close();
?>
