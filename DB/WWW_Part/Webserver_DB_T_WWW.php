<?php
//This file is receving part of WWW. Web server will receive data from db server. WWW <- DB

    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPConnection;

    $connection = new AMQPConnection('10.0.2.4', 5672, 'admin', 'guest');//change ip address and rabbitMQ account info
    $channel = $connection->channel();//create channel

    $channel->queue_declare('DB_T_WWW', false, false, false, false);//open channel

    echo ' * Waiting for messages. To exit press CTRL+C', "\n"; //display "I am ready to receive data

    $callback = function($msg){ //When data comes display message

        echo " * Message received", "\n";

    $R_Data = json_decode($msg->body, true);//Return data stored in $R_Data
print_r($R_Data); //print the Data as array
    };

    $channel->basic_consume('DB_T_WWW', '', false, true, false, false, $callback);//create channel
    //while(count($channel->callbacks)){ //stop listening after receiving data from DB
	$channel->wait();
    //}
    $channel->close();
    $connection->close();
?>
