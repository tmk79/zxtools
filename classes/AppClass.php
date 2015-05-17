<?
class AppClass {

	protected $id = false;
	protected $tmp = false;
	protected $error = false;

	public function __construct($param = array()) {
		$this->id = __CLASS__ . md5(json_encode($param));
		$this->tmp = $this->id . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . microtime(true);
	}

}
?>