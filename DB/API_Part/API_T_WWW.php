<?php
//This is sending part of API. After processing tasks, it returns the result to the Webserver
    $r_data = json_encode($php_data);//convert $php_data array to json data

    require_once __DIR__ . '/vendor/autoload.php';//ribbitMQ library
    use PhpAmqpLib\Connection\AMQPStreamConnection;//ribbitMQ library
    use PhpAmqpLib\Message\AMQPMessage;//ribbitMQ library

    $connection = new AMQPStreamConnection('10.0.2.4', 5672, 'admin', 'guest');//change ip and rabbitMQ account info if needed
    $channel = $connection->channel();//create channel

    $channel->queue_declare('API_T_WWW', false, false, false, false);//open channel

    $msg = new AMQPMessage($r_data, array('delivery_mode' => 2));//convert json data to rabbitMQ message
    $channel->basic_publish($msg, '', 'API_T_WWW');//send message to Webserver
    $channel->close();
    $connection->close();
//print_r($r_data);//test purpose to see if the result is good or not
?>
