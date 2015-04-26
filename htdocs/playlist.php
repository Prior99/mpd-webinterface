<?php
	$mpd = new MPD();
?>
<h1>Playlist</h1>
<p>This is the current playlist of the music bot. You can add new songs to the playlist from <a href="?action=songs">here</a>.</p>
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Song</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$arr = $mpd->playlist();
		foreach($arr as $key => $value) {
			echo("<tr><td>$key</td><td>$value</td></tr>");
		}
	?>
	</tbody>
</table>
