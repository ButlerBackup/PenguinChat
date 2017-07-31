<?php

$host="localhost"; // Host name 
$username="penguinc_urmom"; // Mysql username 
$password="loldongs123"; // Mysql password 
$db_name="penguinc_players"; // Database name 
$tbl_name="chat_ChatUsers"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

	if(!isset($_POST['search']))
		die('Please fill out the search bar to search for a user.');
		if(strlen($_POST['search']) > 12 || strlen($_POST['search']) < 3)
			die('The search text must be between 3 and 12 characters long.');
				//include "authenticate.php";
				$search = $_POST['search'];
				$id = $_POST['id'];
				$q = mysql_query("SELECT * FROM chat_ChatUsers WHERE Name LIKE '$search'");
				if(!mysql_num_rows($q)) {
					mysql_close();
					die('Specified user not found.');
				} else {
					mysql_query("UPDATE `chat_ChatUsers` SET `IsBanned` = 1 WHERE `Name` = '$search'") or die(mysql_error());
					print "$search was banned successfully.";
				}
?>