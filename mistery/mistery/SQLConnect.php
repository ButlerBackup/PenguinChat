<?php

	function SQLConnect($host, $user, $pass)
	{
	
		mysql_connect($host, $user, $pass) or die(mysql_error());
		
	}
	
	function DBConnect($dbase)
	{
	
		mysql_select_db($dbase) or die(mysql_error());

	}

?>