<h1>Mumble Music Bot</h1>
<p class="lead">This is a music bot for mumble.</p>
<a class="btn btn-ld btn-default" id="play"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> Play</a>
<a class="btn btn-ld btn-default" id="pause"><span class="glyphicon glyphicon-pause" aria-hidden="true"></span> Pause</a>
<a class="btn btn-ld btn-default" id="next"><span class="glyphicon glyphicon-fast-forward" aria-hidden="true"></span> Next</a>
<script>
	function refreshStatus() {

	}

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
