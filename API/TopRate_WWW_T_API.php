<?php
//Requesting data from Webserver to API and then tmdb
  
  //only one key and value is used
	$TopRate= array("Function"=>"TopRate");
  
  // convert php array to json data
	$data = json_encode($TopRate);
  
  //RabbitMQ library
	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPConnection;
	use PhpAmqpLib\Message\AMQPMessage;
  
  //change ip and rabbitMQ account if needed
	$connection = new AMQPConnection('10.0.2.15', 5672, 'admin', 'admin');
  
  //create channel
	$channel = $connection->channel();
  
  //open channel. Start of listening
	$channel->queue_declare('WWW_T_API', true, false, false, false);
  
  //convert json data to rabbitMQ message
	$msg = new AMQPMessage($data, array('delivery_mode' => 2));
  
  //send message to API
	$channel->basic_publish($msg, '', 'WWW_T_API');
	$channel->close();
	$connection->close();
  
  //sending request webserver needs to receive the result. 
	include 'Webserver_API_T_WWW.php'; 
?>
