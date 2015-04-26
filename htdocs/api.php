<?php
	require_once('getid3/getid3.php');
	function upload() {
		$files = $_FILES["upload"];
		$array = Array();
		if(isset($files)) {
			$amount = count($files["name"]);
			$okay = true;
			for($i = 0; $i < $amount; $i++) {
				if(substr($files["type"][$i], 0, 5) !== "audio") {
					$okay = false;
					continue;
				}
				else {
					$tmp_name = $files["tmp_name"][$i];
					$name = $files["name"][$i];
					$getID3 = new getID3();
					$id3 = $getID3->analyze($tmp_name);
					getid3_lib::CopyTagsToComments($id3);
					$tag = $id3["comments"];
					if(isset($tag) && isset($tag["artist"][0]) && isset($tag["title"][0])) {
						$name = $tag["artist"][0]." - ".$tag["title"][0].substr($name, -4);
						move_uploaded_file($tmp_name, $GLOBALS["config"]["music"]."/".$name);
						echo("{okay:true}");
					}
					else {
						$okay = false;
					}
				}
			}
			if(!$okay) {
				echo('{okay:false,reason:"id3"}');
			}
		}
		else {
			echo('{okay:false,reason:"no_files"}');
		}
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
