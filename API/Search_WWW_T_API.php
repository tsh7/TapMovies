<?php
//Webserver sends to API (search)
  
  //movie name
	$M_name = "golmaal";
  
  //create php array with movie name to send
	$Search = array("Function"=>"Search_movie","M_name" => $M_name);
	
  // convert php array to json data
  $data = json_encode($Search);
  
  //RabbitMQ library
	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPConnection;
	use PhpAmqpLib\Message\AMQPMessage;
  
  //change ip and RabbitMQ account info if needed
	$connection = new AMQPConnection('192.168.1.101', 5672, 'admin', 'guest');
  
  //create channel
	$channel = $connection->channel();
  
  //open channel
	$channel->queue_declare('WWW_T_API', true, false, false, false);
  
  //convert json array to rabbitMQ message type
	$msg = new AMQPMessage($data, array('delivery_mode' => 2));
  
  //send message
	$channel->basic_publish($msg, '', 'WWW_T_API');
	$channel->close();
	$connection->close();
  
  // Including sending file about result to WWW. 
	include 'Webserver_API_T_WWW.php';
  
  ?>
  
