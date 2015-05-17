<form class="ajax-form" action="index.php?ajax=1&mode=<?=$this->mode?>&action=SpriteEdit&selected_sprite_id=<?=$vars_sprite_id?>" method="post">
<input type="hidden" name="sprite" value=""/>
<div class="form">
	<div class="form-header">
		Edit Sprite: <?=$vars->sprite_id?>
		<a class="btn popup-close"><span class="glyphicon glyphicon-remove"></span></a>
	</div>
	<div class="form-content">
		<div class="image block sprite" id="sprite-<?=$sprite_id?>"><?= $vars->sprite->as_html(array('zoom' => 4))?></div>
		<div class="wrap wrap-horizontal">
			<table>
				<tr>
					<th>id:</th>
					<?foreach ($vars->chunks as $chunk_id=>$img) {?>
						<td align="center"><?=$chunk_id?></td>
					<?}?>
				</tr><tr>
					<th>chunk:</th>
					<?foreach ($vars->chunks as $chunk_id=>$img) {?>
						<td align="center"><div class="image block chunk" id="chunk-<?=$chunk_id?>"><?= $img->as_html(array('zoom' => 2))?></div></td>
					<?}?>
				</tr><tr>
					<th>used:</th>
					<?foreach ($vars->chunks as $chunk_id=>$img) {?>
						<td align="center"><?=isset($vars->chunks_used[$chunk_id]) ? $vars->chunks_used[$chunk_id] : 0?></td>
					<?}?>
				</tr>
			</table>
		</div>
	</div>
	<div class="form-bottom">
		<div class="btn-group">
			<a class="btn btn-default submit" href="#">Save</a>
			<a class="btn btn-default ajax ajax-show" href="index.php?ajax=1&mode=<?=$this->mode?>&action=ViewSprites">Cancel</a>
		</div>
	</div>
</div>
</form>
<script>
	chunks_used_coords = $.parseJSON('<?=json_encode($chunks_used_coords)?>');
</script>
