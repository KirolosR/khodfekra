<?php
	ob_start();
	session_start();
	require_once("helper.php");
	//error_reporting(E_ERROR | E_PARSE);
	//setShop ($n, $t, $d, $m, $e, $p, $i, $a, $lat, $lon) format
	//prepare array to hold errors while validation
	$er[] = array();
	
	
	//validate name of shop
	if (preg_match("/^[a-zA-Z0-9 ]*$/",$_POST['sn'])){
		$n = clear_txt($_POST['sn']);
	} else {
		$er[] = "Sorry, Not valide name! only characters allowed!";
	}
	
	
	//validate type of shop
	$t = clear_txt($_POST['st']);
	
	//validate date of shop creation
	$d = clear_valid_date($_POST['year'],$_POST['month'],$_POST['day']);
	
	//validate mobile
	$m = clear_txt($_POST['sm']);
	
	//validate e-mail
	if (filter_var(clear_txt($_POST['se']), FILTER_VALIDATE_EMAIL)){
		$e = $_POST['se'];
	} else {
		$er[] = "Email format not right! Please try this form alice@domain.com";
	}
	
	//validate if password and confirmation are identical
	if ($_POST['sp'] == $_POST['spc']){
		$p = $_POST['sp'];
	} else {
		$er[] = "Password confirmation did not match!";
	}
	
	$i = validate_img();
	
	//validate address
	if(isset($_POST['sa'])){
		$a = clear_txt($_POST['sa']);
	} else {
		$er[] = "Please provide address!";
	}
	
	//get the latitude and longitude
	$lat = $_POST['lon'];
	$lon = $_POST['lat'];
	
	
	$er[] = array_merge($er,setShop($n, $t, $d, $m, $e, $p, $i, $a, $lat, $lon));
	
	$id = 0;
	//change criteria to print unordered list <ul>
	if(count($err) > 0){// print errors
		$_SESSION['signupError'] = $er;
		header("refresh:0; url=new_advertise.php");
	} else {
		$id = predictID('advertisor','ShopID');
		$row = getShop($id);
		$_SESSION['user'] = $row['ShopID'];
		$_SESSION['username']=$row['ShopName'];
	}
	
	print '<h1 style="margin-top:50px;text-align:center; color:#525252;">You have been registered successfully!</h1>';
	print '<p style="text-align:center; color:#525252;">You will be redirect in 2 seconds.</p>';
	
	
	header("refresh:2; url=profile.php?sh=$id");
	//at profile check if no query 
	//use current session of id , 
	//if not return to home
	
	
	
	//print "you will be redirected"
	//make header statment to redirect
	//delete echo!
	//echo "done";
	
	/*
	$sections = array(’home’, ’news’, ’photos’, ’blog’);
		if (in_array($_GET[’section’], $sections)){
			$clean[’section’] = $_GET[’section’];
		}
		else{
			
		}
	*/
?>