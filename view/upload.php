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
<style>

.fileWrapper {
	width: 100%;
	margin: auto;
	position: relative;
	background-color: rgba(179, 179, 179, 0.2);
	color: rgb(179, 179, 179);
	border: 4px dashed rgb(179, 179, 179);
	border-radius: 4px;
	overflow: hidden;
	height: 200px;
	text-align: center;
	padding-top: 70px;
}

.fileWrapper span{
	font-size: 15pt;
	margin: auto;
}

.fileWrapper input{
	position: absolute;
	top: 0;
	left: 0;
	margin: 0;
	padding: 0;
	cursor: pointer;
	opacity: .0;
	height: 200px;
	width: inherit;
}

</style>
<h1>Upload</h1>
<p>You can upload new songs here.</p>

<form action="upload.php" method="post" enctype="multipart/form-data">
	<h1>Select a file</h1>
	<div class="fileWrapper">
		<span>Drag Files Here</span><br />
		<span style="font-size: 12pt;">(Or click and select)</span>
		<input type="file" name="upload[]" multiple="multiple"/>
	</div>
</form>
<div id="progress_wrapper">
	<h2>Files</h2>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Filename</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody id="filelist">
		</tbody>
	</table>
	<h2>Progress</h2>
	<div id="progressbar_wrapper">
	</div>
</div>

<script>
$("#progress_wrapper").hide();
$(":file").change(function() {
	$("#progress_wrapper").show();
	$("form").hide();
	var formdata = new FormData($("form")[0]);

	var files = [];
	$("#progressbar_wrapper").html("");
	for(var i = 0; i < this.files.length; i++) {
		var file = this.files[i];
		var name = file.name;
		var row = $('<tr><td>' + name + '</td></tr>').append().appendTo("#filelist");
		var symbol = $('<td><span class="glyphicon glyphicon-upload" aria-hidden="true"></span></td>');
		symbol.appendTo(row);
		files[name] = {
			symbol: symbol,
			row : row
		};

	}

	var progress = {};
	progress.outer = $('<div class="progress"></div>').appendTo("#progressbar_wrapper");
	progress.inner = $('<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">').appendTo(progress.outer);

	function updateProgress(e) {
		if(e.lengthComputable) {
			var percent = parseInt((e.loaded/e.total)*100) +"%";
			progress.inner.css({"width" : percent});
		}
	}

	$.ajax({
		url : "api.php?action=upload",
		type : "POST",
		xhr : function() {
			var xhr = $.ajaxSettings.xhr();
			if(xhr.upload) {
				xhr.upload.addEventListener("progress", updateProgress, false);
			}
			return xhr;
		},
		cache : false,
		data: formdata,
		processData: false,
		contentType : false,
		success : function(json) {
			var data = JSON.parse(json);
			for(var key in data) {
				var file = data[key];
				var elem = files[key];
				elem.symbol.remove();
				if(file.okay) {
					elem.symbol = $('<td><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>').appendTo(elem.row);
				}
				else {
					elem.symbol = $('<td><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></td>').appendTo(elem.row);
				}
			}
			$("form").show();
		}
	});
});
</script>
