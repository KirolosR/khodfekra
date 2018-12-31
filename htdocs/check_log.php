<?php
	ob_start();
	session_start();
	require_once('helper.php');
	
	//must change echo to receive it by $_POST
	$e = clear_txt($_POST['userName']);
	$p = clear_txt($_POST['userPass']);
	
	//must change echo to send it by $_POST
	echo validate_user_for_android($e,$p);
?>