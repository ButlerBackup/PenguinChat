<?
// Character Chat for Flash
// Drop Expired Players
// Call as include('drop.inc.php');				// Go through the database, drop expired players and look for empty spots

// Called in new.php, drop.php, join.php
// Dec 25, 2002 - Ver 1.0
// Sept 20, 2003 - Ver 1.1

// Timeout Variable is set in setup.inc.php
if (!defined('PROGRAM_OPEN') ) {die("This Page can't be loaded this way.");}


function AnnounceDrop($RoomNumber,$TmpId,$DontDelete='0')
	{global $DataDirectory,$Database,$now;
	
	// Drop them first so if new people log in they don't see them appear
	// Also they can still be dropped if they are not in a room just don't need to announce it, ie, logged in but lost connection before joined room
	if ($DontDelete == '0')		// By doing this I can drop them from one move and move them to another without actually dropping them
		{$sql = "DELETE FROM $Database[TablePrefix]ChatLiveUsers WHERE TmpId = '$TmpId'";
	   	$result = mysql_query ($sql) or Dienice('&e=19', $sql);
   		$sql = "UPDATE $Database[TablePrefix]ChatUsers SET TmpId = '',TotalTime=TotalTime + ($now - LastAccess) WHERE TmpId = '$TmpId'";
   		$result = mysql_query ($sql) or Dienice('&e=19', $sql);
   		}
   			
	if ($RoomNumber != "0")			// That is only if they are logged into a room
		{if (!IsANumber($RoomNumber))	{return false;}	// For security reasons (since we are loading a file) don't allow them to use anything but numbers so know clean data
		
		$filename3 = "$DataDirectory/Room$RoomNumber." . date("Ymd") . ".txt";
 		$fp2 = @fopen ($filename3, "a");			// Open the file for writting,
 		if (!$fp2) {$fp2 = @fopen ($filename3, "a");}	// Try again
		if (!flock($fp2, 2)) {Dienice("&e=13","Text File could not be locked check permissions");}
		fseek($fp2,0,SEEK_END);				// Goto the end of the file
		$ChatLine = "$TmpId\n";			// It used to be 60 chars long with null but that was unneccassary since going straight to a character (now just saving the character instead of 60 * Line)
		
		# Needs update
		fwrite($fp2,$ChatLine);
		fclose($fp2);
		}

	}
	
// Go through all the TmpIds and figure out who needs to be dropped (Can't just drop them because have to announce it)
$sql = 'SELECT TmpId,RoomId FROM ' . $Database[TablePrefix] . 'ChatLiveUsers WHERE LastCheckIn < "' . ($now - $TimeOut) . '"';
$result = mysql_query ($sql) or Dienice('&e=19', $sql);
if (mysql_numrows($result) > 0) 
   {while ($TmpIdDrop = mysql_fetch_array($result))
	{
	AnnounceDrop($TmpIdDrop[RoomId],$TmpIdDrop[TmpId]);
	}

   mysql_free_result($result);
   

   }

?>