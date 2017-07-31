<?
echo phpinfo();

include('setup2.inc.php');				// Load the Variables and Code Snippets


ConnectDB();

$sql = "SELECT * FROM chat_ChatUsers";
$result = mysql_query ($sql);
while ($zeile=mysql_fetch_row($result)) 
{ 
	  $id=$zeile[0];
	  echo ("$id <br>");
 }
 ?>