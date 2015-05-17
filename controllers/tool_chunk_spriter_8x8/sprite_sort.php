<?
$selected_sprite_id = isset($_GET['selected_sprite_id']) ? $_GET['selected_sprite_id'] : null;
$sort_direction = isset($_GET['sort_direction']) ? $_GET['sort_direction'] : 0;
if (is_numeric($selected_sprite_id)) {
	$id = $selected_sprite_id + ($sort_direction ? +1 : -1);
	if ($id >= 0 && $id < sizeof($_SESSION[$mode]['sprites'])) {
		$spr = $_SESSION[$mode]['sprites'][$selected_sprite_id];
		$_SESSION[$mode]['sprites'][$selected_sprite_id] = $_SESSION[$mode]['sprites'][$id];
		$_SESSION[$mode]['sprites'][$id] = $spr;
	}
}
header('Location: index.php?ajax=1&mode=' . $mode . '&action=view_sprites');
?>