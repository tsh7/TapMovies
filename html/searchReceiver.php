<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


//change rabbitmq ip here
$rmq_ip   = '192.168.1.201';
$rmq_port = '5672';
$rmq_user = 'admin';
$rmq_pass = 'guest';

    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;

    $connection = new AMQPStreamConnection($rmq_ip, $rmq_port, $rmq_user, $rmq_pass);
    $channel = $connection->channel();

    $channel->queue_declare('API_WWW', false, false, false, false);

    echo ' * Waiting for messages. To exit press CTRL+C', "\n";

    $callback = function($msg){

       // echo " * Message received", "\n";

    $R_Data = json_decode($msg->body);
	echo "<pre>";
    	foreach ($R_Data->results as $mydata) {
        	echo $mydata->title . "<br>";
    	}
    	echo "</pre>";
    };

    $channel->basic_consume('API_WWW', '', false, true, false, false, $callback);
    //while(count($channel->callbacks)){
	//$channel->wait();
    //}
    $channel->close();
    $connection->close();
?>

