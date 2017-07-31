<?php

$host="localhost"; // Host name 
$username="penguinc_urmom"; // Mysql username 
$password="loldongs123"; // Mysql password 
$db_name="penguinc_players"; // Database name 
$tbl_name="chat_ChatUsers"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = md5($mypassword);
$Password = substr($mypassword,16,16) . substr($mypassword,0,16);
$sql="SELECT * FROM $tbl_name WHERE Name='$myusername' and Password='$Password' and IsModerator= 1";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
	$expires = 1 * 1000 * 60 * 60 * 24;
	setcookie("username", $username, time()+$expires);
	setcookie("password", $password, time()+$expires);
header("location:login_success.php");
}
else {
echo "Wrong Username or Password";
}
?>