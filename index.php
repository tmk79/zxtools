<?
include 'includes/application_top.php';

//foreach ($_SESSION as $key=>$val) { unset($_SESSION[$key]); }

$mode = isset($_GET['mode']) ? $_GET['mode'] : false;
$action = isset($_GET['action']) ? $_GET['action'] : false;
$ajax = isset($_GET['ajax']);

$class_name = !empty($mode) ? $mode : 'Index';
$controller_name = 'Controller' . $class_name;
$action_name = !empty($action) ? 'action' . $action : 'actionIndex';
if (file_exists('controllers/' . $controller_name . '.php')) {
	$controller = new $controller_name();
	$controller->$action_name();
}

include 'includes/application_bottom.php';
?>