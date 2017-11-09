<?php
	$M_name = "suburbicon";
	$Search = array("Function"=>"Search_movie","M_name" => $M_name);

	$data = json_encode($Search);

	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPConnection;
	use PhpAmqpLib\Message\AMQPMessage;

	$connection = new AMQPConnection('10.0.2.4', 5672, 'admin', 'guest');
	$channel = $connection->channel();

	$channel->queue_declare('WWW_T_API', false, false, false, false);

	$msg = new AMQPMessage($data, array('delivery_mode' => 2));
	$channel->basic_publish($msg, '', 'WWW_T_API');
	$channel->close();
	$connection->close();
	include 'API_T_WWW.php';
?>
