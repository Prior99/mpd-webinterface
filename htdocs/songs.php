<?php
	$mpd = new MPD();
?>
<h1>Songs</h1>
<p>This is a list of all songs the music bot currently knows.</p>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Song</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$arr = $mpd->listall();
		foreach($arr as $song) {
			echo("<tr><td>$song</td></tr>");
		}
	?>
	</tbody>
</table>
