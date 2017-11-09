    <?php
//This is sending part of WWW for user login. The user info goes to DB server to login

    $Pword_text = 'mk612'; //user password 
    $Hash_Pword = crypt($Pword_text, 'ABCDE12345'); //hashing user password

    $U_inf= array("Function"=>"Login","Email"=>"mk612@njit.edu","Pword"=>$Hash_Pword);//array: user login info: email and password

    $data = json_encode($U_inf);//encode as json array

    require_once __DIR__ . '/vendor/autoload.php';//use rabbitMQ library
    use PhpAmqpLib\Connection\AMQPConnection;//use rabbitMQ library
    use PhpAmqpLib\Message\AMQPMessage;//use rabbitMQ library

    $connection = new AMQPConnection('10.0.2.4', 5672, 'admin', 'guest');//change ip address and rabbitMQ account info
    $channel = $connection->channel();

    $channel->queue_declare('WWW_T_DB', false, false, false, false);//queue name

    $msg = new AMQPMessage($data, array('delivery_mode' => 2));
    $channel->basic_publish($msg, '', 'WWW_T_DB');
    $channel->close();
    $connection->close();
    include 'DB_T_WWW.php'; // After sending the data, Web server need to listen to the DB server for the result. DB_T_WWW.php is receiving part
   ?>
