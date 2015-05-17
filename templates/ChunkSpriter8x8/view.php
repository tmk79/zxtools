<div class="form">
	<div class="form-header">
		View chunks / sprites
		<a class="btn popup-close"><span class="glyphicon glyphicon-remove"></span></a>
	</div>
	<div class="form-content">
		<div class="form-subheader">Sprites ( <?=sizeof($vars->sprites)?> / <?=$vars->sprites_bytesize?> bytes):</div>
		<div class="wrap wrap-horizontal">
			<table>
				<tr>
					<?for ($sprite_id=0; $sprite_id<sizeof($vars->sprites); $sprite_id++) {?>
						<td align="center"><?=$sprite_id?></td>
					<?}?>
				</tr><tr>
					<?for ($sprite_id=0; $sprite_id<sizeof($vars->sprites); $sprite_id++) {?>
						<td><div class="image block sprite" id="sprite-<?=$sprite_id?>"><?= $vars->sprites[$sprite_id]->as_html(array('zoom' => 2))?></div></td>
					<?}?>
				</tr>
			</table>
		</div>
		<div class="btn-group btn-menu">
			<a class="btn btn-default ajax ajax-show waitbox add-var:selected_sprite_id" href="index.php?ajax=1&mode=<?=$this->mode?>&action=SpriteSort&sort_direction=0">&#9668;</a>
			<a class="btn btn-default ajax ajax-show waitbox add-var:selected_sprite_id" href="index.php?ajax=1&mode=<?=$this->mode?>&action=SpriteSort&sort_direction=1">&#9658;</a>
			<a class="btn btn-default ajax ajax-show add-var:selected_sprite_id" href="index.php?ajax=1&mode=<?=$this->mode?>&action=SpriteEdit"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
			<a class="btn btn-default ajax ajax-show confirm add-var:selected_sprite_id" href="index.php?ajax=1&mode=<?=$this->mode?>&action=SpriteDelete" rel="Delete selected sprite"><span class="glyphicon glyphicon-remove"></span> Delete</a>
		</div>

	</div>
	<div class="form-content">
		<div class="form-subheader">Chunks ( <?=sizeof($vars->chunks)?> / <?=$vars->chunks_bytesize?> bytes ):</div>
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
		<div class="btn-group btn-menu">
			<a class="btn btn-default ajax ajax-show waitbox add-var:selected_chunk_id" href="index.php?ajax=1&mode=<?=$this->mode?>&action=ChunkSort&sort_direction=0">&#9668;</a>
			<a class="btn btn-default ajax ajax-show waitbox add-var:selected_chunk_id" href="index.php?ajax=1&mode=<?=$this->mode?>&action=ChunkSort&sort_direction=1">&#9658;</a>
			<a class="btn btn-default ajax ajax-show add-var:selected_chunk_id" href="index.php?ajax=1&mode=<?=$this->mode?>&action=ChunkEdit"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
			<a class="btn btn-default ajax ajax-show confirm add-var:selected_chunk_id" href="index.php?ajax=1&mode=<?=$this->mode?>&action=ChunkDelete" rel="Delete selected chunk"><span class="glyphicon glyphicon-remove"></span> Delete</a>
			<a class="btn btn-default ajax ajax-show add-var:selected_chunk_id" href="index.php?ajax=1&mode=<?=$this->mode?>&action=ChunkReplace"><span class="glyphicon glyphicon-transfer"></span> Replace</a>
		</div>
		<script>
			chunks_used_coords = $.parseJSON('<?=json_encode($chunks_used_coords)?>');
		</script>
	</div>
</div>