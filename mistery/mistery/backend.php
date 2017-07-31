<?php

require "SQLConnect.php";

	SQLConnect('localhost', 'penguinc_urmom', 'loldongs123');
	
	DBConnect('penguinc_posse');

	// and the rest does the magic...

	$ip = $_SERVER['REMOTE_ADDR'];

	$query = mysql_query("SELECT * FROM `users` WHERE `IP` = '$ip'");
	while($Fetch = mysql_fetch_assoc($query) or die(mysql_error())) {
	$CH = $Fetch['CH'];
	
	switch($CH)
	{
		case '0': 
		case '1':
			Echo("
				<br>
				<br>
				<br>
				<br>
				<center>
				<small>
				welcome to Mistery! you am  your host, wyatt. for the sake of me and you, you will just call you '$ip', please pay close attention to these details as you will <b><you>not</you></b> be given them again!
				<br>
				<li>do NOT talk to the man in the red cap.</li>
				<br>
				<li>never enter the house 3 doors down.</li>
				<br>
				<li>always walk <you>down</you> the street with a friend.</li>
				<br>
				never forget these because if you do, you will find yourself a victim of death.
				<br>
				ready to move on?
				<br>
				<form name = myWebForm action = backend.php method = post>
				<input type = submit value=yes />
				</form>
				</small>
				</center>
			");
			
			mysql_query("UPDATE users SET `CH` = `CH` + 1") or die(mysql_error());
			break;
			
		case '2':
			Echo("
			<br>
			<br>
			<br>
			<br>
			<center>
			<small>
			alright $ip, you have successfully made it through 1 chapter! woo! too hard, right?
			<br>
			here's Chapter 2:
			<br>
			you were awakened by something soft and tingly in your left thigh. you tried to sit up, but you failed. you looked around, but saw nothing but black. you sniffed and smelled something.
			you couldn't put your finger on what it were, however. looking to your left, you noticed that there were a window with a blowing breeze coming through it. then, it happened. you felt the
			floor collapsing, then the ceiling. jumping up from the bed in which you were lying in, you bolted from the place in which you rested, to the stairs in which you had just come upon.
			suddenly, you received a sharp pain run up your spine and you fell to the floor.
			<br>
			you woke up... but now you were in a completely different room. was that all a dream...
			<br>
			<br>
			you were dead. you had to be.
			<br>
			<br>
			suddenly... light... too much of it. your eyes quickly adjusted and you were outside. how?
			<br>
			you approached a man. he appeared to be wearing slacks and a red cap.
			<br>
			then... you remembered.
			<br>
			<br>
			<br>
			ready to move on? choose what happens next...
			<br>
			approach the man? or keeping walking?
			<br>
			<br>
			<form name = 1 action = backendCH2_1.php method = post>
			<input type = submit value=approach />
			</form>
			<br>
			<form name = 2 action = backendCH2_2.php method = post>
			<input type = submit value=walk />
			</form>
			</small>
			</center>
			");
	}
}
	
?>