<?
class FileContainerZip extends FileContainer {

	public $type = 'Zip archive';
	static $allowed_ext = array('zip');

	private $zip = false;
	public $files = array();
	
	public static function is_type($type) {
		return in_array($type, self::$allowed_ext);
	}
	
	public function __construct($param = array()) {
		$this->filename = $param['filename'];
		$this->file_extension = $param['type'];
		
		if (!empty($this->filename) && file_exists($this->filename)) {
			$zip = zip_open($this->filename);
			if ($zip) {
				while ($zip_entry = zip_read($zip)) {
					$this->files[] = zip_entry_name($zip_entry);
				}
				zip_close($zip);
			}
		}
	}

	public function get_file_info($file) {
		$path_info = pathinfo($file);
		$is_dir = (substr($file, strlen($file)-1) == '/');
		return array (
			'type' => $is_dir ? 'directory' : $path_info['extension'],
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
			$zip = zip_open($this->filename);
			if ($zip) {
				while ($zip_entry = zip_read($zip)) {
					if (zip_entry_name($zip_entry) == $file) {
						$result = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
					}
				}
				zip_close($zip);
			}
		}
		return $result;
	}

}
?>