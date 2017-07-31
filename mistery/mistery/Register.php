<?php

	require "SQLConnect.php";

	SQLConnect('localhost', 'penguinc_urmom', 'loldongs123');
	
	DBConnect('penguinc_posse');
	
	$ip = $_SERVER['REMOTE_ADDR'];

	$query = mysql_query("SELECT * FROM `users` WHERE `IP` = '$ip'") or die(mysql_error());
	
	if(mysql_num_rows($query) == 0)
	{
		mysql_query("INSERT INTO users (`IP`) VALUES ('" . $ip . "')") or die(mysql_error());
		$query1 = mysql_query("SELECT * FROM `users` WHERE `IP` != '$ip'");
		while($Fetch = mysql_fetch_array($query1) or die(mysql_error())) {
		$id = $Fetch['ID'];
		Echo("
		<br>
		<br>
		<br>
		<br>
		<center>
		<small>
		since it looks like you're new around these parts, you'll need to know your way around... your IP is: <i>$ip</i>, and your ID is <i>$id</i>!
		<br>
		please refresh your page!
		<br>
		</small>
		</center>
		");
	
		}
	} else {

		if(mysql_num_rows($query) == 1)
		{
			$query2 = mysql_query("SELECT * FROM `users` WHERE `IP` = '$ip'");
			while($Fetch = mysql_fetch_assoc($query2)) {
			$id = $Fetch['ID'];
				Echo("
				<br>
				<br>
				<br>
				<br>
				<center>
				<small>
				since it looks like you've been here before, you know the drill... your IP is: <i>$ip</i>, and your ID is <i>$id</i>!
				<br>
				</small>
				<form name = myWebForm action = backend.php method = post>
				<input type = submit value=start />
				</form>
				</center>
				");
			}	
		}
	}

?>