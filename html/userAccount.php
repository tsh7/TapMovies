<?php
//start session
session_start();
//load and initialize user class
//include 'user.php';
//include websend.php;
//$user = new User();
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
//change rabbitmq ip here
$ip_rmq = '192.168.1.201';
if (isset($_POST['signupSubmit'])) {
    //check whether user details are empty
    if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        //password and confirm password comparison
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Confirm password must match with the password.';
        } else {
            /**
                //check whether user exists in the database
                $prevCon['where'] = array('email'=>$_POST['email']);
                $prevCon['return_type'] = 'count';
                $prevUser = $user->getRows($prevCon);
                if($prevUser > 0){
                    $sessData['status']['type'] = 'error';
                    $sessData['status']['msg'] = 'Email already exists, please use another email.';
                }else{
            */
            //send user data to DB server
            $Pword_text = $_POST['password'];
            $Hash_Pword = crypt($Pword_text, 'ABCDE12345');

            $U_inf= array("Function"=>"Register",
            "Fname" => $_POST['first_name'],
            "Lname"=>$_POST['last_name'],
            "Email"=>$_POST['email'],
            "Pword"=>$Hash_Pword,
            "Phone"=>$_POST['phone']);
            $dataA = json_encode($U_inf);

            /**
                    $userData = array(
                                'first_name' => $_POST['first_name'],
                                'last_name' => $_POST['last_name'],
                                'email' => $_POST['email'],
                                'password' => md5($_POST['password']),
                                'phone' => $_POST['phone']
                            );
            */
            //Rabbitmq send code


            $connection = new AMQPStreamConnection($ip_rmq, 5672, 'admin', 'guest');
            $channel = $connection->channel();

            $channel->queue_declare('WWW_T_DB', false, false, false, false);

            $msg = new AMQPMessage($dataA, array('delivery_mode' => 2));
            $channel->basic_publish($msg, '', 'WWW_T_DB');

            //include receiver.php;
/**
                $insert = $user->insert($userData);
                //set status based on data insert
                if($insert){
                    $sessData['status']['type'] = 'success';
                    $sessData['status']['msg'] = 'You have registered successfully, log in with your credentials.';
                }else{
                    $sessData['status']['type'] = 'error';
                    $sessData['status']['msg'] = 'Some problem occurred, please try again.';
                }
*/
            //}
        }
    } else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
    }
    //store signup status into the session
    $_SESSION['sessData'] = $sessData;
    $redirectURL = ($sessData['status']['type'] == 'success')?'login.php':'registration.php';
    //redirect to the home/registration page
    header("Location:".$redirectURL);
} elseif (isset($_POST['loginSubmit'])) {
    //check whether login details are empty
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $Pword_text = $_POST['password'];
        $Hash_Pword = crypt($Pword_text, 'ABCDE12345');

        $U_infL= array("Function"=>"Login",
        "Email"=>$_POST['email'],
        "Pword"=>$Hash_Pword);

        //$U_inf= array("Function"=>"Login","Email"=>"mk612@njit.edu","Pword"=>$Hash_Pword);

        $dataL = json_encode($u_infL);

        //require_once __DIR__ . '/vendor/autoload.php';
        //use PhpAmqpLib\Connection\AMQPConnection;
        //use PhpAmqpLib\Message\AMQPMessage;

        $connection = new AMQPConnection($ip_rmq, 5672, 'admin', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('WWW_T_DB', false, false, false, false);

        $msg = new AMQPMessage($dataL, array('delivery_mode' => 2));
        $channel->basic_publish($msg, '', 'WWW_T_DB');
        $channel->close();
        $connection->close();
        include 'receiver.php';
        /**
            //get user data from user class
                $conditions['where'] = array(
                    'email' => $_POST['email'],
                    'password' => crypt($_POST['password']),
                    'status' => '1'
                );
                $conditions['return_type'] = 'single';
        */
        $userData = $user->getRows($conditions);
        //set user data and status based on login credentials
        if ($userData) {
            $sessData['userLoggedIn'] = true;
            $sessData['userID'] = $userData['id'];
            $sessData['status']['type'] = 'success';
            $sessData['status']['msg'] = 'Welcome '.$userData['first_name'].'!';
        } else {
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Wrong email or password, please try again.';
        }
    } else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Enter email and password.';
    }
    //store login status into the session
    $_SESSION['sessData'] = $sessData;
    //redirect to the home page
    header("Location:login.php");
} elseif (!empty($_REQUEST['logoutSubmit'])) {
    //remove session data
    unset($_SESSION['sessData']);
    session_destroy();
    //store logout status into the ession
    $sessData['status']['type'] = 'success';
    $sessData['status']['msg'] = 'You have logout successfully from your account.';
    $_SESSION['sessData'] = $sessData;
    //redirect to the home page
    header("Location:login.php");
} else {
    //redirect to the home page
    header("Location:login.php");
}
