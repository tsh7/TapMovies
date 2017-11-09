    <?php
//This is receiving part. It continuously listening to the Webserver

    require_once __DIR__ . '/vendor/autoload.php';//RabbitMQ library
    use PhpAmqpLib\Connection\AMQPStreamConnection;//RabbitMQ library

    $connection = new AMQPStreamConnection('10.0.2.4', 5672, 'admin', 'guest');//change ip and rabbitmq account info if needed
    $channel = $connection->channel();//create channel

    $channel->queue_declare('WWW_T_API', false, false, false, false);//open channel

    echo ' * Waiting for messages. To exit press CTRL+C', "\n";//display if it is listening to

    $callback = function($msg){//Display if message received from Webserver

        echo " * Message received", "\n";

    $data = json_decode($msg->body, true);//convert json data to php array

    $Function = $data["Function"];//Store value of the key, Function

    switch ($Function){
	case "Search_movie"://if Function value is "Search_movie", do Search.php
		include 'Search.php';
		break;
	case "TopRate"://if Function value is "TopRate", do TopRate.php
		include 'TopRate.php';
		break;
	default://if data received from Webserver is something wrong, display error message
		echo "Key or value is something wrong";
    }


    };
    $channel->basic_consume('WWW_T_API', '', false, true, false, false, $callback);
    while(count($channel->callbacks)) {//keep listen to the rabbitMQ
            $channel->wait();
    }
    $channel->close();
    $connection->close();
    ?>
