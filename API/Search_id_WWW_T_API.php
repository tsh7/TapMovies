<?php
//WWW sends request to API 

	//movie id 
	$M_id = "54622";

	//php array with movie id 
	$Search = array("Function"=>"Search_movie_id","M_id" => $M_id);
	
	// convert php to json
	$data = json_encode($Search);
	
	//RabbitMQ libraries 
	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPConnection;
	use PhpAmqpLib\Message\AMQPMessage;
	
	//RabbitMQ account information 
	$connection = new AMQPConnection('192.168.1.101', 5672, 'admin', 'guest');
	
	//create new channels 
	$channel = $connection->channel();
	
	//open channels 
	$channel->queue_declare('WWW_T_API', false, false, false, false);
	
	//convert json data to rabbitMQ message to communicate 
	$msg = new AMQPMessage($data, array('delivery_mode' => 2));

	//send message to API 
	$channel->basic_publish($msg, '', 'WWW_T_API');

	//close channel and connection 
	$channel->close();
	$connection->close();

// Including WWW receiving file to receive result. 
	include 'Webserver_API_T_WWW.php';
?>
