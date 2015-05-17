<?
class AppController {

	public $mode = 'Index';
	public $default = array();
	
	public function __construct($class_name = 'Index') {
		$this->mode = preg_replace('/^Controller/i', '', $class_name);
		if (!isset($_SESSION['imgZxGridMime'])) {
			$_SESSION['imgZxGridMime'] = zx_grid(array('size' => 2));
		}
	}

	public function __call($method, $params = array()) {
		echo 'ERROR: Calling undefined method - ' . $this->mode . '::' . $method;
	}

	public function RenderView($mode, $view, $vars = false) {
		global $ajax;
		//--- include html top
		if (!$ajax) {
			include 'templates/top.php';
		} else {
			$ajax_return = array();
		}

		$view_file = 'templates/' . $mode . '/' . $view . '.php';
		if (file_exists($view_file)) {
			include($view_file);
		}

		//--- include html bottom
		if (!$ajax) {
			include 'templates/bottom.php';
		} else {
			//$time_page_total = microtime(true) - DEBUG_START;
			//$ajax_return['time_page_total'] = number_format($time_page_total, 4, '.' , '');
			if (!empty($ajax_return)) {
				echo json_encode($ajax_return);
			}
		}
	}

}
?>