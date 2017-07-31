<?php

// Chapter 2 Choice 1

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
				<title>approaching the man in the red cap...</title>
				<br>
				slowly but surely, you make your way up to the man in the red cap...
				<br>
				you twitch and shake.
				<br>
				then, you remember the sign:
				<br>
				<IMG SRC = red.png >
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