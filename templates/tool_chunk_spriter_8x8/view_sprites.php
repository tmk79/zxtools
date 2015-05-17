<b>Sprites ( <?=$sprites_qty?> / <?=$sprites_bytesize?> bytes / <?=$sprites_bytesize * 8?> bytes - as raw sprite):</b>
<div class="wrap wrap-horizontal">
	<?foreach ($sprite_imgs as $sprite_id=>$img) {?>
		<div class="image block sprite" id="sprite-<?=$sprite_id?>"><?= $img->as_html(array('zoom' => 2))?></div>
	<?}?>
</div>
<div>
	<a class="button ajax ajax-show add-var:selected_sprite_id" href="index.php?ajax=1&mode=<?=$mode?>&action=sprite_sort&sort_direction=0">&#9668;</a>
	<a class="button ajax ajax-show add-var:selected_sprite_id" href="index.php?ajax=1&mode=<?=$mode?>&action=sprite_sort&sort_direction=1">&#9658;</a>
	<a class="button ajax ajax-show add-var:selected_sprite_id" href="index.php?ajax=1&mode=<?=$mode?>&action=sprite_edit">Edit</a>
	<a class="button ajax ajax-show confirm add-var:selected_sprite_id" href="index.php?ajax=1&mode=<?=$mode?>&action=sprite_delete" rel="Delete selected sprite">Delete</a>
</div>

<br />
<b>Chunks ( <?=$chunks_qty?> / <?=$chunks_bytesize?> bytes ):</b>
<div class="wrap wrap-horizontal">
	<table>
		<tr>
			<th>id:</th>
			<?foreach ($chunks_imgs as $chunk_id=>$img) {?>
				<td align="center"><?=$chunk_id?></td>
			<?}?>
		</tr><tr>
			<th>chunk:</th>
			<?foreach ($chunks_imgs as $chunk_id=>$img) {?>
				<td align="center"><div class="image block chunk" id="chunk-<?=$chunk_id?>"><?= $img->as_html(array('zoom' => 2))?></div></td>
			<?}?>
		</tr><tr>
			<th>used:</th>
			<?foreach ($chunks_imgs as $chunk_id=>$img) {?>
				<td align="center"><?=isset($chunks_used[$chunk_id]) ? $chunks_used[$chunk_id] : 0?></td>
			<?}?>
		</tr>
	</table>
</div>
<div>
	<a class="button ajax ajax-show add-var:selected_chunk_id" href="index.php?ajax=1&mode=<?=$mode?>&action=chunk_sort&sort_direction=0">&#9668;</a>
	<a class="button ajax ajax-show add-var:selected_chunk_id" href="index.php?ajax=1&mode=<?=$mode?>&action=chunk_sort&sort_direction=1">&#9658;</a>
	<a class="button ajax ajax-show add-var:selected_chunk_id" href="index.php?ajax=1&mode=<?=$mode?>&action=chunk_edit">Edit</a>
	<a class="button ajax ajax-show confirm add-var:selected_chunk_id" href="index.php?ajax=1&mode=<?=$mode?>&action=chunk_delete" rel="Delete selected chunk">Delete</a>
	<a class="button ajax ajax-show add-var:selected_chunk_id" href="index.php?ajax=1&mode=<?=$mode?>&action=chunk_replace">Replace</a>
</div>
<script>
	chunks_used_coords = $.parseJSON('<?=json_encode($chunks_used_coords)?>');
</script>