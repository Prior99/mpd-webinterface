<h1>Songs</h1>
<p>This is a list of all songs the music bot currently knows.</p>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Song</th>
		</tr>
	</thead>
	<tbody id="songs">

	</tbody>
</table>
<script>
function reloadSongs() {
	$("#songs").html("");
	$.getJSON("api.php?action=songs", function(songs) {
		$.getJSON("api.php?action=playlist", function(playlist) {
			for(var i in songs) {
				(function(song) {
					var add = $('<a class="btn btn-xs btn-success">Add</a>').click(function() {
						$.getJSON("api.php?action=add&song=" + song, function() {
							reloadSongs();
						});
					});
					var line = $("<tr></tr>").append("<td>"+song+"<td>");
					if(playlist.indexOf(song) !== -1) {
						line.append($('<td><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></td>'));
						line.append($('<td><a class="btn btn-xs btn-success disabled">Add</a></td>'));
					}
					else {
						line.append($('<td><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>'));
						line.append($("<td></td>").append(add));
					}
					$("#songs").append(line);
				})(songs[i]);
			}
		});
	});
}

reloadSongs();

</script>
