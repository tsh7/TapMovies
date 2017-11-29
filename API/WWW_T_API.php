<?php
//Receiving part from Webserver to API 

    //RabbitMQ library
    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    
    //change ip and rabbitmq account info if needed
    $connection = new AMQPStreamConnection('10.0.2.15', 5672, 'admin', 'admin');
    
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
    //if Function value is "Search_movie", do Search.php
	
  case "Search_movie":
		include 'Search.php';
		break;
	
  //if Function value is "TopRate", do TopRate.php
  case "TopRate":
		include 'TopRate.php';
		break;
	
  //if Function value is "RecentMovie", do RecentMovie.php
  case "RecentMovie":
		include 'RecentMovie.php';
		break;
	
  //if data received from Webserver is something wrong, display error message
  default:
		echo "Key or value is something wrong";
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
