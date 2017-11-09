    <?php
//hash password
    $Pword_text = "mk612";
    $Hash_Pword = crypt($Pword_text, 'ABCDE12345');

    $Register= array("Function"=>"Register","Fname" => "Mangab","Lname"=>"Kim","Email"=>"mk621@njit.edu","Pword"=>$Hash_Pword,"Phone"=>"2017239321");

    $data = json_encode($Register);

    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    $connection = new AMQPConnection('10.0.2.4', 5672, 'admin', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('WWW_T_DB', false, false, false, false);

    $msg = new AMQPMessage($data, array('delivery_mode' => 2));
    $channel->basic_publish($msg, '', 'WWW_T_DB');
    $channel->close();
    $connection->close();
    include 'DB_T_WWW.php';
   ?>
