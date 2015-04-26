<h1>Mumble Music Bot</h1>

<table class="table table-striped">
	<tbody id="infotable">
	</tbody>
</table>

<div class="lead" id="title"></div>
<div class="progress">
	<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" id="progressbar"></div>
</div>
<div id="time_elapsed"></div>
<div id="time_total"></div>

<a class="btn btn-ld btn-default" id="play"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> Play</a>
<a class="btn btn-ld btn-default" id="pause"><span class="glyphicon glyphicon-pause" aria-hidden="true"></span> Pause</a>
<a class="btn btn-ld btn-default" id="next"><span class="glyphicon glyphicon-fast-forward" aria-hidden="true"></span> Next</a>


<script>
	function formatTime(seconds) {
		var sec = Math.floor(seconds % 60);
		if(sec < 10) {
			sec = "0" + sec;
		}
		var min = Math.floor(seconds / 60);
		if(min < 10) {
			min = "0" + min;
		}
		return min+":"+sec
	}
	
	function displayStatus(playlist, status) {
		var infotable = $("#infotable");
		infotable.html("");
		if(status.length && status.elapsed) {
			var elapsed = status.elapsed;
			var percent = (elapsed / status.length)*100 + "%";
			$("#progressbar").css({"width":percent});
			infotable.append('<tr><td>Total time:</td><td><span class="glyphicon glyphicon-time" aria-hidden="true"></span> ' + formatTime(status.length) + "</td></tr>");
			infotable.append('<tr><td>Elapsed:</td><td><span class="glyphicon glyphicon-time" aria-hidden="true"></span> ' + formatTime(elapsed) + "</td></tr>");
		}
		else {
			$("#progressbar").css({"width":"0%"});
			infotable.append('<tr><td>Total time:</td><td><span class="glyphicon glyphicon-time" aria-hidden="true"></span> --:--</td></tr>');
			infotable.append('<tr><td>Elapsed:</td><td><span class="glyphicon glyphicon-time" aria-hidden="true"></span> --:--</td></tr>');
		}
		if(status.song == 0) {
			infotable.append('<tr><td>Currently Playing:</td><td><span class="glyphicon glyphicon-headphones" aria-hidden="true"></span> ' + playlist[0] + "</td></tr>");
		}
		else {
			infotable.append("<tr><td>Currently Playing:</td><td>Nothing</td></tr>");
		}
		if(status.state == "play") {
			infotable.append('<tr><td>Status:</td><td><span class="glyphicon glyphicon-play" aria-hidden="true"></span> Playing</td></tr>');
		}
		else {
			infotable.append('<tr><td>Status:</td><td><span class="glyphicon glyphicon-pause" aria-hidden="true"></span> Paused</td></tr>');
		}
		infotable.append("<tr><td>Songs in Playlist:</td><td>" + status["playlistlength"] + "</td></tr>");
	}
	
	function cleanUp() {
		$("#time_elapsed").html("");
		$("#time_total").html("");
		$("#progressbar_wrapper").html("");	
	}
	
	function refreshStatus() {
		$.getJSON("api.php?action=playlist", function(playlist) {
			$.getJSON("api.php?action=status", function(status) {
				displayStatus(playlist, status);
			});
		});
	}
	
	setInterval(function() {
		refreshStatus();
	}, 2000);

	$("#play").click(function() {
		$.getJSON("api.php?action=play", refreshStatus);
	});
	$("#pause").click(function() {
		$.getJSON("api.php?action=pause", refreshStatus);
	});
	$("#next").click(function() {
		$.getJSON("api.php?action=next", refreshStatus);
	});

	refreshStatus();
</script>
