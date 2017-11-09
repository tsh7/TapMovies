<?php
	include 'Credential.php';

	$Email = $data["Email"];
	//$Pword = substr($data["Pword"],0,10);
	$Pword = $data["Pword"];
echo $Pword;
	$qry_Login = "SELECT Email,Pword FROM User WHERE Email = '$Email' and Pword='$Pword'";
	$result_Login = mysqli_query($db,$qry_Login);
	$num_rows_Login = mysqli_num_rows($result_Login);

	switch($num_rows_Login){
		case '0':
			$R_Data = array("Function"=>"Login","L_result"=>"Fail");
			break;
		case '1':
			$R_Data = array("Function"=>"Login","L_result"=>"Success");
			break;
		default:
			$R_Data = array("Function"=>"Register","R_result"=>"Error");
	}
	include 'DB_T_WWW.php';
?>
