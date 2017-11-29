<?php
//Receiving part of WWWW.

//RabbitMQ
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;

//Change IP address and rabbitMQ access account info
$connection = new AMQPConnection('10.0.2.15', 5672, 'admin', 'admin'); 
$channel = $connection->channel();

//declare queue name WWW <- API
$channel->queue_declare('API_T_WWW', true, false, false, false);
echo ' * Waiting for messages. To exit press CTRL+C', "\n";
$callback = function($msg){
echo " * Message received", "\n";
$R_Data = json_decode($msg->body, true);

//print received data
print_r($R_Data); 
};
$channel->basic_consume('API_T_WWW', '', false, true, false, false, $callback);

//stop listening from API after receiving data once
//while(count($channel->callbacks)){ 
$channel->wait();
//}
$channel->close();
$connection->close();
?>
