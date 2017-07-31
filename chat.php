<?
// Main Chat Script
// Flash sends id=TmpId&r=RoomId&s=Attributes of Player String (if changed)&d=Chat String(Dump)&l=Character in file(line)&k=Players Key
// PHP returns
// c=(Everything that has been said since last polled the server)&l=NewLineNumber

// Get all the variables and common functions
define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
//if ($REQUEST_METHOD != "POST") {printf('&e=4','Invalid Input');exit;}	// Only accept it via post
include('setup.inc.php');				// Load the Variables and Code Snippets

// Check data to make sure clean
if (!IsANumber($r)) {Dienice('&e=17','Room Number Must be a Number');}
if (!IsANumber($id)) {Dienice('&e=18','Player Number Must be a Number');}
if (!IsANumber($l)) {Dienice('&e=20','Line Number Must be a Number');}
$Attributes = CleanInput($s);			// Make sure no slashes, but some configuration would already have them added
$ChatDialogue = CleanInput($d);			// Make sure no slashes, but some configuration would already have them added
$k = CleanForDB(CleanInput($k));
if ($Attributes != '' || $ChatDialogue != '') 	{$SaySomething = true;} else {$SaySomething = false;}
ConnectDB();

// Send back everything since then
$filename = "$DataDirectory/Room$r." . date("Ymd") . ".txt";
$fp2 = fopen ($filename, "r+");				// Open the file for reading and writting,
if ($SaySomething)
	{if (!flock($fp2, 2)) {Dienice("&e=13","Text File could not be locked check permissions");}	// Lock the file if I am going to write so someone else doesn't stick a comment into here
	}
fseek($fp2,$l); 				// Goto This their most recent place in the file
$content = fread($fp2,filesize($filename));
fseek($fp2,0,SEEK_END);		// Goto the end of the file, this position will be remembered if we don't write something, this is more of a bug fix since it wasn't displaying the write number without it.  It is also needed for saving to the end of the file

// Add their comments
if ($SaySomething)		// Skip saying anything if nothing is new
	{fwrite($fp2,"$id|$Attributes|$ChatDialogue\n");
	}

// Figure out what line we are on and close that file so others can play with it
$l = ftell($fp2);		// Since we just added a line, figure out what char we are on, everything after that does not matter, floor as safety incase db has error which it shouldn't
fclose($fp2);

// Save their timestamp and latest Line
if ($Attributes != '')		// Skip saying anything if nothing is new
	{// Update their information
	$Attributes = CleanForDB($Attributes);
	$sql = "UPDATE $Database[TablePrefix]ChatLiveUsers SET LastCheckIn='$now',Attributes='$Attributes' WHERE TmpId = '$id' AND Pass='$k'";
	$result = mysql_query ($sql) or Dienice('&e=19', $sql);

	}
else
	{// Update their information
	$sql = "UPDATE $Database[TablePrefix]ChatLiveUsers SET LastCheckIn='$now' WHERE TmpId = '$id' AND Pass='$k'";
	$result = mysql_query ($sql) or Dienice('&e=19', $sql);
	}

$content = str_replace("&",'',$content);
printf("&e=0&l=$l&c=$content"); 		// Send the rest of the file since they last got it to flash
include "wyatt.php";
mysql_close();
?>