<?
$selected_sprite_id = isset($_GET['selected_sprite_id']) ? $_GET['selected_sprite_id'] : null;
if (is_numeric($selected_sprite_id)) {
	unset($_SESSION[$mode]['sprites'][$selected_sprite_id]);
	$_SESSION[$mode]['sprites'] = array_values($_SESSION[$mode]['sprites']);
}
header('Location: index.php?ajax=1&mode=' . $mode . '&action=view_sprites');
?>