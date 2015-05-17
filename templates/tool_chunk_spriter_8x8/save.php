<div class="form">
	<div class="form-header">Save sprites data</div>
	<div class="form-content">
		<table>
			<tr><td>Sprites label prefix:</td><td><input type="text" name="save[sprites_label_prefix]" /></td></tr>
			<tr><td>Chunks label prefix:</td><td><input type="text" name="save[chunks_label_prefix]" /></td></tr>
			<tr><td>Remove unused chunks:</td><td><input type="checkbox" name="save[remove_unused_chunks]" checked="checked" /></td></tr>
		</table>
	</div>
	<div class="form-bottom">
		<a class="button save save-sendform" href="index.php?mode=<?=$mode?>&action=save">Ok</a>
		<a class="button popup-cancel" href="#">Cancel</a>
	</div>
</div>