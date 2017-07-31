<?php

$host="localhost"; // Host name 
$username="penguinc_urmom"; // Mysql username 
$password="loldongs123"; // Mysql password 
$db_name="penguinc_players"; // Database name 
$tbl_name="chat_ChatLiveUsers"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

	if(!isset($_POST['search']))
		die('Please fill out the search bar to search for a user.');
		if(strlen($_POST['search']) > 12 || strlen($_POST['search']) < 3)
			die('The username must be between 3 and 12 characters long.');
				$search = $_POST['search'];
				$id = $_POST['id'];
				$q = mysql_query("SELECT * FROM chat_ChatLiveUsers WHERE Name LIKE '$search'");
				if(!mysql_num_rows($q)) {
					mysql_close();
					die('Specified user does not exist or is not online.');
				} else {
					while($fetch = mysql_fetch_array($q)) {
						switch($fetch['RoomId']) {
							case '1':
							echo $search . " is chilling in the Town!";
							break;							
							case '2':
							echo $search . " is dancing in the Dance Club!";
							break;							
							case '3':
							echo $search . " is shoveling coal in the Boiler Room!";
							break;							
							case '4':
							echo $search . " is drinking coffee in the Coffee Shop!";
							break;							
							case '5':
							echo $search . " is working at the Construction Site!";
							break;							
							case '6':
							echo $search . " is working at the Construction Hill!";
							break;							
							case '7':
							echo $search . " is throwing snowballs in the Snow Room (hardest room to find)!";
							break;
						}
					}
				}
?>