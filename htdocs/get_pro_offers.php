<?php
	ob_start();
	session_start();
	require_once('helper.php');
	
	//must change echo to receive it by $_POST
	$value = clear_txt($_POST['shid']);
	

	$json = display_offers_for_android_of($value);
	echo json_encode($json);
?>