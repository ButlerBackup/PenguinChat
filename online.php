<?php

// Simple "who's online" script written by Anderson

require "setup2.inc.php";

ConnectDB();

$name = addslashes($_POST['n']);

$getUsers = mysql_query("SELECT * FROM `chat_ChatLiveUsers`") or die(mysql_error()); // gets all the users from the table

echo('<br><font face="Arial, Helvetica, sans-serif" size="2"><b><center><u>Current online users</u><br></center></b>');

while($allUsers = mysql_fetch_array($getUsers)) {
	if(in_array("Anderson", $allUsers) or in_array("Cam", $allUsers) or in_array("Vortex", $allUsers) ) { // now working
		echo("<center><font color=red>" . $allUsers['Name'] . "</font></center>");
	} else {
		echo("<b><center>" . $allUsers['Name'] . "</center></b>");
	}
}


?>