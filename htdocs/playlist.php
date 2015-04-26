<h1>Playlist</h1>
<p>This is the current playlist of the music bot. You can add new songs to the playlist from <a href="?action=songs">here</a>.</p>
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Song</th>
		</tr>
	</thead>
	<tbody id="playlist">
	</tbody>
</table>
<script>
$.getJSON("api.php?action=playlist", function(data) {
	for(var i in data) {
		var song = data[i];
		var line = $("<tr></tr>")
			.append("<td>"+i+"<td>")
			.append("<td>"+song+"<td>");
		$("#playlist").append(line);
	}
});
</script>
