<?

# AI file for ChatterBot
# Created by Bluetie
# Created for PC3

function RandomLetter()
{
    $Number = rand(0, 12);
    $AL = "ABCDEFGHIJKL";
    $RandomLetter = $AL[$Number];
    return $RandomLetter;
}
$id = $_POST['id'];
$r = $_POST['r'];
$ServerData = addslashes($_POST['d']);
$filename = "data/Room$r." . date("Ymd") . ".txt";
$fp2 = fopen ($filename, "a");
switch($ServerData) { # So we don't have to use an if() statement everytime
case "hi":
case "Hi":
case "hello":
case "Hello":
case "yo":
case "Yo":
case "YO":
case "yO":
case "ChatterBot":
case "chatterbot":
case "chatterBot":
case "CHATTERBOT":

$Choices = array("0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Hello" . "\r\n", "0|1|1|I|J|Hi" . "\r\n", "0|1|1|A|K|Hey!" . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Hi there!" . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Hello there" . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Heyy" . "\r\n", "0|1|1|L|K|Helloooo" . "\r\n", "0|1|1|L|K|Happy holidays!" . "\r\n");
$ChoiceArray  = $Choices[array_rand($Choices)];
fwrite($fp2, $ChoiceArray);
break;

case "/e1":
case "/e2":
case "/e3":
case "/e4":
case "/e5":
case "/e6":
case "/e7":
case "/e8":
case "/e9":
case "/e10":
case "/e11":
case "/e12":
$Choices2 = array("0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Cool emote you have there!" . "\r\n", "0|1|1|I|J|Smiley faces are always the place to be." . "\r\n", "0|1|1|A|K|You know, Penguin Chat's smiley faces are the best!" . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Thanks for that." . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|:)" . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|You're cool." . "\r\n", "0|1|1|L|K|Cooooooooool." . "\r\n", "0|1|1|L|K|Happy holidays!" . "\r\n");
$ChoiceArray2  = $Choices[array_rand($Choices2)];
fwrite($fp2, $ChoiceArray2);
break;

case "/j0":
case "/j1":
case "/j2":
case "/j3":
case "/j4":
case "/j5":
case "/j6":
case "/j7":
case "/j8":
case "/j9":
case "/j10":
$Choices3 = array("0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|FUNNY!" . "\r\n", "0|1|1|I|J|You're hilarious!" . "\r\n", "0|1|1|A|K|You know, Penguin Chat's jokes are the best!" . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Thanks for that." . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Too funny." . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|HILARIOUS!." . "\r\n", "0|1|1|L|K|Haha" . "\r\n", "0|1|1|L|K|I have a joke... oh wait, I forgot!" . "\r\n");
$ChoiceArray3 = $Choices[array_rand($Choices3)];
fwrite($fp2, $ChoiceArray3);
break;
}

if($ServerData)
{
	$filename2 = "data/quotes/quotes$r." . date("Ymd") . ".txt";
	$fp3 = @fopen($filename2, "a");
	#require("setup.inc.php");
	#ConnectDB();
	mysql_connect("localhost", "penguinc_urmom", "loldongs123");
	mysql_select_db("penguinc_players");
	$q = mysql_query("SELECT * FROM chat_ChatLiveUsers WHERE TmpId = $id") or die(mysql_error());
	while($query = mysql_fetch_array($q))
	{
		$realn = $query['Name'];	
		fwrite($fp3, $realn . " " . "said:" . " " . $ServerData . "\r\n");
	}
}
if(strpos($ServerData, "e"))
{
	$Choices4 = array(
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|What are you looking at?" . "\r\n", 
	"0|1|1|I|J|Hello there!" . "\r\n", "0|1|1|A|K|Why am I blue? I thought penguins were black!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Welcome to Penguin Chat 3!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Why'd the chicken cross the road?" . 
	"\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|I love YouTube videos about me!" . 
	"\r\n", "0|1|1|L|K|Haha" . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|I have a joke... oh wait, I forgot!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|I like to ask a question... oh wait, I forgot!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Cake > Pie!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Heyyyy!" . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Post this on YouTube!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Remember, ask Bluetie, Rock, or Debug questions!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|The user named Rock made me!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|I'm just THAT cool!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|This is a test of the emergency broadcast system!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|/e7" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|This is a moderated server!" . "\r\n"
	);
	
	
	$ChoiceArray4 = $Choices4[array_rand($Choices4)];
	fwrite($fp2, $ChoiceArray4);
} else {
	fwrite($fp2, "0|1|1|" . RandomLetter() .  "|" . RandomLetter() . "\r\n");
}

if(strpos($ServerData, "bot"))
{
	$Choices4 = array(
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Hm?" . "\r\n", 
	"0|1|1|I|J|Hello there!" . "\r\n", "0|1|1|A|K|What would you like?" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|That's my name." . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Hey there!" . 
	"\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Do you like cake or pie?" . 
	"\r\n", "0|1|1|L|K|Haha" . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|What would you like?" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Yes?" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Excuse my language but... LOL!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Hey!" . "\r\n", "0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|What's up?" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Remember, ask Bluetie, Rock, or Debug questions!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|The user named Rock made me!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|I'm just THAT cool!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|This is a test of the emergency broadcast system!" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|/e1" . "\r\n", 
	"0|1|1|" . RandomLetter() .  "|" . RandomLetter() .  "|Who am I? I am a roBOT, haha!" . "\r\n"
	);
	
	
	$ChoiceArray4 = $Choices4[array_rand($Choices4)];
	fwrite($fp2, $ChoiceArray4);
}

if(strpos($ServerData, "shh"))
{
	fwrite($fp2, "0|1|1|H|K|Alright, I'll calm down dude." . "\r\n");
}
/*
if(strpos($ServerData, "users"))
{
	
}
*/
?>