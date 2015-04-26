<?php
	require_once('getid3/getid3.php');
	require_once("src/mpd.php");
	
	function upload() {
		$files = $_FILES["upload"];
		$array = Array();
		$result = Array();
		if(isset($files)) {
			$amount = count($files["name"]);
			for($i = 0; $i < $amount; $i++) {
				$tmp_name = $files["tmp_name"][$i];
				$name = $files["name"][$i];
				if(substr($files["type"][$i], 0, 5) !== "audio") {
					$result[$name] = array("okay" => false, "reason" => "not_an_audio_file");
					continue;
				}
				else {
					$getID3 = new getID3();
					$id3 = $getID3->analyze($tmp_name);
					getid3_lib::CopyTagsToComments($id3);
					$tag = $id3["comments"];
					if(isset($tag) && isset($tag["artist"][0]) && isset($tag["title"][0])) {
						$filename = $tag["artist"][0]." - ".$tag["title"][0].substr($name, -4);
						move_uploaded_file($tmp_name, $GLOBALS["config"]["music"]."/".$filename);
						$result[$name] = array("okay" => true);
					}
					else {
						$result[$name] = array("okay" => false, "reason" => "no_id3_tag");
					}
				}
			}
			echo(json_encode($result));
		}
	}

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
