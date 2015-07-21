<?php
	/*
	 * This file is part of mumble-music-bot.
	 *
	 * mumble-music-bot is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * mumble-music-bot is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */
	if(empty($_GET["action"])) {
		header("Location: ?action=home");
		die();
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap-theme.min.css" />
		<link rel="icon" type="image/x-icon" href="favicon.ico" />
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<style>
			html {
				position: relative;
				min-height: 100%;
			}
			body {
				padding-top: 70px;
				margin-bottom: 60px;
			}
			.footer {
				position: absolute;
				bottom: 0;
				width: 100%;
				height: 60px;
				background-color: #f5f5f5;
			}
			.footer .container {
				width: auto;
				max-width: 680px;
				padding: 0 15px;
			}
			.footer .container .text-muted {
				margin: 20px 0;
				text-align: center;
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
						<li><a href="?action=home">Status</a></li>
						<li><a href="?action=songs">Songs</a></li>
						<li><a href="?action=playlist">Playlist</a></li>
						<li><a href="?action=upload">Upload</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container">
			<div class="starter-template">
				<?php
					switch($_GET["action"]) {
						case "songs":
							require_once("view/songs.php");
							break;
						case "playlist":
							require_once("view/playlist.php");
							break;
						case "upload":
							require_once("view/upload.php");
							break;
						case "home":
						default:
							require_once("view/home.php");
							break;
					}
				?>
			</div>
		</div>
		<div class="footer">
			<div class="container">
				<p class="text-muted">2015 by Prior (Frederick Gnodtke). This software is open source and can be found <a href="https://git.cronosx.de/prior/mumble-music-bot/">here</a>.</p>
			</div>
		</div>
	</body>
</html>
