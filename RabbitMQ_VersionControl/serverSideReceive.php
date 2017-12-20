<?php

	require_once __DIR__ . '/vendor/autoload.php';//RabbitMQ library
	use PhpAmqpLib\Connection\AMQPStreamConnection;//RabbitMQ library

    	$connection = new AMQPStreamConnection('192.168.1.101', 5672, 'admin', 'guest');//change ip and rabbitmq account info if needed
	$channel = $connection->channel();//create channel
 	$channel->queue_declare('Receive_Version', false, false, false, false);//open channel
    echo ' * Waiting for messages. To exit press CTRL+C', "\n";//display if it is listening to
	
	$callback = function($msg)
	{
		//Display if message received from Webserver
		echo " * Message received", "\n";

    echo " * Latest version received.", "\n";
    $jdec = json_decode($msg->body, true);
    $Function = $jdec["function"];
    $version = $jdec["args1"];
		if($Function = "install")
		{
			shell_exec('./unzipit.sh $version');
		}
		else
		{
			echo 'Not a possible operation.';
		}	
	};
    $channel->basic_consume('Receive_Version', '', false, true, false, false, $callback);
    while(count($channel->callbacks)) {//keep listen to the rabbitMQ
            $channel->wait();
    }
    $channel->close();
    $connection->close();
    ?>
