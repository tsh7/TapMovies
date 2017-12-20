    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;

    $connection = new AMQPStreamConnection('192.168.1.201', 5672, 'admin', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('WWW_T_API', false, false, false, false);

    echo ' * Waiting for messages. To exit press CTRL+C', "\n";

    $callback = function($msg){

        echo " * Message received", "\n";

    $data = json_decode($msg->body, true);

    $Function = $data["Function"];

  	switch ($Function){
	case "Search":
		include 'movie.php';
		break;
	case "Top Rated Movies":
		include 'toprated.php';
		break;
	case "Latest Movie":
		include 'latestmovies.php';
		break; 
	default:
		include 'Please TRY Again';
    }



    };
    $channel->basic_consume('WWW_T_API', '', false, true, false, false, $callback);
    while(count($channel->callbacks)) {
            $channel->wait();
    }
    $channel->close();
    $connection->close();
    ?>

