<form name="<?=$this->mode?>-New" class="ajax-form success-json" action="index.php?mode=<?=$this->mode?>&action=New" method="post">
	<div class="form">
		<div class="form-header">Create new spritepack</div>
		<div class="form-content">
			<table>
				<tr><td align="right">Size X:</td><td><?=interface_select_size('new[sprites_size_x]', $_SESSION[$mode]['sprites_size_x'], 32, 0)?></td></tr>
				<tr><td align="right">Size Y:</td><td><?=interface_select_size('new[sprites_size_y]', $_SESSION[$mode]['sprites_size_y'], 24, 0)?></td></tr>
				<tr><td align="right">Color Mode:</td><td><select name="new[sprites_color_mode]">
					<?foreach ($this->sprites_color_mode_def as $key=>$val) {?>
						<option value="<?=$key?>"<?= $this->sprites_color_mode == $key ? ' selected="selected"' : ''?>><?=$val?></option>
					<?}?>
				</select></td></tr>
			</table>
		</div>
		<div class="form-bottom">
			<a class="btn btn-default submit" href="#">Ok</a>
			<a class="btn btn-default popup-cancel" href="#">Cancel</a>
		</div>
	</div>
</form>