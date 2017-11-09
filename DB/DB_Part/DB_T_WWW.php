<?php
//This is sending part of DB. It returns after processing the work to the Webserver
    $r_data = json_encode($R_Data);//receive $R_Data from other files after processing tasks, and convert it to json data

    require_once __DIR__ . '/vendor/autoload.php';//RabbitMQ library
    use PhpAmqpLib\Connection\AMQPStreamConnection;//RabbitMQ library
    use PhpAmqpLib\Message\AMQPMessage;//RabbitMQ library

    $connection = new AMQPStreamConnection('10.0.2.4', 5672, 'admin', 'guest');//change ip and rabbitMQ account info if needed
    $channel = $connection->channel();//create channel

    $channel->queue_declare('DB_T_WWW', false, false, false, false);//open channel

    $msg = new AMQPMessage($r_data, array('delivery_mode' => 2));//convert json data to rabbitMQ message
    $channel->basic_publish($msg, '', 'DB_T_WWW');//send message to webserver
    $channel->close();
    $connection->close();
print_r($R_Data);//print after successfully finished its task
?>
