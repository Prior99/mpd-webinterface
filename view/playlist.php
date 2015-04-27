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
