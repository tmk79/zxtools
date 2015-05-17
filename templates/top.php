<!DOCTYPE html>
<html lang="ru">
	<head>
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type='text/css' href="/includes/bootstrap/css/bootstrap.min.css" />
		<link rel='stylesheet' type='text/css' href='/includes/interface.css' />
		<link rel='stylesheet' type='text/css' href='/includes/styles.css' />
		<link rel='stylesheet' type='text/css' href='/includes/popup/popup.css' />
		<script type="text/javascript" src='/includes/jquery.js'></script>
		<script type="text/javascript" src='/includes/jquery.form.js'></script>
		<?/*<script type="text/javascript" src="/includes/bootstrap/js/bootstrap.min.js"></script>*/?>
		<script type="text/javascript" src='/includes/popup/popup.js'></script>
		<script type="text/javascript" src='/includes/script.js'></script>
		<?if (file_exists('js/' . $mode . '.js')){?>
		<script type="text/javascript" src='/<?='js/' . $mode . '.js'?>'></script>
		<?}?>
	</head>
<body>
<div style="border: 1px solid red; background:red;color: white;">TOP</div>