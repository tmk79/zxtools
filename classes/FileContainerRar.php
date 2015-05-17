<?
class FileContainerRar extends FileContainer {

	public $type = 'Rar archive';
	static $allowed_ext = array('rar');

	public $files = array();
	
	public static function is_type($type) {
		return in_array($type, self::$allowed_ext);
	}
	
	public function __construct($param = array()) {
		parent::__construct($param);
		$this->filename = $param['filename'];
		$this->file_extension = $param['type'];
		if (!empty($this->filename) && file_exists($this->filename)) {
			$rar = rar_open($this->filename);
			if ($rar) {
				$entries = rar_list($rar);
				foreach($entries as $entry) {
					$this->files[] = $entry->getName();
				}
				rar_close($rar);
			}
		}
	}

	public function get_file_info($file) {
		$path_info = pathinfo($file);
		$is_dir = $path_info['extension']=='';// && (bool)preg_grep('/' . $file . '\\\\' . '/', $this->files);
		return array (
			'type' => $is_dir ? 'directory' : strtolower($path_info['extension']),
			'filename' => $file,
			'container' => $this->filename,
			'is_dir' => $is_dir,
			'is_container' => false,
		);
	}
	
	public function get_file_content($file) {
		$result = false;
		$index = array_search($file, $this->files);
		if ($index !== false) {
			$rar = rar_open($this->filename);
			if ($rar) {
				$entry = rar_entry_get($rar, $file);
				$entry->extract(false, $this->tmp);
				$result = file_get_contents($this->tmp);
				unlink($this->tmp);
				rar_close($rar);
			}
		}
		return $result;
		
	}

}
?>