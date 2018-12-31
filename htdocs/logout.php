<?php
	ob_start();
	session_start();
	session_destroy();
	header("refresh:0; url=home.php");
	ob_flush();
?>