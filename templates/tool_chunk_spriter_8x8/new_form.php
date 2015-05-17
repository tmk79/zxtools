<div class="form">
	<div class="form-header">Create new spritepack</div>
	<div class="form-content">
		<div>Size X: <?=interface_select_size('sprites_size_x', $_SESSION[$mode]['sprites_size_x'], 32, 0)?></div>
		<div>Size Y: <?=interface_select_size('sprites_size_y', $_SESSION[$mode]['sprites_size_y'], 24, 0)?></div>
	</div>
	<div class="form-bottom">
		<a class="button" id="sprites-new" href="#">Ok</a>
		<a class="button popup-cancel" href="#">Cancel</a>
	</div>
</div>