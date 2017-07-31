<?
// Drop a person when they press drop or when Moderator drops them
// Flash sends id=TmpId of person dropping other (which may be themself)&r=RoomId of person being dropped&p=Password of person dropping other&dropid=TmpId To Drop&k=Players Key

// Get all the variables and common functions
define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
// if ($REQUEST_METHOD != "POST") {printf('&e=4','Invalid Input');exit;}	// Only accept it via post
include('setup.inc.php');				// Load the Variables and Code Snippets

// Check data to make sure clean
if (!IsANumber($r)) {Dienice('&e=17','Room Number Must be a Number');}
if (!IsANumber($id)) {Dienice('&e=18','Player Number Must be a Number');}
if (!IsANumber($dropid)) {Dienice('&e=21','Player Number Must be a Number');}
$k = CleanForDB(CleanInput($k));
$Password = CleanInput($p);
$Password = md5($Password);					// Use md5 to give a 32character representation of the password, this way if someone sees the database they can't see the passwords, they are unknown and lost forever
$Password = substr($Password,16,16) . substr($Password,0,16);	// In case someone is really crafty reorganize the md5 so if they assume it is normal md5 and reverse it then it is still wrong
$Password = CleanForDB($Password);


ConnectDB();

// Make sure they are this person and not someone trying to drop another, if Moderator then Moderator Flag must be set, if not just the password must match
if ($dropid != $id)
	{$sql = "SELECT UserId FROM $Database[TablePrefix]ChatUsers WHERE TmpId='$id' AND IsModerator = '1' AND Password = \"$Password\"";
	$result = mysql_query ($sql) or Dienice('&e=19', $sql);
	if (mysql_num_rows($result) == 0)
		{Dienice('&e=22','You do not have permission to drop this person');}
	}
else	{$sql = "SELECT TmpId FROM $Database[TablePrefix]ChatLiveUsers WHERE TmpId='$id' AND Pass='$k'";
	$result = mysql_query ($sql) or Dienice('&e=19', $sql);
	if (mysql_num_rows($result) == 0)
		{Dienice('&e=22','You do not have permission to drop this person');}
	}

include('drop.inc.php');				// Go through the database, drop expired players and look for empty spots

AnnounceDrop($r,$dropid);

printf("&e=0");		// Return true, no error
mysql_close();
?>