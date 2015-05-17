<?
$sprites = $_SESSION[$mode]['sprites'];
$chunks = $_SESSION[$mode]['sprites_chunks'];

$sprite_imgs = array();
$sprites_qty = sizeof($sprites);
$sprites_bytesize = 0;
foreach ($sprites as $sprite_id=>$sprite) {
	$size_y = sizeof($sprite);
	$size_x = sizeof($sprite[0]);
	$sprites_bytesize += $size_y * $size_x;
	$img = new FileTypeImage(array('size_x' => $size_x * 8, 'size_y' => $size_y * 8));
	for ($y=0; $y<$size_y; $y++) {
		for ($x=0; $x<$size_x; $x++) {
			$chunk_id = $sprite[$y][$x];
			$chunk = $chunks[$chunk_id];
			for ($yb=0; $yb<8; $yb++) {
				$yy = $y * 8 + $yb;
				$byte = $chunk[$yb];
				for ($xb=0; $xb<8; $xb++) {
					$bit = (bool)(pow(2, (7 - $xb)) & $byte);
					$color = imagecolorallocate($img->img, 255 * $bit, 255 * $bit, 255 * $bit);
					$xx = $x * 8 + $xb;
					imagefilledrectangle($img->img, $xx, $yy, $xx + 1, $yy + 1, $color);
				}
			}
		}
	}
	$sprite_imgs[] = clone($img);
}

$chunks_imgs = array();
$chunks_qty = sizeof($chunks);
$chunks_bytesize = $chunks_qty * 8;
foreach ($chunks as $chunk_id=>$chunk) {
	$img = new FileTypeImage(array('size_x' => 8, 'size_y' => 8));
	for ($yb=0; $yb<8; $yb++) {
		$byte = $chunk[$yb];
		for ($xb=0; $xb<8; $xb++) {
			$bit = (bool)(pow(2, (7 - $xb)) & $byte);
			$color = imagecolorallocate($img->img, 255 * $bit, 255 * $bit, 255 * $bit);
			imagefilledrectangle($img->img, $xb, $yb, $xb + 1, $yb + 1, $color);
		}
	}
	$chunks_imgs[] = clone($img);
}

?>