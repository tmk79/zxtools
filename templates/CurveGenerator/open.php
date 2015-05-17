<form class="ajax-form ajax-reload waitbox" method="post" enctype="multipart/form-data" action="index.php?mode=<?=$this->mode?>&action=OpenCurve&ajax=1">
	<div class="form">
		<div class="form-header">Open Curve</div>
		<div class="form-content">
			<input type="file" name="file" id="file" />
		</div>
		<div class="form-bottom">
			<a class="btn btn-default submit" href="#">Open</a>
			<a class="btn btn-default popup-cancel" href="#">Cancel</a>
		</div>
	</div>
</form>