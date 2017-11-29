<?php
//Recent movie file 

  //only one key and value is used
	$RecentMovie= array("Function"=>"RecentMovie");
  
  // convert php array, $RecentMovie, to json data
	$data = json_encode($RecentMovie);
  
  //RabbitMQ library
	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPConnection;
	use PhpAmqpLib\Message\AMQPMessage;
  
  //change ip and rabbitMQ account
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
  
  //After sending request for RecentMovie, webserver needs to receive the result. API_T_WWW.php is receving part of webserver from API
	include 'Webserver_API_T_WWW.php';
?>

