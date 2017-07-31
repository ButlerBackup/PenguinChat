<?php

// Chapter 2 Choice 2

require "SQLConnect.php";

	SQLConnect('localhost', 'penguinc_urmom', 'loldongs123');
	
	DBConnect('penguinc_posse');

	// and the rest does the magic...

	$ip = $_SERVER['REMOTE_ADDR'];

	$query = mysql_query("SELECT * FROM `users` WHERE `IP` = '$ip'");
	while($Fetch = mysql_fetch_assoc($query) or die(mysql_error())) {
	$CH = $Fetch['CH'];
				Echo("
				<br>
				<br>
				<br>
				<br>
				<center>
				<small>
				<title>walking briskly...</title>
				<br>
				slowly but surely, you walk briskly away from him...
				<br>
				you twitch and shake.
				<br>
				you remember the sign:
				<br>
				<IMG SRC = red.png >
				<br>
				you are overwhelmed with happyness.
				<br>
				ready to move on?
				<br>
				<form name = myWebForm action = backend.php method = post>
				<input type = submit value=yes />
				</form>
				</small>
				</center>
			");
	}

?>