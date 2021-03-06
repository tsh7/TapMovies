<?php
//Receiving part from Webserver to API 

    //RabbitMQ library
    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    
    //change ip and rabbitmq account info if needed
    $connection = new AMQPStreamConnection('192.168.1.101', 5672, 'admin', 'guest');
    
    //create channel
    $channel = $connection->channel();
    
    //open channel
    $channel->queue_declare('WWW_T_API', true, false, false, false);
    
    //display if it is listening to
    echo ' * Waiting for messages. To exit press CTRL+C', "\n";
    
    //Display if message received from Webserver
    $callback = function($msg){
        echo " * Message received", "\n";
        
    //convert json data to php array
    $data = json_decode($msg->body, true);
    
    //Store value of the key, Function
    $Function = $data["Function"];
    
    switch ($Function){
   
  //if Function value is "Search_movie" then it will open Search.php	
  case "Search_movie":
		include 'Search.php';
		break;
	
  //if Function value is "TopRate" then it will open TopRate.php
  case "TopRate":
		include 'TopRate.php';
		break;
	
  //if Function value is "RecentMovie" then it will open RecentMovie.php 
  case "RecentMovie":
		include 'RecentMovie.php';
  		break;
  // if Function value is "Search_id" then it will open Search_id.php 
  case "Search_id":
		include 'Search_id.php';
		break;	
  //if data received from WWW has some problem then it will display error message
  default:
		echo "Please try again";
    }
    };
    $channel->basic_consume('WWW_T_API', '', false, true, false, false, $callback);
    
    //keep listen to the rabbitMQ
    while(count($channel->callbacks)) {
            $channel->wait();
    }
    $channel->close();
    $connection->close();
    ?>
