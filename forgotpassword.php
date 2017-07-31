<?
// LOGIN a user
// Flash sends sendpassword.php?email=Email Address
// PHP returns

// Get all the variables and common functions
define('PROGRAM_OPEN', true);				// This is to protect Included files, if they try to load it directly they may be able to by-pass some security checks, ensure they are going through the right channels
if ($REQUEST_METHOD != "POST") {printf('&e=4','Invalid Input');exit;}	// Only accept it via post
include('setup.inc.php');				// Load the Variables and Code Snippets
ConnectDB();

// Perform all the basic non-database error checking here
if ($email == '') {Dienice('&e=27','Email is Required');}

$Email = CleanInput($email);

// Generate a Random Password
// I put it seperately since it is only sometimes used so no point wasting all those process time and it allows me to load it in other instances
# Disabled Random word generator due to multi-national support who don't understand english or have english keys enabled
#$words = array ('cat', 'dog', 'hat', 'happy', 'smile', 'fun', 'mouse', 'puppy', 'joy', 'grace', 'peace', 'faith', 'hope',  'kind', 'good', 'gentle', 'ant', 'bird', 'fish', 'golf', 'soccer', 'jump', 'book', 'disk', 'north', 'south', 'east', 'west', 'up', 'down', 'right', 'climb', 'sing', 'jump', 'meow', 'bark',  'daisy', 'safe','run','boot','mouse','show','shoe','wave','snoopy','peanut','butter','jelly','balloon','clock','watch','room','flower','daisy','rose','goose','tent','yellow','blue','red','purple','green','wash','yo','gum');
#$maxrnd = count($words) - 1;	// Count how many there are in case add or take some out
srand ( (double) microtime()*10000000); //set rand()
#$rand_num = rand(0,$maxrnd); //random number
#$Password = $words[$rand_num];
$rand_num = rand(100000,999999); //random number
$Password = $rand_num;
#$rand_num = str_replace('1','',$rand_num);	// Get rid of 1's because they look like L's
#$rand_num = str_replace('666','66',$rand_num);	// Get rid of 666 since some may be offended
#$Password .= $rand_num;
#$rand_num = rand(0,$maxrnd); //random number
#$Password .= $words[$rand_num];


$PasswordUnEncrypted = $Password;
$Password = md5($Password);					// Use md5 to give a 32character representation of the password, this way if someone sees the database they can't see the passwords, they are unknown and lost forever
$Password = substr($Password,16,16) . substr($Password,0,16);	// In case someone is really crafty reorganize the md5 so if they assume it is normal md5 and reverse it then it is still wrong

// Make sure they are actually in the database
$Email = CleanForDB($Email);
$sql = "SELECT * FROM $Database[TablePrefix]ChatUsers WHERE Email='$Email'";
$result = mysql_query ($sql) or Dienice("Error in SQL statement", $sql);
if (mysql_num_rows($result) == 0) {Dienice("&e=30","Email Address not Found");}
$User = mysql_fetch_array($result);

$sql = "UPDATE $Database[TablePrefix]ChatUsers SET Password='$Password' WHERE UserId='$User[UserId]'";
$result = mysql_query ($sql) or Dienice("Error in SQL statement", $sql);

// Send the Email
$extra = "From: $EmailAddress\r\nReply-To: $EmailAddress\r\n";
$ThisDirectory = str_replace('forgotpassword.php','',$_SERVER['SCRIPT_NAME']);
$Message = "Your password has been changed.  Your new information is as follows:\n\nName: $User[Name]\nPassword: $PasswordUnEncrypted";
$Message = str_replace("\r",'',$Message);	// This is to fix a bug with Outlook which turns \r\n into no spaces
mail ($User[Email], "Penguin Chat Password Changed", $Message, $extra);

printf("&e=0");
mysql_close();
?>