<?php
	ini_set("display_errors", 1);
	ini_set("track_errors", 1);
	ini_set("html_errors", 1);
	error_reporting(E_ALL);
	require_once("./mpd.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap-theme.min.css" />
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<style>
			body {
				padding-top: 70px;
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Mumble Music Bot</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li><a href="?action=home">Home</a></li>
						<li><a href="?action=songs">Songs</a></li>
						<li><a href="?action=playlist">Playlist</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container">
			<div class="starter-template">
				<?php
					switch($_GET["action"]) {
						case "songs":
							require_once("./songs.php");
							break;
						case "playlist":
							require_once("./playlist.php");
							break;
						case "home":
						default:
							require_once("./home.php");
							break;
					}
				?>
			</div>
		</div>
	</body>
</html>
