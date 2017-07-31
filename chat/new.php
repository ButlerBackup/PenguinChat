<?
// LOGIN a user
// Flash sends guest.php?n=name&n_gen=(set to 1 to add a number to the name)
// PHP returns
// id=Users Id

// Get all the variables and common functions
define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
if ($_SERVER['REQUEST_METHOD'] != "POST") {die('&e=4');exit;}	// Only accept it via post
include('setup.inc.php');				// Load the Variables and Code Snippets
ConnectDB();

// Perform all the basic non-database error checking here
if ($n == '') {Dienice('&e=2','Name is Required');}
$Name = CleanInput($n);			// Make sure no slashes, but some configuration would already have them added

// Delete all expired accounts
include('drop.inc.php');				// Go through the database, drop expired players and look for empty spots

// Check to see how many people are logged in
$sql = "SELECT COUNT(TmpId) FROM chat_ChatLiveUsers";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
$NumberLoggedIn = mysql_fetch_array($result);
mysql_free_result($result);
if ($NumberLoggedIn[0] >= $MaxUsers) {Dienice('&e=12','Too many connections, please try again later');}		// Send the errorcode for full server

// Check to see how many guests are logged in
$sql = "SELECT COUNT(TmpId) FROM chat_ChatLiveUsers WHERE IsGuest = '1'";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
$NumberGuestsIn = mysql_fetch_array($result);
mysql_free_result($result);
if ($NumberGuestsIn[0] >= $MaxGuests) {Dienice('&e=12','Too many Guests Accounts, please try again later or Register your account');}		// Send the errorcode for full server

// Check for Username, if n_gen = 1 however then don't bother checking now since we are going to add to it later
if ($n_gen != '1')
	{$sql = "SELECT * FROM chat_ChatUsers WHERE Name=\"$Name\" LIMIT 1";
	$result = mysql_query ($sql) or Dienice('&e=19', $sql);
	if (mysql_num_rows($result) > 0) {Dienice("&e=28","Username already Taken");}
	mysql_free_result($result);

	// Check for Username in Live Table too
	$sql = "SELECT * FROM chat_ChatLiveUsers WHERE Name=\"$Name\" LIMIT 1";
	$result = mysql_query ($sql) or Dienice('&e=19', $sql);
	if (mysql_num_rows($result) > 0) {Dienice("&e=28","Username already Taken");}
	mysql_free_result($result);
	}


// Generate a Key
$User[Pass] = substr(md5($UniqueKey + microtime()),0,4);
$User[Pass] = CleanForDB(CleanInput($User[Pass]));	// Format it the same as we will read it later

// Recycle Id's.
// The logic is that if the lowest id is greater than 0 use that one, if not use 1 greater than the highest
$sql = "LOCK TABLES chat_ChatLiveUsers WRITE";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

$sql = "SELECT MIN(TmpId) AS Low,MAX(TmpId) AS High FROM chat_ChatLiveUsers";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
$Item = mysql_fetch_array($result);

$Name2 = $Name;			// In case it is changed below, preserve it.
$Name = CleanForDB($Name);

// Go through the database and find out what is the highest guest# for a name, add 1 to it
if ($n_gen == '1')
	{$OtherNamesExt = '0';
	$sql = "SELECT Name FROM chat_ChatLiveUsers WHERE Name LIKE \"$Name%\" ORDER BY Name DESC LIMIT 1 ";
	$result = mysql_query ($sql) or Dienice('&e=19', $sql);
	if (mysql_num_rows($result) > 0)
		{$OtherNames = mysql_fetch_array($result);
		$OtherNamesExt = ereg_replace($Name2,'',$OtherNames[Name]);	// Remove the name part
		$OtherNamesExt = ereg_replace("[^0-9]+",'',$OtherNamesExt);
		}
	$Name2 = $Name2 . ($OtherNamesExt + 1);
	$Name = CleanForDB($Name2);
	mysql_free_result($result);
	}


if ($Item[Low] > 1) {$Tmp[0] = $Item[Low] - 1;$sql = "INSERT INTO chat_ChatLiveUsers SET TmpId = '$Tmp[0]',Pass='$User[Pass]',RoomId='0',LastCheckIn='$now',Name='$Name',IsGuest='1'";}
else {$Tmp[0] = $Item[High] + 1;$sql = "INSERT INTO chat_ChatLiveUsers SET TmpId = '$Tmp[0]',Pass='$User[Pass]',RoomId='0',LastCheckIn='$now',Name='$Name',IsGuest='1'";}
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

$sql = "UNLOCK TABLES";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

// Update Stats, with mysql ver 4 we can upgrade to  INSERT ... ON DUPLICATE KEY UPDATE
$Year = date('Y');
$Month = date('m');
$Day = date('d');
$sql = "SELECT * FROM chat_ChatDailyStats WHERE Year='$Year' AND Month='$Month' AND Day='$Day' LIMIT 1";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
$Item = mysql_fetch_array($result);
if ($Item[MaxGuests] < ($NumberGuestsIn[0]+1))	{$Item[MaxGuests] = $NumberGuestsIn[0]+1;}
if ($Item[MaxUsers] < ($NumberLoggedIn[0]+1))	{$Item[MaxUsers] = $NumberLoggedIn[0]+1;}
if (mysql_num_rows($result) == 0) 	{$sql = "INSERT INTO chat_ChatDailyStats SET Year='$Year',Month='$Month',Day='$Day',Guests='1',MaxGuests='$Item[MaxGuests]',MaxUsers='$Item[MaxUsers]'";}
else 					{$sql = "UPDATE chat_ChatDailyStats SET Guests=Guests+1,MaxGuests='$Item[MaxGuests]',MaxUsers='$Item[MaxUsers]' WHERE Year='$Year' AND Month='$Month' AND Day='$Day'";}
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

// Send Back the Player ID
printf("&id=$Tmp[0]&e=0&k=$User[Pass]&n=$Name2");
mysql_close();
?>