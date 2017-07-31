<?
$MaxUsers = '100';						// Maximum number of people allowed to chat at one time
$MaxGuests = '20';						// Maximum number of people allowed to log in as guests
$TimeOut = '60';						// How many seconds before they time out
$Database[User] = 'penguinc_urmom';					// Change this to the name of the database user who has permission to connect to this database
$Database[Password] = 'loldongs123';				// Change this to the database users password
$Database[DatabaseName] = 'penguinc_chats';			// Change this to the name of the database you want to connect to
$Database[Host] = 'localhost';					// Change this the host name or ip of the database to connect to, almost always its localhost
//chat_ = 'chat_';				// If you want to run more than one chat, you can rename all the table with this prefix and it will use those ones, however you will need a unique setup_inc and text database directory for each installation
$EmailAddress = 'ch.gull@bluewin.ch';			// Set this to the email address you will send from for lost passords auto-send new one
$UniqueKey = 'aSTrdsfP';					// Write some random letters and numbers here, this will be used to create player keys so others can't POST to the php files pretending to be them

function ConnectDB()
	{global $Database;
	$tmp = mysql_connect ($Database[Host], $Database[User], $Database[Password]) or Dienice('&e=10','Unable to Connect at this time, please try again later');
	mysql_select_db ($Database[DatabaseName]) or Dienice('&e=11','Unable to Connect at this time, please try again later');
	}
?>