<?php

	$newMsg = 'install';
	require_once __DIR__ . '/vendor/autoload.php'; //RabbitMQ library
	use PhpAmqpLib\Connection\AMQPStreamConnection;
	use PhpAmqpLib\Message\AMQPMessage;
	$connection = new AMQPStreamConnection('192.168.1.101', 5672, 'admin', 'guest');//change ip and rabbitMQ account if needed
	$channel = $connection->channel();//create channel

	$channel->queue_declare('Version_T_WebLive', false, false, false, false);
	$msgArray = array("function"=>$newMsg, "arg1"=>$versionNum);
	$jencode = json_encode($msgArray);
	$msg = new AMQPMessage($msgArray, array('delivery_mode' => 2));//sends the sendVar to the RabbitMQ server
        $channel->basic_publish($msg, '', 'Version_T_WebLive');//send message to API
        $channel->close();
        $connection->close();

        shell_exec("./toWebLive.sh $version");
        echo "Version sent";
