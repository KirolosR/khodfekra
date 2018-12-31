<?php
	ob_start();
	session_start();
	require_once('helper.php');
	
	$e = clear_txt($_POST['userName']);
	$p = clear_txt($_POST['userPass']);
	
	$er = array();
	
	$er = validate_user($e,$p);
	
	$_SESSION['logError']=$er;
	
	header("refresh:0; url=home.php");
?>