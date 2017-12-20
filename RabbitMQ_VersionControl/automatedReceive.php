<?php

	require_once __DIR__ . '/vendor/autoload.php';//RabbitMQ library
	use PhpAmqpLib\Connection\AMQPStreamConnection;//RabbitMQ library

	$connection = new AMQPStreamConnection('192.168.1.101', '5672', 'admin', 'guest');//change ip and rabbitmq account info if needed
	$channel = $connection->channel();//create channel

	$channel->queue_declare('VersionPush', false, false, false, false);//open channel

	echo ' * Waiting for latest version.  To exit press CTRL+C', "\n";//display if it is listening
	
	$callback = function($msg)
	{
		echo " * Latest version received.", "\n";
		$jdec = json_decode($msg->body, true);
		$Function = $jdec["function"];
		$version = $jdec["args1"];
		switch ($Function)
		{
			case "promoteapi"://if the function is 'promoteapi', sends and installs all the latest version to the Live API server
				include "VerTAPI.php";
				break;

			case "promotedb"://if the function is 'promotedb', sends and installs all the latest version to Live Database server
				include "VerTDB.php";
				break;

			case "promoteweb"://if the function is 'promoteweb', sends and installs all the latest version to Live Web server
				include "VerTWeb.php";
				break;

			case "testapi"://if the function is 'testapi', sends and installs all the latest version to Test API server
				include "VerTAPItest.php";
				break;

			case "testdb"://if the function is 'testdb', sends and installs all the latest version to the Test Database server
				include "VerTDBtest.php";
				break;

			case "testweb"://if the function is 'testweb', sends and installs all the latest version to the Test Web server
				include "VerTWebTest.php";
				break;

			default://if they none of the above occurs, fail out
				echo "Operation cannot be performed";
		}
	};
	$channel->basic_consume('VersionPush', '', false, true, false, false, $callback);
	while(count($channel->callbacks))
	{
		$channel->wait();
	}

	$channel->close();
?>
