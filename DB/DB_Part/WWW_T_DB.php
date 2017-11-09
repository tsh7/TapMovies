    <?php
//This is receiving part of DB. It continuously listens to the Webserver
    require_once __DIR__ . '/vendor/autoload.php';//RabbitMQ library
    use PhpAmqpLib\Connection\AMQPStreamConnection;//RabbitMQ library

    $connection = new AMQPStreamConnection('10.0.2.4', 5672, 'admin', 'guest');//change ip and rabbitMQ account info if needed
    $channel = $connection->channel();//create channel

    $channel->queue_declare('WWW_T_DB', false, false, false, false);//open channel

    echo ' * Waiting for messages. To exit press CTRL+C', "\n";//print if DB is listening to RabbitMQ

    $callback = function($msg){//if message received from RabbitMQ, display message

        echo " * Message received", "\n";

    $data = json_decode($msg->body, true);//convert json data to php array

    $Function = $data["Function"];//Figure out what the webserver wants database do

    switch ($Function){
	case "Register"://if the function is Register, process register
		include 'Register.php';
		break;
	case "Login"://if the function is Login, process login
		include 'Login.php';
		break;
	default://if something else, error
		echo "Function key or value is wrong";
    }
    };
    $channel->basic_consume('WWW_T_DB', '', false, true, false, false, $callback);
    while(count($channel->callbacks)) {//keep open the channel
            $channel->wait();
    }
    $channel->close();
    $connection->close();
    ?>
