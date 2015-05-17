<?
class FileContainer extends File {

	public $is_container = true;

	public function __construct($param) {
		parent::__construct($param);
	}
	
	//echo collect_child
	public static function test() {
		return $this->collect_child();
	}

	public function get_file_by_param($param) {
		$param = array_merge(array(
			'filename' => false,
			'types' => array(),
			'in_dir' => false,
		),$param);
		$result = array();
		foreach ($this->files as $file) {
			$info = $this->get_file_info($file);
			$test = true;
			
			if (!empty($param['filename'])) {
				$test &= strtolower($param['filename']) == strtolower($file);
			}
			if (!empty($param['types'])) {
				$test &= in_array($info['type'], $param['types']);
			}
			$test &= ($param['in_dir'] or (!strstr($file, '/') && !strstr($file, '\\')));
			if ($test) {
			$result[] = $file;
			}
		}
		return $result;
	}
}
?>