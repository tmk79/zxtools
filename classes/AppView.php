<?
class AppView {

	public function Render($controller, $view, $vars) {
		global $ajax, $mode;
		//--- include html top
		if (!$ajax) {
			include 'templates/top.php';
		} else {
			$ajax_return = array();
		}

		$view_file = 'templates/' . $mode . '/' . $view . '.php';
		echo $view_file;
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