<?php
/*

KEEP THIS!

cavedweller and Jasperi have created these files. No one else has permission to claim these files as their own.
Simply put this file along with the other PHP & TXT with eachother. Then, make a folder called anything you want
INSIDE THE FOLDER WHERE YOUR PHP & TXTs ARE. Do not change the names of the PHP / TXT. You may distribute if you wish.

*/
	$playerRoom =  addslashes($_POST['room']);
	$room = $playerRoom;
	$playerAction =  addslashes($_POST['action']);
	$playerName =  addslashes($_POST['name']);
	$retrieveInfo = $_POST[$playerName];
	$theInfo = "info" . $room . ".txt";
	$info = file_get_contents('info' . $room . '.txt');
	$theUserInfo = $info;
	$openInfo = fopen($theInfo, 'a');
	$information =  "" . $playerName . "=" . $retrieveInfo .  "&";
	$online = "online" . $room . ".txt";
	$roomOpen = fopen($online, 'r');
	$fopen = fopen($online, 'a') or die("Oops, we can't open one of the .txt files!");
	$playerData = $playerName . "%7E";
	$getContents = file_get_contents('online' . $room . '.txt');
	$playerKey = addslashes($_POST['key']);

	if ($playerAction = "drop") {  //This must delete the player from the txt file... write later!
	}

	if ($playerAction = "update") {
		fwrite($openInfo, $information);
		fwrite($fopen, $playerData);
		echo "&players=" . $getContents . $theUserInfo . "&key=" . $playerKey . "&Room=" . $playerRoom;
	};



	if($playerAction = "newplayer"){	
		$possition = strrpos($getContents, $playerData);
	if ($possition === false) {
		fwrite($openInfo, $information);
		}
		else
		{
		die("&response=denied");
		};

	$possitions = strrpos($theUserInfo, $information);
		if ($possitions === false) {
		fwrite($fopen, $playerData);
		}
		else
		{
		die("&response=denied");
		};
	echo "&players=" . $getContents . "&" . $theUserInfo . "" . $information . "&key=" . $playerKey . "&Room=" . $playerRoom;
}
?>