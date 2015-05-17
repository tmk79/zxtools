<form class="" name="<?=$this->mode?>-Save" action="index.php" method="get">
	<input type="hidden" name="mode" value="<?=$this->mode?>" />
	<input type="hidden" name="action" value="SaveCurve" />
	<div class="form">
		<div class="form-header">Save curve</div>
		<div class="form-content">
			<table>
				<tr>
					<td align="right">Filename:</td>
					<td align="left"><input type="text" name="save[filename]" /></td>
				</tr>
			</table>
		</div>
		<div class="form-bottom">
			<a class="btn btn-default submit" href="#">Save</a>
			<a class="btn btn-default popup-cancel" href="#">Cancel</a>
		</div>
	</div>
</form>