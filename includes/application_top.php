<?
session_start();

define ('DEBUG_START', microtime(true));

include dirname(__FILE__) . '/settings.php';
include dirname(__FILE__) . '/functions.php';
include dirname(__FILE__) . '/../classes/App.php';

App::apl();
?>