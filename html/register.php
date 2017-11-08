<?php
print "HELLO";
print "<br>";
include("account.php");
$dbh = mysql_connect($hostname, $username, $password)
                        or die("Unable to connect to MySQL database");
print "Connected to MySQL<br>";
mysql_select_db($project);

include("myfunctions.php");
if (Rnum($user, $email) != 0) {
    die("Duplicate user, Please log in");
} else {
    $user    = $_GET["user"];
    $pwd     = $_GET["pwd"];
    $email   = $_GET["email"];
    $fullname= $_GET["fullname"];
    $address = $_GET["address"];
    $cell    = $_GET["cell"];


    $user = mysql_real_escape_string($user);
    $email = mysql_real_escape_string($email);
    $pwd = mysql_real_escape_string($pwd);
    $fullname = mysql_real_escape_string($fullname);
    $address = mysql_real_escape_string($address);
    $cell = mysql_real_escape_string($cell);


    $hashed = sha1($pwd);
    $check = "select * from secret where hashed = '$hashed'";
    $qk = mysql_query($check);
    (mysql_num_rows($qk) != 0 or ("Sorry Incorrect Password"));

    $s="insert into REGISTERED values ('$user', '$email', '$pwd', '$fullname', '$cell','$address')";
    ($t = mysql_query($s)) or die(mysql_error());

    print "<br> $user was successfully added to the REGISTERED database <br><br>";

    $x = "select * from REGISTERED where user='$user' ";
    ($y = mysql_query($x)) or die(mysql_error());
    while ($r = mysql_fetch_array($y)) {
        $user = $r["user"];
        $email  = $r["email"];
        $fullname = $r["fullname"];
        $cell = $r["cell"];
        $address = $r["address"];
    }
    print("Username: $user <br>Email: $email <br>
		Full Name: $fullname <br>
		Address: $address <br>
		Cell: $cell <br>
		Registered on: $regist_datetime <br>
		Major: $major <br><br>");

    if (!isset($_GET["emailrequest"])) {
        print("Nothing requested; bye!");
    }
    if (isset($_GET["emailrequest"])) {
        $to = $email;
        $subject = "Registration information for $user";
        $message = "Hello $user,
				Username: $user
	            Email: $email
			    Full Name: $fullname
			    Address: $address
			    Cell: $cell
				Thank you for registering";
        mail($to, $subject, $message);
        print("Registration information emailed to $email");
    }
}

?>
