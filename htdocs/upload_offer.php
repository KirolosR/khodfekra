<?php
	ob_start();
	session_start();
	require_once("helper.php");
	error_reporting(E_ERROR | E_PARSE);
	
	//name,type,shopid,image,des,longdes,sale,lat,lon
	//title(name),image,des,longdes,sale,lat,lon from user
	//type,shopid from database
	//setOffer($n ,$t ,$sid ,$i ,$d, $ld, $s, $lat, $lon)
	
	//validate title of offer
	$n = clear_txt($_POST['ot']);
	
	$d = clear_txt($_POST['od']);
	
	$ld = clear_txt($_POST['old']);
	
	//image
	$i = validate_img();
	
	
	//validate sale value
	if(is_float_string(trim($_POST['sv']))){
		$s = $_POST['sv'];
	} else {
		//make error
	}
	//validate float -> is_float($n)
	
	
	//start and end date of offer 
	//validate start
	$sd = clear_valid_date($_POST['yearstart'],$_POST['monthstart'],$_POST['daystart']);
	//validate end date
	$ed = clear_valid_date($_POST['yearend'],$_POST['monthend'],$_POST['dayend']);
	
	//get missing data to set offer //shop id & shop and offer type
	$r = array();
	$sid = $_SESSION['user'];
	
	//getshopfield ($id , $field)
	$r = getShop($sid);
	$t = $r['ShopType'];
	
	//get the latitude and longitude
	$lat = $r['ShopLat'];
	$lon = $r['ShopLon'];
	
	//var_dump($n ,$t ,$sid ,$i ,$d, $ld, $s, $sd, $ed, $lat, $lon);

	$er = setOffer($n ,$t ,$sid ,$i ,$d, $ld, $s, $sd, $ed, $lat, $lon);
	
	if(count($err) > 0){
		$_SESSION['adError'] = $er;
		header("refresh:0; url=new_advertise.php");
	} else {
		$asdid = $r['ShopID'];
		//$_GET['asdid'] = $asdid; for android
		header("refresh:0; url=profile.php?sh=$asdid");
	}
	//print errors
	//redirect
	
?>