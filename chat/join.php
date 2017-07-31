<?
//die("&e=19");
// Flash sends r=RoomId&id=TmpId&s=Attributes of Player String&k=Users Key
// PHP returns
// &l=Character in file we are on&p=playersInfo in this room seperated by newline

// Get all the variables and common functions
define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
if ($REQUEST_METHOD != "POST") {printf('&e=4','Invalid Input');exit;}	// Only accept it via post
include('setup.inc.php');				// Load the Variables and Code Snippets

// Check data to make sure clean
if (!IsANumber($r)) {Dienice('&e=17','Room Number Must be a Number');}
if (!IsANumber($id)) {Dienice('&e=18','Player Number Must be a Number');}
$Attributes = CleanInput($s);			// Make sure no slashes, but some configuration would already have them added
$k = CleanForDB(CleanInput($k));

ConnectDB();

// Get this Users Information and save in $User
$sql = "SELECT * FROM chat_ChatLiveUsers WHERE TmpId = '$id' AND Pass='$k'";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
$User = mysql_fetch_array($result);
mysql_free_result($result);

// Announce their entrance to this room
$filename2 = "$DataDirectory/Room$r." . date("Ymd") . ".txt";
$fp2 = @fopen ($filename2, "a");	// Open the file for writting file pointer at the end, if it does not exist, create it
if (!$fp2) {$fp2 = @fopen ($filename2, "a");}	// Try again
if (!flock($fp2, 2)) {Dienice("&e=13","Text File could not be locked check permissions");}
fwrite($fp2, "$id|$Attributes|$User[Name]\n"); 	// Save this new command
fseek($fp2,0,SEEK_END);
$Line = ftell($fp2);		// Since we just added a line, figure out what line we are on, everything after that does not matter
fclose($fp2);

// Update their information
$Attributes = CleanForDB($Attributes);
$sql = "UPDATE chat_ChatLiveUsers SET RoomId='$r',LastCheckIn='$now',Attributes='$Attributes' WHERE TmpId = '$id' AND Pass='$k'";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

include('drop.inc.php');				// Go through the database

// Drop them out of the room they are in (if they haven't entered one then it skips over this)
if ($User[RoomId] != $r) {AnnounceDrop($User[RoomId],$id,'1');}


// Send them a list of all the players in this room
printf("&e=0&l=$Line&p=");
$sql = "SELECT * FROM chat_ChatLiveUsers WHERE RoomId = '$r'";
$result = mysql_query ($sql) or Dienice("Error in SQL statement", $sql);
if (mysql_numrows($result) > 0)
   {while ($Item = mysql_fetch_array($result))
	{printf("$Item[TmpId]|$Item[Attributes]|$Item[Name]\n");
	}
   }
mysql_close();
?>