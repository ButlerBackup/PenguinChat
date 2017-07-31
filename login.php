<?
// LOGIN a user
// Flash sends login.php?n=GiraffeMan&p=Password
// PHP returns
// id=Users Id

// Get all the variables and common functions
define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
// if ($REQUEST_METHOD != "POST") {printf('&e=4','Invalid Input');exit;}	// Only accept it via post
include('setup.inc.php');				// Load the Variables and Code Snippets
ConnectDB();

// Perform all the basic non-database error checking here
if ($n == '') {Dienice('&e=2','Name is Required');}
if ($p == '') {Dienice('&e=26','Password is Required');}
$Name = CleanInput($n);			// Make sure no slashes, but some configuration would already have them added
$Password = CleanInput($p);

// Delete all expired accounts
include('drop.inc.php');				// Go through the database, drop expired players and look for empty spots

// Check to see how many people are logged in
$sql = "SELECT COUNT(TmpId) FROM $Database[TablePrefix]ChatLiveUsers";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
$NumberLoggedIn = mysql_fetch_array($result);
mysql_free_result($result);
if ($NumberLoggedIn[0] >= $MaxUsers) {Dienice('&e=12','Too many connections, please try again later');}		// Send the errorcode for full server

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


// Make sure they are not already in a room or else they will be duplicated
$sql = "SELECT * FROM $Database[TablePrefix]ChatLiveUsers WHERE  Name=\"$Name\" LIMIT 1";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
if (mysql_num_rows($result) > 0)
	{$User2 = mysql_fetch_array($result);
	AnnounceDrop($User2[RoomId],$User2[TmpId]);
	}
mysql_free_result($result);

// Generate a Key
$User[Pass] = substr(md5($UniqueKey + microtime()),0,4);
$User[Pass] = CleanForDB(CleanInput($User[Pass]));	// Format it the same as we will read it later

// Recycle Id's.
// The logic is that if the lowest id is greater than 0 use that one, if not use 1 greater than the highest
$sql = "LOCK TABLES $Database[TablePrefix]ChatLiveUsers WRITE";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

$sql = "SELECT MIN(TmpId) AS Low,MAX(TmpId) AS High FROM $Database[TablePrefix]ChatLiveUsers";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
$Item = mysql_fetch_array($result);
mysql_free_result($result);

$Name = CleanForDB($Name);
if ($Item[Low] > 1) {$Tmp[0] = $Item[Low] - 1;$sql = "INSERT INTO $Database[TablePrefix]ChatLiveUsers SET TmpId = '$Tmp[0]',Pass='$User[Pass]',RoomId='0',LastCheckIn='$now',Name='$Name'";}
else {$Tmp[0] = $Item[High] + 1;$sql = "INSERT INTO $Database[TablePrefix]ChatLiveUsers SET TmpId = '$Tmp[0]',Pass='$User[Pass]',RoomId='0',LastCheckIn='$now',Name='$Name'";}
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

$sql = "UNLOCK TABLES";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

#$sql = "SELECT LAST_INSERT_ID()";
#$result = mysql_query ($sql) or Dienice('&e=19', $sql);
#$Tmp = mysql_fetch_array($result);

// Update their data in the database
$sql = "UPDATE $Database[TablePrefix]ChatUsers SET TmpId = '$Tmp[0]', LastAccess='$now',Ip='$REMOTE_ADDR',TimesLoggedIn=TimesLoggedIn+1 WHERE UserId = '$User[UserId]'";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

// Update Stats, with mysql ver 4 we can upgrade to  INSERT ... ON DUPLICATE KEY UPDATE
$Year = date('Y');
$Month = date('m');
$Day = date('d');
$sql = "SELECT * FROM $Database[TablePrefix]ChatDailyStats WHERE Year='$Year' AND Month='$Month' AND Day='$Day' LIMIT 1";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
$Item = mysql_fetch_array($result);
if ($Item[MaxUsers] < ($NumberLoggedIn[0]+1))	{$Item[MaxUsers] = $NumberLoggedIn[0]+1;}
if (mysql_num_rows($result) == 0) 	{$sql = "INSERT INTO $Database[TablePrefix]ChatDailyStats SET Year='$Year',Month='$Month',Day='$Day',Guests='1',MaxUsers='$Item[MaxUsers]'";}
else 					{$sql = "UPDATE $Database[TablePrefix]ChatDailyStats SET Logins=Logins+1,MaxUsers='$Item[MaxUsers]' WHERE Year='$Year' AND Month='$Month' AND Day='$Day'";}
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

// Send Back the Player ID
printf("&id=$Tmp[0]&m=$User[IsModerator]&e=0&k=$User[Pass]");
mysql_close();
?>