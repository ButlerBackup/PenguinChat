<?
// This refreshes their time stamp while they are waiting around
// Usually while flash is loading
// Flash sends id=TmpId

define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
if ($REQUEST_METHOD != "POST") {printf('&e=4','Invalid Input');exit;}	// Only accept it via post
include('setup.inc.php');				// Load the Variables and Code Snippets

// Check data to make sure clean
if (!IsANumber($id)) {Dienice('&e=18','Player Number Must be a Number');}

ConnectDB();

// Update their information
$sql = "UPDATE $Database[TablePrefix]ChatLiveUsers SET LastCheckIn='$now' WHERE TmpId = '$id'";
$result = mysql_query ($sql) or Dienice('&e=19', $sql);

printf("&e=0");		// Return true, no error
mysql_close();
?>