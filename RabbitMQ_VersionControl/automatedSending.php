<?php

// This code pushes versions to the Version Control server

	$funcVar = $argv[1];//sets function variable to the first argument placed after the script name
	$versionNum = $argv[2];//sets versionNum to the second argument after the funcVar
	//reads in whatever is typed after the php command.
	
	if($funcVar == "promote(Web or API)")
	{
		$sendVar = $funcVar;
		//if the word promote[your server type] is typed as the argument, sets the sent command as 'promote'
	}
	elseif($funcVar == "test(Web or API)")
	{
		$sendVar = $funcVar;
		//if the word test[your server type] is typed as the argument, sets the sent command as 'test'
	}
	else
	{
		echo $funcVar + "is not a proper command.  Please specify 'promote' or 'test'.";
    //will break if you do not put the proper argument in
	}

	require_once __DIR__ . '/vendor/autoload.php'; //RabbitMQ library
	use PhpAmqpLib\Connection\AMQPStreamConnection;//RabbitMQ library
	use phpQmqpLib\Message\AMQPMessages;//RabbitMQ library

	$connection = new AMPQStreamConnection('192.168.1.101', 5672, 'admin', 'guest');//change ip and rabbitMQ account if needed
	$channel = $connection->channel();//create channel

	$channel->queue_declare('Web/Api_VersionControlPush', false, false, false, false);//open channel.  Start of listening

	$msgArray = array["function"=>$sendVar, "arg1"=>$versionNum];//sends an array with the function variable and the version number
	$jencode = json_encode($msgArray);//json encodes the array
	$msg = new AMQPMessage($msgArray, array('delivery_mode' => 2));//sends the sendVar to the RabbitMQ server
	$channel->basic_publish($msg, '', 'Web/Api_VersionControlPush');//send message to API
	$channel->close();
	$connection->close();

	//include

	shell_exec("./scriptname.sh $versionNum");//zips and sends the version with the Version number
	echo "Version sent";
?>
