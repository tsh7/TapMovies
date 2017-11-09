<?php
// This is requesting Toprate movies from WWW. Webserver requests top rated movie info to API
	$TopRate= array("Function"=>"TopRate");//only one key and value is used

	$data = json_encode($TopRate);// convert php array, $TopRate, to json data

	require_once __DIR__ . '/vendor/autoload.php';//RabbitMQ library
	use PhpAmqpLib\Connection\AMQPConnection;//RabbitMQ library
	use PhpAmqpLib\Message\AMQPMessage;//RabbitMQ library

	$connection = new AMQPConnection('10.0.2.4', 5672, 'admin', 'guest');//change ip and rabbitMQ account if needed
	$channel = $connection->channel();//create channel

	$channel->queue_declare('WWW_T_API', false, false, false, false);//open channel. Start of listening


	$msg = new AMQPMessage($data, array('delivery_mode' => 2));//convert json data to rabbitMQ message
	$channel->basic_publish($msg, '', 'WWW_T_API');//send message to API
	$channel->close();
	$connection->close();
	include 'API_T_WWW.php'; //After sending request for TopRate, webserver needs to receive the result. API_T_WWW.php is receving part of webserver from API
?>
