<?
function zx_grid ($param = array()) {
	$param = array_merge(array(
			'size' => 1
		), $param
	);

	$mult = $param['size'] * 8;
	$img = imagecreatetruecolor(32 * $mult, 24 * $mult);
	$white = imagecolorallocate($img, 255,255,255);
	
	for ($y=0; $y<24; $y++) {
		for ($x=0; $x<32; $x+=2) {
			$xx = ($y%2 + $x) * $mult;
			$yy = $y * $mult;
			imagefilledrectangle($img, $xx, $yy, $xx + $mult - 1, $yy + $mult - 1, $white);
		}
	}
	ob_start();
	imagepng($img);
	$imgdata = ob_get_clean();
	return 'data:image/jpeg;base64,' . base64_encode($imgdata); 
}


function interface_select_size($name, $default = false, $max, $min = 1, $step = 1) {
	$html = '<select name="' . $name . '">';
	while ($min <= $max) {
		$html .= '<option value="' . $min . '"' . ($min==$default ? ' selected="selected"' : '') . '>' . ($min==0 ? 'custom' : $min) . '</option>';
		$min += $step;
	}
	$html .= '</select>';
	return $html;
}
?>