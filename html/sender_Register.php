    <?php
//hash password
    $Pword_text = "mk612";
    $Hash_Pword = crypt($Pword_text, 'ABCDE12345');

    $U_inf= array("Function"=>"Register","Fname" => "Mangab","Lname"=>"Kim","Email"=>"mk612@njit.edu","Pword"=>$Hash_Pword,"Phone"=>"2017239321");

    $data = json_encode($U_inf);

    require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    $connection = new AMQPConnection('192.168.1.101', 5672, 'admin', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('WWW_T_DB', false, false, false, false);

    $msg = new AMQPMessage($data, array('delivery_mode' => 2));
    $channel->basic_publish($msg, '', 'WWW_T_DB');
    $channel->close();
    $connection->close();
    include 'receiver.php';
   ?>
