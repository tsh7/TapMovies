    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;

    $connection = new AMQPStreamConnection('10.0.2.4', 5672, 'admin', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('WWW_T_DB', false, false, false, false);

    echo ' * Waiting for messages. To exit press CTRL+C', "\n";

    $callback = function($msg){

        echo " * Message received", "\n";

    $data = json_decode($msg->body, true);

    $Function = $data["Function"];

    switch ($Function){
	case "Register":
		include 'Register.php';
		break;
	case "Login":
		include 'Login.php';
		break;
	default:
		include 'unknow_error.php';
    }


    };
    $channel->basic_consume('WWW_T_DB', '', false, true, false, false, $callback);
    while(count($channel->callbacks)) {
            $channel->wait();
    }
    $channel->close();
    $connection->close();
    ?>
