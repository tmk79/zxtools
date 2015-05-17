<?
class FileTypeImage extends FileType {

	public $type = 'Image';
	static $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

	public $img = false;
	protected $size_x = false;
	protected $size_y = false;
	
	public static function is_type($type) {
		return in_array($type, self::$allowed_ext);
	}
	
	public function __construct($param = array()){
		$param = array_merge(array(
				'filename' => false,
				'type' => false,
				'size_x' => 256,
				'size_y' => 192,
			), $param
		);
		$this->size_x = (int)$param['size_x'] ? (int)$param['size_x'] : 1;
		$this->size_y = (int)$param['size_y'] ? (int)$param['size_y'] : 1;
		$this->filename = $param['filename'];
		$this->file_extension = $param['type'];
		
		if (!empty($this->filename)) {
			$this->open();
		} else {
			$this->create($param);
		}
	}
	
	private function create($param = array()) {
		$this->img = imagecreatetruecolor($this->size_x, $this->size_y);
	}
	
	private function as_($param = array(), $ret_as = 0) {
		$param = array_merge(array(
				'zoom' => 1,
			), $param
		);
		$zoom = (int)$param['zoom'] ? (int)$param['zoom'] : 1;
		if ($zoom != 1) {
			$img = imagecreatetruecolor($this->size_x * $zoom, $this->size_y * $zoom);
			imagecopyresampled($img, $this->img, 0, 0, 0, 0, $this->size_x * $zoom, $this->size_y * $zoom, $this->size_x, $this->size_y);
		} else {
			$img = $this->img;
		}
		ob_start();
		imagepng($img);
		$return = ob_get_clean();
		switch ($ret_as) {
			case self::AS_BASE64:
				$return = base64_encode($return);
				break;
			case self::AS_MIME:
				$return = 'data:image/jpeg;base64,' . base64_encode($return);
				break;
			case self::AS_HTML:
				$return = '<img src="data:image/jpeg;base64,' . base64_encode($return) . '" />';
				break;
		}
		return $return;
	}

	public function as_binary($param = array()) {
		return $this->as_($param, self::AS_BINARY);
	}
	
	public function as_base64($param = array()) {
		return $this->as_($param, self::AS_BASE64);
	}

	public function as_mime($param = array()) {
		return $this->as_($param, self::AS_MIME);
	}	

	public function as_html($param = array()) {
		return $this->as_($param, self::AS_HTML);
	}
}
?>