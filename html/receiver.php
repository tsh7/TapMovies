<?php
    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPConnection;

    $connection = new AMQPConnection('192.168.1.101', 5672, 'admin', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('DB_T_WWW', false, false, false, false);

    echo ' * Waiting for messages. To exit press CTRL+C', "\n";

    $callback = function($msg){

        echo " * Message received", "\n";

    $R_Data = json_decode($msg->body, true);
	print_r($R_Data);
    };

    $channel->basic_consume('DB_T_WWW', '', false, true, false, false, $callback);
    //while(count($channel->callbacks)){
	$channel->wait();
    //}
    $channel->close();
    $connection->close();
?>

