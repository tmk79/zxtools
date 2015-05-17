<?
if (!empty($_POST)) {
	if (!empty($_FILES) && !empty($_FILES['file'])) {
		$filename = $_FILES['file']['name'];
		$tmp_name = $_FILES['file']['tmp_name'];
		$path_info = pathinfo($filename);
		$file = FileType::init(array('type' => $path_info['extension'], 'filename' => $tmp_name));
		$img_src = $file->as_html(array('size' => 2));
		$_SESSION['tool_chunk_spriter_8x8']['imgdata'] = $file->as_png();
		die('{"img_src":"' . $img_src . '"}');
	} else {
		die('{"error":"FILE NOT FOUND"}');
	}
}
?>