<?
class File extends AppClass {

	public $type = 'unsupported file';
	public $is_container = false;

	public $filename = false;
	public $file_extension = false;

	static $allowed_ext = array();
	
	
	public function __construct($param) {
		parent::__construct($param);
		$this->filename = $param['filename'];
		$this->file_extension = $param['type'];
	}
	
	public static function is_type($type) {
		return in_array($type, self::$allowed_ext);
	}
	
	public static function init($param = array()) {
		$param = array_merge(array(
				'type' => false,
				'filename' => false,
			), $param
		);
		
		if (!$param['type']) {
			$path_info = pathinfo($param['filename']);
			$param['type'] = $path_info['extension'];
		}

		if (!$param['type']) {
			return new self($param);
		}

		$param['type'] = strtolower($param['type']);
		
		$childs = self::collect_child();
		foreach ($childs as $child_name=>$child_data) {
			if ($child_name::is_type($param['type'])) {
				return new $child_name($param);
			}
		}
		return new self($param);
		
	}

	public static function collect_child() {
		$childs = array();
		$dir = opendir(dirname(__FILE__));
		while ($entry = readdir($dir)) {
			if (strstr($entry, __CLASS__) && $entry != __CLASS__ . '.php') {
				$childs[str_replace('.php', '', $entry)] = true;
			}
		}
		closedir($dir);
		return $childs;
	}

	public function read_zx_bitplan(&$f) {
		$data = array();
		for ($y0=0; $y0<3; $y0++) {
			for ($y1=0; $y1<8; $y1++) {
				for ($x=0; $x<256; $x++) {
					$adr = 256*8*$y0 + 32*$y1 + $x%32 + 256*floor($x/32);
					$data[$adr] = ord(fread($f, 1));
				}
			}
		}
		return $data;
	}
}

?>