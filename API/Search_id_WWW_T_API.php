<?php
//This is search part of WWW. Webserver sends movie name to API.
	$M_id = "54622";//movie name
	$Search = array("Function"=>"Search_movie_id","M_id" => $M_id);//create php array with movie name to send
	$data = json_encode($Search);// convert php array to json data
	require_once __DIR__ . '/vendor/autoload.php';//RabbitMQ library
	use PhpAmqpLib\Connection\AMQPConnection;//RabbitMQ library
	use PhpAmqpLib\Message\AMQPMessage;//RabbitMQ library
	$connection = new AMQPConnection('192.168.1.101', 5672, 'admin', 'guest');//change ip and RabbitMQ account info if needed
	$channel = $connection->channel();//create channel
	$channel->queue_declare('WWW_T_API', false, false, false, false);//open channel
	$msg = new AMQPMessage($data, array('delivery_mode' => 2));//convert json array to rabbitMQ message type
	$channel->basic_publish($msg, '', 'WWW_T_API');//send message
	$channel->close();
	$connection->close();
	include 'Webserver_API_T_WWW.php';// After sending, WWW need to receive the search result. API_T_WWW.php is receving part
?>
