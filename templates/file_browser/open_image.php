<form class="form-open form-open-image" method="post" enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>">
	<div class="form">
		<div class="form-header">Open Image</div>
		<div class="form-content">
			<input type="hidden" name="post" value="1" />
			<input type="file" name="file" id="file" />
			<div class="form-waitbox">Uploading image in progress...</div>
		</div>
		<div class="form-bottom">
			<a class="button button-open button-open-image" href="#">Ok</a>
			<a class="button popup-cancel" href="#">Cancel</a>
		</div>
	</div>
</form>