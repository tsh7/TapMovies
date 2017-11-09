<?php
// This processes login part in DB. It checks if the user account exist or not
	include 'Credential.php';//DB account access

	$Email = $data["Email"];//store Email address from the data received from Webserver to $Email
	$Pword = $data["Pword"];//store password from the data received from Webserver to $Pword
echo $Pword;//Test purpose
	$qry_Login = "SELECT Email,Pword FROM User WHERE Email = '$Email' and Pword='$Pword'";//declare query
	$result_Login = mysqli_query($db,$qry_Login);//process query
	$num_rows_Login = mysqli_num_rows($result_Login);//receive the result from the DB

	switch($num_rows_Login){//if the result is 0, no account exists. If the result is 1, account exists. If others result, error.
		case '0':
			$R_Data = array("Function"=>"Login","L_result"=>"Fail");
			break;
		case '1':
			$R_Data = array("Function"=>"Login","L_result"=>"Success");
			break;
		default:
			$R_Data = array("Function"=>"Register","R_result"=>"Error");
	}
	include 'DB_T_WWW.php';//send the result to Webserver
?>
