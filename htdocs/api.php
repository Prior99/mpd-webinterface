<?php
	function upload() {
		$files = $_FILES["upload"];
		$array = Array();
		if(isset($files)) {
			var_dump($files);
			$amount = count($files["name"]);
			for($i = 0; $i < $amount; $i++) {
				$name = $files["name"][$i];
				$tmp_name = $files["tmp_name"][$i];
				move_uploaded_file($tmp_name, $GLOBALS["config"]["music"]."/".$name);
			}
		}
		echo("true");
	}

	require_once("src/mpd.php");
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
		case "upload":
			upload();
			$mpd->update();
			break;
	}
?>
