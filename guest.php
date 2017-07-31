<?
// LOGIN a user
// Flash sends guest.php
// PHP returns
// id=Users Id

// Get all the variables and common functions
define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
include('setup.inc.php');				// Load the Variables and Code Snippets
ConnectDB();

// Perform all the basic non-database error checking here

// Delete all expired accounts
include('drop.inc.php');				// Go through the database, drop expired players and look for empty spots

// Check to see how many people are logged in
$sql = "SELECT COUNT(TmpId) FROM $Database[TablePrefix]ChatLiveUsers";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
$NumberLoggedIn = mysql_fetch_array($result);
mysql_free_result($result);
if ($NumberLoggedIn[0] >= $MaxUsers) {Dienice('&e=12','Too many connections, please try again later');}		// Send the errorcode for full server

#// Check to see how many guests are logged in
#$sql = "SELECT COUNT(UserId) FROM $Database[TablePrefix]ChatLiveUsers WHERE IsGuest = '1'";
#$result = mysql_query ($sql) or Dienice('&e=19', $sql);
#$NumberLoggedIn = mysql_fetch_array($result);
#mysql_free_result($result);
#if ($NumberLoggedIn[0] >= $MaxGuests) {Dienice('&e=12','Too many Guests Accounts, please try again later or Register your account');}		// Send the errorcode for full server

#// Check for Username
#$sql = "SELECT * FROM $Database[TablePrefix]ChatUsers WHERE Name='$Name' LIMIT 1";
#$result = mysql_query ($sql) or Dienice('&e=19', $sql);
#$User = mysql_fetch_array($result);
#if (mysql_num_rows($result) > 0) {Dienice("&e=28","Username already Taken");}
#mysql_free_result($result);

#$sql = "INSERT INTO $Database[TablePrefix]ChatLiveUsers SET UserId = '$Item[UserId]',RoomId='0',LastCheckIn='$now',Name='$Item[Name]'";	// Attributes will be set when they join a room
#$result2 = mysql_query ($sql) or Dienice('&e=19', $sql);
#printf("&id=$User[UserId]&m=$User[IsModerator]&e=0");

#// Lock Tables so others can't claim same id
#$sql = "LOCK TABLES $Database[TablePrefix]ChatUsers AS U WRITE,$Database[TablePrefix]ChatLiveUsers AS L WRITE";
#$result = mysql_query ($sql) or Dienice('&e=19', $sql);

// Get a Guest Account
$sql = "SELECT U.Name,U.UserId,L.UserId AS Id2 FROM $Database[TablePrefix]ChatUsers AS U LEFT JOIN $Database[TablePrefix]ChatLiveUsers AS L ON (U.UserId = L.UserId) WHERE U.IsGuest='1'";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
if (mysql_num_rows($result) == 0) {Dienice("&e=31","No Guest Accounts Created");}
while ($Item = mysql_fetch_array($result))
	{// It will be null if available
	
	// Found one
	if (!IsANumber($Item[Id2]))	
		{
		$sql = "UPDATE $Database[TablePrefix]ChatUsers SET LastAccess='$now',Ip='$REMOTE_ADDR' WHERE UserId = '$Item[UserId]'";
		$result2 = mysql_query ($sql) or Dienice('&e=19', $sql);
		$Item[Name] = CleanForDB($Item[Name]);
		$sql = "INSERT INTO $Database[TablePrefix]ChatLiveUsers SET UserId = '$Item[UserId]',RoomId='0',LastCheckIn='$now',Name='$Item[Name]'";	// Attributes will be set when they join a room
		$result2 = mysql_query ($sql) or Dienice('&e=19', $sql);
		printf("&id=$Item[UserId]&n=$Item[Name]&e=0");
		
		#$sql = "UNLOCK TABLES";
		#$result2 = mysql_query ($sql) or Dienice('&e=19', $sql);
		mysql_close();
		exit;
		}
	}
Dienice('&e=32','No Guest Accounts Available');
?>