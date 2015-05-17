<?
class FileType extends File {

	const AS_BINARY = 0;
	const AS_BASE64 = 1;
	const AS_MIME = 2;
	const AS_HTML = 3;
	
	public function as_binary($param = array()) {
		return false;
	}

	public function as_base64($param = array()) {
		return false;
	}
	
	public function as_mime($param = array()) {
		return false;
	}
	
	public function as_html($param = array()) {
		return false;
	}

}
?>