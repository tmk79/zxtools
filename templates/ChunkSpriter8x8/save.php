<form name="<?=$this->mode?>-Save" action="index.php" method="get">
	<input type="hidden" name="mode" value="<?=$this->mode?>" />
	<input type="hidden" name="action" value="Save" />
	<div class="form">
		<div class="form-header">Save spritepack</div>
		<div class="form-content">
			<table>
				<tr><td align="right">Sprites mode:</td><td><select name="save[sprites_mode]">
					<option value="0">DB chunk_id * 8</option>
					<option value="1">DB chunk_id</option>
					<option value="2">DW chunk_id_adr</option>
				</select></td></tr>
				<tr><td align="right">Chunks mode:</td><td><select name="save[chunks_mode]">
					<option value="0">linear placed</option>
					<option value="1">hi-adr placed</option>
				</select></td></tr>
				<tr>
					<td align="right"><label for="save_with_code">Sample code:</label></td>
					<td align="left"><input type="checkbox" checked="checked" name="save[with_code]" id="save_with_code" /></td>
				</tr>
			</table>
		</div>
		<div class="form-bottom">
			<a class="btn btn-default submit" href="#">Ok</a>
			<a class="btn btn-default popup-cancel" href="#">Cancel</a>
		</div>
	</div>
</form>