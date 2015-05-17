<div class="tools-name">
	Online ZX Tools :: Chunk 8x8 Spriter
</div>
<div class="tools-menu">
	<a class="button" href="index.php">&#9668;</a>
	<a class="button ajax ajax-show" href="index.php?ajax=1&mode=<?=$mode?>&action=new_form">New</a>
	<a class="button ajax ajax-show" href="index.php?ajax=1&mode=<?=$mode?>&action=save">Save</a>
	<a class="button ajax ajax-show" href="index.php?ajax=1&mode=<?=$mode?>&action=view_sprites">View</a>
	<a class="button" id="capture-sprite" href="#">Capture Sprite</a>
	<a class="button ajax ajax-show" href="index.php?ajax=1&mode=<?=$mode?>&action=help">Help</a>
</div>
<div class="tools-info"><?=tools_info();?></div>

<div>
	<div class="image-menu">
		<a class="button ajax ajax-show" href="index.php?ajax=1&mode=file_browser&action=open_image">Open Image</a>
		<a class="button" id="img-edit-grid">Grid</a>
	</div>
	<div class="image" style="width:512px;height:384px;">
		<img id="image" src="<?=$img_src?>" />
		<div class="image-layer grid"><?=$zx_grid?></div>
		<div class="image-layer capture" style="width:16px; height:16px;"><div></div></div>
	</div>
</div>