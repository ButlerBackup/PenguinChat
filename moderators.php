<?php
// Snails/Moderators are named in this file
include('setup2.inc.php');
ConnectDB();
$n = $_POST['n'];
$Attributes_OLD = CleanForDB($_POST['s']);
$Attributes_NEW = substr($Attributes_OLD, 1);
$Attributes 	= "15" . $Attributes_NEW;
$snails = array("Anderson", "Vortex");
if(in_array($n, $snails)) {
	$filename2 = "$DataDirectory/Room$r." . date("Ymd") . ".txt";
	$fp2 = @fopen ($filename2, "a");	// Open the file for writting file pointer at the end, if it does not exist, create it
	if (!$fp2) {$fp2 = @fopen ($filename2, "a");}	// Try again
	if (!flock($fp2, 2)) {Dienice("&e=13","Text File could not be locked check permissions");}
	fwrite($fp2, "$id|$Attributes|$User[Name]\n"); 	// Save this new command
	fseek($fp2,0,SEEK_END);
	$Line = ftell($fp2);		// Since we just added a line, figure out what line we are on, everything after that does not matter
	fclose($fp2);

	// Update their information
	//$Attributes = CleanForDB($Attributes);
	$sql = "UPDATE $Database[TablePrefix]ChatLiveUsers SET RoomId='$r',LastCheckIn='$now',Attributes='$Attributes' WHERE TmpId = '$id' AND Pass='$k'";
	$result = mysql_query ($sql) or Dienice('&e=19', $sql);
} else {
	$filename2 = "$DataDirectory/Room$r." . date("Ymd") . ".txt";
	$fp2 = @fopen ($filename2, "a");	// Open the file for writting file pointer at the end, if it does not exist, create it
	if (!$fp2) {$fp2 = @fopen ($filename2, "a");}	// Try again
	if (!flock($fp2, 2)) {Dienice("&e=13","Text File could not be locked check permissions");}
	fwrite($fp2, "$id|$Attributes_OLD|$User[Name]\n"); 	// Save this new command
	fseek($fp2,0,SEEK_END);
	$Line = ftell($fp2);		// Since we just added a line, figure out what line we are on, everything after that does not matter
	fclose($fp2);

	// Update their information
	//$Attributes = CleanForDB($Attributes);
	$sql = "UPDATE $Database[TablePrefix]ChatLiveUsers SET RoomId='$r',LastCheckIn='$now',Attributes='$Attributes_OLD' WHERE TmpId = '$id' AND Pass='$k'";
	$result = mysql_query ($sql) or Dienice('&e=19', $sql);
}
?>