<div class="tools-name">
	<a class="btn btn-info" href="index.php">&#9668;</a>
	<span class="tools-header">Online ZX Tools :: Chunk 8x8 Spriter</span>
	<div class="user">
	</div>
</div>
<div class="btn-group btn-menu">
	<a class="btn btn-default ajax ajax-show" href="index.php?ajax=1&mode=<?=$this->mode?>&action=New"><span class="glyphicon glyphicon-file"></span> New</a>
	<a class="btn btn-default ajax ajax-show" href="index.php?ajax=1&mode=<?=$this->mode?>&action=Save"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
	<a class="btn btn-default ajax ajax-show" href="index.php?ajax=1&mode=<?=$this->mode?>&action=ViewSprites"><span class="glyphicon glyphicon-eye-open"></span> View</a>
	<a class="btn btn-default" id="capture-sprite" href="#"><span class="glyphicon glyphicon-pencil"></span> Capture Sprite</a>
	<a class="btn btn-default ajax ajax-show" href="index.php?ajax=1&mode=<?=$this->mode?>&action=Help"><span class="glyphicon glyphicon-info-sign"></span> Help</a>
</div>
<div class="tools-info"><?=$this->toolInfo();?></div>

<div>
	<div class="btn-group btn-menu">
		<a class="btn btn-default ajax ajax-show" href="index.php?ajax=1&mode=file_browser&action=open_image"><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Open Image</a>
		<a class="btn btn-default active" id="img-edit-grid"><span class="glyphicon glyphicon-th"></span> Grid</a>
	</div>
	<div class="image" style="width:512px;height:384px;">
		<img class="imgCapture" src="<?=$_SESSION['imgCaptureMime']?>" />
		<div class="image-layer grid"><img src="<?=$_SESSION['imgZxGridMime']?>" /></div>
		<div class="image-layer capture" style="width:16px; height:16px;"><div></div></div>
	</div>
</div>
<script>
	sprites_size_x = <?=$_SESSION[$this->mode]['sprites_size_x']?>;
	sprites_size_y = <?=$_SESSION[$this->mode]['sprites_size_y']?>;
</script>