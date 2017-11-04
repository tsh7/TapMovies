<?php
    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPConnection;

    $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('DB_T_WWW', false, false, false, false);

    echo ' * Waiting for messages. To exit press CTRL+C', "\n";

    $callback = function($msg){

        echo " * Message received", "\n";

    $data = json_decode($msg->body, true);

    $rgt_Succ = $data["rgt_Succ"];
    echo $rgt_Succ;
    };
    $channel->basic_consume('DB_T_WWW', '', false, true, false, false, $callback);
    while(count($channel->callbacks)) {
            $channel->wait();
    }
    $channel->close();
    $connection->close();
?>

