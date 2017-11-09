<?php
    $r_data = json_encode($php_data);

    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    $connection = new AMQPStreamConnection('10.0.2.4', 5672, 'admin', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('API_T_WWW', false, false, false, false);

    $msg = new AMQPMessage($r_data, array('delivery_mode' => 2));
    $channel->basic_publish($msg, '', 'API_T_WWW');
    $channel->close();
    $connection->close();
//print_r($r_data);
?>
