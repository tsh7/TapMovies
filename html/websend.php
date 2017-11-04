    <?php
//session_start();
    $myObj = new \stdClass();
    $myObj->fname = $_POST['first_name'];
    $myObj->lname = $_POST['last_name'];
    $myObj->email = $_POST['email'];
    $myObj->pword = $_POST['password'];
    $data = json_encode($myObj);

    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    $connection = new AMQPConnection('192.168.1.101', 5672, 'admin', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('WWW_T_DB', false, false, false, false);

    $msg = new AMQPMessage($data, array('delivery_mode' => 2));
    $channel->basic_publish($msg, '', 'WWW_T_DB');
    
    include 'receiver.php';

   ?>
