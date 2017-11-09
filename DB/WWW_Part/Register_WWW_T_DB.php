    <?php
// This is sending part of WWW. WWW sends user info to DB server to create user account
    $Pword_text = "mk612";//password 
    $Hash_Pword = crypt($Pword_text, 'ABCDE12345');//hash password

    $Register= array("Function"=>"Register","Fname" => "Mangab","Lname"=>"Kim","Email"=>"mk621@njit.edu","Pword"=>$Hash_Pword,"Phone"=>"2017239321");
//store user info into an php array

    $data = json_encode($Register);//convert php array into json array

    require_once __DIR__ . '/vendor/autoload.php';//RabbitMQ library
    use PhpAmqpLib\Connection\AMQPConnection;//RabbitMQ library
    use PhpAmqpLib\Message\AMQPMessage;//RabbitMQ library

    $connection = new AMQPConnection('10.0.2.4', 5672, 'admin', 'guest'); //change ip address and RabbitMQ acount
    $channel = $connection->channel();//create channel

    $channel->queue_declare('WWW_T_DB', false, false, false, false);//open channel

    $msg = new AMQPMessage($data, array('delivery_mode' => 2));//store data as rabbitMQ message
    $channel->basic_publish($msg, '', 'WWW_T_DB');//send rabbitMQ message
    $channel->close();//close channel
    $connection->close();//close connection
    include 'DB_T_WWW.php';//After sending user info to the DB server, Webserver need to receive the result from DB. DB_T_WWW.php is the receving part
   ?>
