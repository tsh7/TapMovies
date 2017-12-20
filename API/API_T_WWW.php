<?php
//Seding file to Web Server. 

    //convert php array to json data
    $r_data = json_encode($php_data);
    
    //rabbbitMQ library
    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;
    
    //change ip and rabbitMQ account info if needed
    $connection = new AMQPStreamConnection('192.168.1.101', 5672, 'admin', 'guest');
    
    //create channel
    $channel = $connection->channel();
    
    //open channel
    $channel->queue_declare('API_T_WWW', true, false, false, false);
    
    //convert json data to rabbitMQ message
    $msg = new AMQPMessage($r_data, array('delivery_mode' => 2));
    
    //send message to Webserver
    $channel->basic_publish($msg, '', 'API_T_WWW');
    $channel->close();
    $connection->close();
?>
