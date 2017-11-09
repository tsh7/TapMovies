<?php
	include 'Credential.php';

	$Fname = $data["Fname"];
	$Lname = $data["Lname"];
	$Email = $data["Email"];
	//$Pword = substr($data["Pword"],0,10);
	$Pword = $data["Pword"];
	$Phone = $data["Phone"];
echo $Pword;

	$qry_email_check = "SELECT Email FROM User WHERE Email = '$Email'";
	$result_email_check = mysqli_query($db,$qry_email_check);
	$num_rows_email_check = mysqli_num_rows($result_email_check);

	switch($num_rows_email_check){
		case '0':
			$sql = "INSERT INTO User (Fname, Lname, Email, Pword, Phone) VALUES ('$Fname', '$Lname', '$Email', '$Pword', '$Phone')";
			if($db->query($sql) === TRUE){
				$R_Data = array("Function"=>"Register","R_result"=>"Success");
			}
			break;
		case '1':
			$R_Data = array("Function"=>"Register","R_result"=>"Exists");
			break;
		default:
			$R_Data = array("Function"=>"Register","R_result"=>"Error");
	}
	include 'DB_T_WWW.php';
?>
