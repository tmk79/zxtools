<?
/*--- CHUNK SPRITER 8X8 CONTROLLER : PREPEND ---*/
$tool_default = array(
	'sprites_size_x' => 1,
	'sprites_size_y' => 1,
	'chunks_size_x' => 8,
	'chunks_size_y' => 8,
	'sprites_chunks' => array(
		0 => array (0,0,0,0,0,0,0,0),
		1 => array (255,255,255,255,255,255,255,255),
	),
	'sprites' => array(),
);

if (!isset($_SESSION[$mode])) {
	$_SESSION[$mode] = array();
	$file = FileTypeImage::init(array('type' => 'png'));
	$img_src = $file->as_mime(array('zoom' => 2));
	$_SESSION[$mode]['imgdata'] = $file->as_binary();
}

foreach ($tool_default as $key => $val) {
	if (!isset($_SESSION[$mode][$key])) {
		$_SESSION[$mode][$key] = $val;
	}
}

function add_chunk($chunk) {
	global $mode;
	$chunk_id = array_search($chunk, $_SESSION[$mode]['sprites_chunks']);
	if ($chunk_id === false) {
		$_SESSION[$mode]['sprites_chunks'][] = $chunk;
		$chunk_id = sizeof($_SESSION[$mode]['sprites_chunks']) - 1;
	}
	return $chunk_id;
}

function tools_info() {
	global $mode;
	$sprites_chunks_qty = sizeof($_SESSION[$mode]['sprites_chunks']);
	$sprites_qty = sizeof($_SESSION[$mode]['sprites']);
	$size_x = $_SESSION[$mode]['sprites_size_x'] ? $_SESSION[$mode]['sprites_size_x'] : 'custom';
	$size_y = $_SESSION[$mode]['sprites_size_y'] ? $_SESSION[$mode]['sprites_size_y'] : 'custom';
	$html = '<span>SizeX: <span>' . $size_x . '</span></span>';
	$html .= '<span>SizeY: <span>' . $size_y . '</span></span>';
	$html .= '<span>ChunksQty: <span>' . $sprites_chunks_qty . '</span></span>';
	$html .= '<span>SpritesQty: <span>' . $sprites_qty . '</span></span>';
	return $html;
}
?>