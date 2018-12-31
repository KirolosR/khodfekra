<?php
	//json_encode($json, JSON_FORCE_OBJECT)
	require_once('helper.php');
	$json = array();
	
	$value = 0.0;
	//validate range
	if(is_float_string(clear_txt(trim($_GET['ran'])))
		&&is_float_string(clear_txt(trim($_GET['lat'])))
		&&is_float_string(clear_txt(trim($_GET['lon'])))){
		$value = clear_txt(trim($_GET['ran']));
		$lat = clear_txt(trim($_GET['lat']));
		$lon = clear_txt(trim($_GET['lon']));
	} else {
		//make error
	}
	
	//getOffersInRange($value ,$lat ,$lon)
	$json = getOffersInRange(5000 ,0.0 ,0.0);/////////////////////////////////////
	
	echo json_encode($json);
	
?>