<?php
//This processes creating account using the data received from webserver
	include 'Credential.php';//Database access

	$Fname = $data["Fname"];//store first name from the data received from Webserver, user info
	$Lname = $data["Lname"];//store last name from the data received from Webserver, user info
	$Email = $data["Email"];//store email from the data received from Webserver, user info
	$Pword = $data["Pword"];//store password from the data received from Webserver, user info
	$Phone = $data["Phone"];//store Phone # from the data received from Webserver, user info
echo $Pword;//test purpose

//check if email account exists or not before creating the account
	$qry_email_check = "SELECT Email FROM User WHERE Email = '$Email'";//define query
	$result_email_check = mysqli_query($db,$qry_email_check);//process query
	$num_rows_email_check = mysqli_num_rows($result_email_check);//store the query result

	switch($num_rows_email_check){
		case '0'://if the result is 0, create account in Database.
			$sql = "INSERT INTO User (Fname, Lname, Email, Pword, Phone) VALUES ('$Fname', '$Lname', '$Email', '$Pword', '$Phone')";
			if($db->query($sql) === TRUE){
				$R_Data = array("Function"=>"Register","R_result"=>"Success");
			}
			break;
		case '1': //If the result is 1, the user account exists. Return error message
			$R_Data = array("Function"=>"Register","R_result"=>"Exists");
			break;
		default://if others, something went worng
			$R_Data = array("Function"=>"Register","R_result"=>"Error");
	}
	include 'DB_T_WWW.php';//return the result to the Web server
?>
