<?
// Edit Account Information a user
// Flash sends editaccount.php?n=GiraffeMan&p=Password&email=New Email Address&newpassword=New Password
// PHP returns
// id=Users Id

// Get all the variables and common functions
define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
if ($REQUEST_METHOD != "POST") {printf('&e=4','Invalid Input');exit;}	// Only accept it via post
include('setup.inc.php');				// Load the Variables and Code Snippets
ConnectDB();

// Perform all the basic non-database error checking here
if ($n == '') {Dienice('&e=2','Name is Required');}
if ($p == '') {Dienice('&e=26','Password is Required');}
$Name = CleanInput($n);			// Make sure no slashes, but some configuration would already have them added
$Password = CleanInput($p);

// Check for Username
$sql = "SELECT * FROM $Database[TablePrefix]ChatUsers WHERE Name=\"$Name\" LIMIT 1";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
$User = mysql_fetch_array($result);
if (mysql_num_rows($result) == 0) {Dienice("&e=14","Username does not exist");}
mysql_free_result($result);

// Make sure Password Matches
$Password = md5($Password);					// Use md5 to give a 32character representation of the password, this way if someone sees the database they can't see the passwords, they are unknown and lost forever
$Password = substr($Password,16,16) . substr($Password,0,16);	// In case someone is really crafty reorganize the md5 so if they assume it is normal md5 and reverse it then it is still wrong
if ($Password != $User[Password]) 	{Dienice("&e=15","Incorrect Password");}
if ($User[IsBanned] == '1') 		{Dienice("&e=16","Server Unavailable");}

// If they have a new password to set, clean it up
if ($newpassword != '')
	{
	$newpassword = md5($newpassword);					// Use md5 to give a 32character representation of the password, this way if someone sees the database they can't see the passwords, they are unknown and lost forever
	$newpassword = substr($newpassword,16,16) . substr($newpassword,0,16);	// In case someone is really crafty reorganize the md5 so if they assume it is normal md5 and reverse it then it is still wrong
	}
// Otherwise just use their old one
else 	{$newpassword = $Password;}

// If they don't have a new email then just use the old one
if ($email == '')
	{$email = $User[Email];}

// Update their data in the database
$newpassword = CleanForDB($newpassword);
$email = CleanForDB($email);
$sql = "UPDATE $Database[TablePrefix]ChatUsers SET Password = '$newpassword', Email='$email' WHERE UserId = '$User[UserId]'";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

// Send Back Success
printf("&e=0");
mysql_close();
?>