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
	<h2>Progress</h2>
</div>

<script>
$("#progress_wrapper").hide();
$("input").change(function() {
	$("#progress_wrapper").show();
	$("form").hide();
	var formdata = new FormData($("form")[0]);
	var value = $("input").val().split("\\");
	value = value[value.length -1];
	var progress = {};
	progress.outer = $('<div class="progress"></div>').appendTo("#progress_wrapper");
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
			$("#progress_wrapper").hide();
			$("form").show();
			progress.outer.remove();
		}
	});
});
</script>
