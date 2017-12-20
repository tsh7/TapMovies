<?php

	$newMsg = 'install';
	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqLib\Connection\AMQPStreamConnection;
	use phpQmqpLib\Message\AMQPMessages;

	$connection = new AMPQStreamConnection('192.168.1.101', 5672, 'admin', 'guest');//change ip and rabbitMQ account if needed
        $channel = $connection->channel();

	$channel->queue_declare('Version_T_WebTest', false, false, false, false);
	$msg = new AMQPMessage($newMessage, array('delivery_mode' => 2));//sends the sendVar to the RabbitMQ server
        $channel->basic_publish($msg, '', 'Version_T_WebTest');//send message to API
        $channel->close();
        $connection->close();

        shell_exec("./toWebTest.sh $version");
        echo "Version sent";
