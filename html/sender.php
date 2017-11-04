    <?php
    $myObj = new \stdClass();
    $myObj->fname = "YO";
    $myObj->lname = "THIS";
    $myObj->email = "yothis@njit.edu";
    $myObj->pword = "yoyoyo";
    $data = json_encode($myObj);

    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

    $connection = new AMQPStreamConnection('192.168.1.101', 5672, 'admin', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('WWW_T_DB', false, false, false, false);

    $msg = new AMQPMessage($data, array('delivery_mode' => 2));
    $channel->basic_publish($msg, '', 'WWW_T_DB');
    
    //include 'receiver.php';

   ?>
