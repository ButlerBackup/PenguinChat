<?
// Ban person when moderator presses ban
// Flash sends id=TmpId of person dropping other (which may be themself)&r=RoomId of person being dropped&p=Password of person dropping other&banid=TmpId To Drop
// The id must be a moderator

// Get all the variables and common functions
define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
// if ($REQUEST_METHOD != "POST") {printf('&e=4','Invalid Input');exit;}	// Only accept it via post
include('setup.inc.php');				// Load the Variables and Code Snippets

// Check data to make sure clean
if (!IsANumber($r)) {Dienice('&e=17','Room Number Must be a Number');}
if (!IsANumber($id)) {Dienice('&e=18','Player Number Must be a Number');}
if (!IsANumber($banid)) {Dienice('&e=23','Ban Number Must be a Number');}
$Password = CleanInput($p);
$Password = md5($Password);					// Use md5 to give a 32character representation of the password, this way if someone sees the database they can't see the passwords, they are unknown and lost forever
$Password = substr($Password,16,16) . substr($Password,0,16);	// In case someone is really crafty reorganize the md5 so if they assume it is normal md5 and reverse it then it is still wrong
$Password = CleanForDB($Password);

ConnectDB();

// Make sure they are this person and not someone trying to drop another
if ($banid != $id) 	{$sql = "SELECT UserId,TmpId FROM $Database[TablePrefix]ChatUsers WHERE TmpId='$id' AND IsModerator = '1' AND Password = '$Password'";}
else			{Dienice('&e=25','Moderators Should not ban themselves');}
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
if (mysql_num_rows($result) == 0)
	{Dienice('&e=24','You do not have permission to ban this person');}
mysql_free_result($result);

// Mark them as banned, first of all, see if they are in the table (or are just a guest)
$sql = "SELECT * FROM $Database[TablePrefix]ChatUsers WHERE TmpId = '$banid' LIMIT 1";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
if (mysql_num_rows($result) == 0)	// They are a guest
	{// Add them to the list of Users and Mark them as banned so that Username can't come back
	$sql = "SELECT * FROM $Database[TablePrefix]ChatLiveUsers WHERE TmpId = '$banid' LIMIT 1";
	$result = mysql_query ($sql) or Dienice('&e=19', $sql);
	$BannedUser = mysql_fetch_array($result);
	mysql_free_result($result);

	$sql = "INSERT INTO $Database[TablePrefix]ChatUsers SET Name='$BannedUser[Name]',TmpId = '$banid',LastAccess='$now',RegDate='$now',Ip='$REMOTE_ADDR',IsBanned = '1'";
	}

else 	{$sql = "UPDATE $Database[TablePrefix]ChatUsers SET IsBanned = '1' WHERE TmpId = '$banid' LIMIT 1";}
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

// Drop them from the chat as well
include('drop.inc.php');				// Go through the database, drop expired players and look for empty spots

AnnounceDrop($r,$banid);

printf("&e=0");		// Return true, no error
mysql_close();
?>