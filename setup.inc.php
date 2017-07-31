<?
//if (!defined('PROGRAM_OPEN') ) {die("This Page can't be loaded this way.");}

// Setup Key Variables
$r = $_POST['r'];
$id = $_POST['id'];
$l = $_POST['l'];
$s = $_POST['s'];
$k = $_POST['k'];
$n = $_POST['n'];
$p = $_POST['p'];
$email = $_POST['email'];
$d = $_POST['d'];

$DataDirectory = 'data';	// Set this to the directory where you will store the text database files, for security this should be below html access, don't put a / on the end of it

$MaxUsers = '100';						// Maximum number of people allowed to chat at one time
$MaxGuests = '20';						// Maximum number of people allowed to log in as guests
$TimeOut = '60';	
					// How many seconds before they time out
$Database[User] = 'penguinc_urmom';					// Change this to the name of the database user who has permission to connect to this database
$Database[Password] = 'loldongs123';				// Change this to the database users password
$Database[DatabaseName] = 'penguinc_players';			// Change this to the name of the database you want to connect to
$Database[Host] = 'localhost';					// Change this the host name or ip of the database to connect to, almost always its localhost
$Database[TablePrefix] = 'chat_';				// If you want to run more than one chat, you can rename all the table with this prefix and it will use those ones, however you will need a unique setup_inc and text database directory for each installation
$EmailAddress = 'goproshedden@gmail.com';		// Set this to the email address you will send from for lost passords auto-send new one
$UniqueKey = 'aSTrdsfP';					// Write some random letters and numbers here, this will be used to create player keys so others can't POST to the php files pretending to be them

// DO NOT CHANGE the following
// These are commonly used routines
unset($Safe);						// A safe and clean place to store information
set_magic_quotes_runtime(0);				// So null does not become /0
$now = time();

function Dienice($msg,$details="")
	{// To speed things up I'm just going to include a file so it only loads if needed, rare call
	printf("$msg&em=$details");exit;
	}

function ConnectDB()
	{global $Database;
	$tmp = mysql_connect ($Database[Host], $Database[User], $Database[Password]) or Dienice('&e=10','Unable to Connect at this time, please try again later');
	mysql_select_db ($Database[DatabaseName]) or Dienice('&e=11','Unable to Connect at this time, please try again later');
	}

function IsANumber($value)
	{if (preg_match("/^[0-9]+$/",$value)) {return true;}
	else {return false;}
	}
function CleanInput($value)
	{$value = str_replace('&#39;',"'",$value);
	if (get_magic_quotes_gpc ()) {$value = stripslashes($value);}		// Only Strip if added, we'll make up for it with the function below
//	$value = trim(ereg_replace("[\n\r&|]+",'',$value));
	$value = trim(ereg_replace("[\n\r&]+",'',$value));
	return $value;
	}
function CleanForDB($value)
	{
	$value = addslashes($value);
	return $value;
	}
?>