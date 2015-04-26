<?php
	require_once("./mpd.php");
	$mpd = new MPD();
	switch($_GET["action"]) {
		case "playlist":
			echo(json_encode($mpd->playlist()));
			break;
		case "songs":
			echo(json_encode($mpd->listall()));
			break;
		case "add":
			echo(json_encode($mpd->add($_GET["song"])));
			break;
	}
?>
