<?
// LOGIN a user
// Flash sends register.php?n=GiraffeMan&p=Password&email=Email Address
// PHP returns

// Get all the variables and common functions
define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
// if ($REQUEST_METHOD != "POST") {printf('&e=4','Invalid Input');exit;}	// Only accept it via post
include('setup.inc.php');				// Load the Variables and Code Snippets
ConnectDB();

// Perform all the basic non-database error checking here
if ($n == '') {Dienice('&e=2','Name is Required');}
if ($p == '') {Dienice('&e=26','Password is Required');}
if ($email == '') {Dienice('&e=27','Email is Required');}

$Name = CleanInput($n);			// Make sure no slashes, but some configuration would already have them added
$Password = CleanInput($p);
$Email = CleanInput($email);

// Check for Username Already Taken
$sql = "SELECT * FROM $Database[TablePrefix]ChatUsers WHERE Name='$Name' LIMIT 1";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
if (mysql_num_rows($result) > 0) {Dienice("&e=28","Username already Taken, Please try a different variation");}

$sql = "SELECT * FROM $Database[TablePrefix]ChatUsers WHERE Email='$Email' LIMIT 1";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
if (mysql_num_rows($result) > 0) {Dienice("&e=29","That Email address already has an account, Click on lost password to recover it");}

// Generate Password
$Password = md5($Password);					// Use md5 to give a 32character representation of the password, this way if someone sees the database they can't see the passwords, they are unknown and lost forever
$Password = substr($Password,16,16) . substr($Password,0,16);	// In case someone is really crafty reorganize the md5 so if they assume it is normal md5 and reverse it then it is still wrong

// Update their data in the database
$Name = CleanForDB($Name);
$Password = CleanForDB($Password);
$Email = CleanForDB($Email);
$sql = "INSERT INTO $Database[TablePrefix]ChatUsers SET Name='$Name',Password='$Password',Email='$Email',LastAccess='$now',RegDate='$now',Ip='$REMOTE_ADDR'";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

// Update Stats, with mysql ver 4 we can upgrade to  INSERT ... ON DUPLICATE KEY UPDATE
$Year = date('Y');
$Month = date('m');
$Day = date('d');
$sql = "SELECT * FROM $Database[TablePrefix]ChatDailyStats WHERE Year='$Year' AND Month='$Month' AND Day='$Day' LIMIT 1";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
if (mysql_num_rows($result) == 0) 	{$sql = "INSERT INTO $Database[TablePrefix]ChatDailyStats SET Year='$Year',Month='$Month',Day='$Day',Registrations='1'";}
else 					{$sql = "UPDATE $Database[TablePrefix]ChatDailyStats SET Registrations=Registrations+1 WHERE Year='$Year' AND Month='$Month' AND Day='$Day'";}
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

// Send Back Success
printf("&e=0");
mysql_close();
?>