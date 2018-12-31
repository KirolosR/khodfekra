<?php
	ob_start();
	//error_reporting(0);
	error_reporting(E_ERROR | E_PARSE);
	function db_con(){
		try{
			return new PDO("mysql:hostname=ftp.byethost17.com;dbname=b17_16404411_offers2day",'b17_16404411','jesusislove');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
	}
	//insert new record(shop) in database 
	function setShop ($n, $t, $d, $m, $e, $p, $i, $a, $lat, $lon){
		$db = db_con();
		$er = array();
		//inserting shop record
		$insertShop = "INSERT INTO 
						`advertisor` (`ShopName`, 
									`ShopType`,
									`ShopDate`,
									`ShopMobile`,
									`ShopEmail`,
									`ShopPass`,
									`ShopImg`,
									`ShopAddress`,
									`ShopLat`,
									`ShopLon`)
						VALUES (? ,? ,? ,? ,? ,? ,? ,? ,? ,?);";
		$q = $db->prepare($insertShop);
		$q->bindParam(1,$n);
		$q->bindParam(2,$t);
		$q->bindParam(3,$d);
		$q->bindParam(4,$m);
		$q->bindParam(5,$e);
		$q->bindParam(6,$p);
		
		//prepare image
		$q->bindParam(7,$i);
		
		$q->bindParam(8,$a);
		$q->bindParam(9,$lat);
		$q->bindParam(10,$lon);
		
		try{
			if($q->execute()){
				if(!empty($_FILES)){
					$er = array();
					$theId = predictID('advertisor','ShopID');
					$er = upload_img('advertisor' ,$theId);
				}
			}else{
				$er[] = 'Error Saving data please check your data input!';
			}	
		}catch(PDOException $ex){
			echo $ex->getMessage();
			$er[] = 'Error Saving data please check your data input!';
		}
		
		$db = null;
		return $er;
	}
	//insert new record(offer) in database
	function setOffer($n ,$t ,$sid ,$i ,$d, $ld, $s, $sd, $ed, $lat, $lon){
		
		$db = db_con();
		$er = array();
		//inserting shop record
		//VALUES ('$n' ,'$t' ,'$sid' ,'$i' ,'$d', '$ld', '$s', '$sd', '$ed', '$lat', '$lon');
		$insertShop = "INSERT INTO 
						`offer` (`OfName`,
								`OfType`,
								`OfShopID`,
								`OfImg`,
								`OfDes`,
								`OfLongDes`,
								`OfSale`,
								`OfSDate`,
								`OfEDate`,
								`OfLat`,
								`OfLon`)
						VALUES (? ,? ,? ,? ,?, ?, ?, ?, ?, ?, ?);";
						
		$q = $db->prepare($insertShop);
		
		
		$q->bindParam(1,$n);
		$q->bindParam(2,$t);
		$q->bindParam(3,$sid);
		
		//prepare img
		$q->bindParam(4,$i);
		
		$q->bindParam(5,$d);
		$q->bindParam(6,$ld);
		$q->bindParam(7,$s);
		$q->bindParam(8,$sd);
		$q->bindParam(9,$ed);
		$q->bindParam(10,$lat);
		$q->bindParam(11,$lon);
		
		
		try{
			if($q->execute()){
				if(!empty($_FILES)){
					$er = array();
					$theId = predictID('offer','OfID');
					$er = upload_img('offer' ,$theId);
				}
			}else{
				$er[] = 'Error Saving data please check your data input!';
			}			
		}catch(PDOException $ex){
			echo $ex->getMessage();
			$er[] = 'Error Saving data please check your data input!';
		}
		
		$db = null;
		return $er;
	}
	//takes the image and update img name(path) in database
	//return the new name(path) of img to save file
	function update_img($tableName, $idField, $field, $ext, $theId){
		
		$db = db_con();
		$updateImg = "UPDATE `".$tableName."` SET `".$field."` = CONCAT(`".$idField."`,'.".$ext."') WHERE `".$idField."`= ?;";
		$q = $db->prepare($updateImg);
		$q->bindParam(1,$theId);
		try{
			$q->execute();
		}catch(PDOException $ex){
			echo $ex->getMessage();
		}
	}
	
	function upload_img($table, $theId){
		
		$error = array();
		
		//change if shop uploads/shops and if offer uploads/offers
		/*
		*	with this change:
		*	$_arg1 = &tableName;
		*	$_arg2 = &idField;
		*	$_arg3 = &field;
		*	$_arg4 = $ext; => done
		*/
		$target_dir = "uploads/";
		$_arg1 = '';
		$_arg2 = '';
		$_arg3 = '';
		if ($table == 'advertisor'){
			$target_dir = "uploads/advertisor/";
			$_arg1 = 'advertisor';
			$_arg2 = 'ShopID';
			$_arg3 = 'ShopImg';
			
		}
		if ($table == 'offer'){
			$target_dir = "uploads/offer/";
			$_arg1 = 'offer';
			$_arg2 = 'OfID';
			$_arg3 = 'OfImg';
		}
		
		$target_file = $target_dir.basename($_FILES["pics"]["name"]);
		$uploadOk = 1;
		$temp = explode(".",$_FILES["pics"]["name"]);
		$imageFileType = end($temp);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["pics"]["tmp_name"]);
			if($check !== false) {
				//echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				$error[] = "File is not an image.";
				$uploadOk = 0;
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				$error[] = "Sorry, file already exists.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["pics"]["size"] > 500000) {
				$error[] = "Sorry, your uploaded file is too large.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$error[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$error[] = "Sorry, Error occured while uploading image! Please try again later.";
		// if everything is ok, try to upload file
		} else {
			$newName = $theId.'.'.$imageFileType;
			if (move_uploaded_file($_FILES["pics"]["tmp_name"], $target_dir.$newName)) {
				update_img($_arg1,$_arg2,$_arg3,$imageFileType,$theId);
				//echo "The file ". basename( $_FILES["pics"]["name"]). " has been uploaded.";
			} else {
				$error[] = "Sorry, Error occured while uploading image! Please try again later.";
			}
		}
		return $error;
	}
	//if new record needed //get the biggest id
	function predictID($table,$idField){
		$theId = "";
		$db = db_con();
		$stmt = " SELECT $idField FROM `$table` ORDER BY $idField DESC LIMIT 1;";
		$q = $db->prepare($stmt);
		try{
			if($q->execute()){
				if ($q->rowCount() == 1){
					$theId = $q->fetchColumn();
				}
			}
		}catch(PDOException $ex){
			echo $ex->getMessage();
		}
		return $theId;
	}
	//clear_txting and escaping input
	function clear_txt($string){
		return mysql_real_escape_string(htmlentities(trim($string)));
	}
	//validating image
	function validate_img(){
		$i="default.jpg";
		if(isset($_FILES["pics"]["name"])){
			$i = $_FILES["pics"]["name"];
		} else {
			$i = "default.jpg";// make default for both 
									//(shop => uploads/advertisor)
									//(offer => uploads/offer)
		}
		return $i;
	}
	//function to retrieve specific shop
	function getShop($id){
		return getReco('advertisor','ShopID',$id);
	}
	//function to retrieve specific offer
	function getOffer($id){
		return getReco('offer', 'OfID', $id);
	}
	//return general record
	function getReco($table, $idField, $id){
		$rec = array();
		$db = db_con();
		$stmt = " SELECT * FROM `$table` WHERE `$idField`=?;";
		$q = $db->prepare($stmt);
		$q->bindParam(1,$id);
		try{
			if($q->execute()){
				if ($q->rowCount() == 1){
					$rec = $q->fetch(PDO::FETCH_ASSOC);
				}
			}
		}catch(PDOException $ex){
			echo $ex->getMessage();
		}
		return $rec;
	}
	//get offers in range $range
	function getOffersInRange($range , $fromLat, $fromLon){
		$innerjson = array();
		$db = db_con();
		$retrieveOffers = "SELECT *, ( 3959 
										* acos( cos( radians($fromLat) ) 
										* cos( radians(`OfLat`) ) 
										* cos( radians(`OfLon`) 
										- radians($fromLon) ) + sin( radians($fromLat) ) 
										* sin( radians(`OfLat`) ) ) ) AS distance 
										FROM `offer` HAVING distance < ? ORDER BY distance LIMIT 0 , 20;";
		$getShopName = "SELECT `ShopName` FROM `advertisor` WHERE `ShopID`=? ;";
		
		$q = $db->prepare($retrieveOffers);
		$q->bindParam(1,$range);
		try{
			if($q->execute()){
				while($row = $q->fetch(PDO::FETCH_ASSOC)){
					//parse the array for json ===> //OfName, OfImg, OfSale ,OfShopID
					
					//refrence code[1]
					//preparing shop name
					$shop = getShop($row['OfShopID']);
					$shopName = $shop['ShopName'];
					//preparing offer title
					$theID = $row['OfID'];
					$offerTitle = $row['OfName'];
					//check if there is an image for offer
					if(isset($row['OfImg'])){
						$imageLink = 'uploads\\offer\\'.$row['OfImg'];
					}else{
						$imageLink = 'uploads\\offer\\default.jpg';
					}
					//preparing the sale of offer
					$offerSale = $row['OfSale'];
					//put data in json map
					$offer = array (
									"name" => $shopName,
									"offer" => $offerTitle,
									"image" => $imageLink,
									"sale" => $offerSale,
									"ID" => $theID
								);
					$innerjson[] = $offer;
				}
			}
		}catch(PDOException $ex){
			echo $ex->getMessage();
		}
		$json = array("offers"=>$innerjson);
		return $json;
	}
	//to display offers in profile
	function display_offers_for_android_of($id){
		$innerjson = array();
		$db = db_con();
		$retOf = "SELECT * FROM `offer` WHERE `OfShopID`='$id'
					ORDER BY `OfID` DESC;";
		$q = $db->prepare($retOf);
		try{
			if($q->execute()){
				while($row = $q->fetch(PDO::FETCH_ASSOC)){
					//parse the array for json ===> //OfName, OfImg, OfSale ,OfShopID
					
					//refrence code[1]
					//preparing shop name
					$shop = getShop($row['OfShopID']);
					$shopName = $shop['ShopName'];
					//preparing offer title
					$theID = $row['OfID'];
					$offerTitle = $row['OfName'];
					//check if there is an image for offer
					if(isset($row['OfImg'])){
						$imageLink = 'uploads\\offer\\'.$row['OfImg'];
					}else{
						$imageLink = 'uploads\\offer\\default.jpg';
					}
					//preparing the sale of offer
					$offerSale = $row['OfSale'];
					//put data in json map
					$offer = array (
									"name" => $shopName,
									"offer" => $offerTitle,
									"image" => $imageLink,
									"sale" => $offerSale,
									"ID" => $theID
								);
					$innerjson[] = $offer;
				}
			}
		}catch(PDOException $ex){
			echo $ex->getMessage();
		}
		$json = array("offers"=>$innerjson);
		return $json;
	}
	//return long description of specific offer
	function get_json_offer($id){
		$row = getOffer($id);
		$title = $row['OfName'];
		$sDate = 'Not Available!';
		$eDate = 'Not Available!';
		$lDes = '';
		$sid = $row['OfShopID'];
		$imageLink = 'uploads\\offer\\default.jpg';
		if(isset($row['OfSDate'])){
			$sDate = $row['OfSDate'];
		}
		if(isset($row['OfEDate'])){
			$eDate = $row['OfEDate'];
		}
		if(isset($row['OfLongDes'])){
			$lDes = $row['OfLongDes'];
		}
		if(isset($row['OfImg'])){
			$imageLink = 'uploads\\offer\\'.$row['OfImg'];
		}else{
			$imageLink = 'uploads\\offer\\default.jpg';
		}
		//put data in json map
		$offer = array (
						"offerTitle" => $title,
						"startDate" => $sDate,
						"endtDate" => $eDate,
						"longDesc" => $lDes,
						"ShopId" => $sid,
						"image" => $imageLink
					);
		$innerjson[] = $offer;
		$json = array("offers"=>$innerjson);
		return $json;
		
	}
	//return profile details for android
	function get_json_pro($id){
		$row = getShop($id);
		
		$profileName = $row['ShopName'];
		
		$image = 'uploads\\advertisor\\default.jpg';
		if(isset($row['ShopImg'])){
			$image = 'uploads\\advertisor\\'.$row['ShopImg'];
		}else{
			$image = 'uploads\\advertisor\\default.jpg';
		}
		
		$address ='Not Available!';
		if($row['ShopID'] == $id){
			$address = $row['ShopID'];
		}
		
		$phone = $row['ShopMobile'];
		
		$category= $row['ShopType'];
		
		$openTime = '';
		$closeTime = '';
		$Daysoff1 = '';
		$Daysoff2 = '';
		$website = '';
		
		$ShopId = $row['OfShopID'];
		
		
		
		//put data in json map
		$offer = array (
						"profileName" => $profileName,
						"image" => $image,
						"address" => $address,
						"phone" => $phone,
						"category" => $category,
						"openTime" => $openTime,
						"closeTime" => $closeTime,
						"Daysoff1" => $Daysoff1,
						"Daysoff2" => $Daysoff2,
						"website" => $website,
						"ShopId" => $ShopId,
					);
		$innerjson[] = $offer;
		$json = array("profile"=>$innerjson);
		return $json;
	}
	//check if string value is float
	function is_float_string($string){
		if (is_numeric($string)){
			return true;
		} else {
			return false;
		}
	}
	//to validate date
	function clear_valid_date($year, $month, $day){
		//validate date of shop creation
		if(ctype_alnum($year)&&ctype_alnum($month)&&ctype_alnum($day)){
			$d = $year."-".$month."-".$day;
		} else {
			print "hello hacker, You're good (y)! but I'm the best ;)";
			header("refresh:3; url=home.php");
		}
		return $d;
	}
	//to return the top offer from database
	/*function get_top_three_offers(){
		$temp = array();
		$db = db_con();
		$getTop = "SELECT * FROM `offer` ORDER BY `OfSale` DESC LIMIT 3;";
		$q = $db->prepare($getTop);
		try{
			if($q->execute()){
				while($row = $q->fetch(PDO::FETCH_ASSOC)){
					$temp[] = $row;
				}
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		$db=null;
		return $temp;
	}
	//to display the top offers at side bar
	function display_top_offers(){
		$result = get_top_three_offers();
		foreach($result as $row){
			print 	'<li>'
						.'<a href="show_offer.php?of='.$row['OfID'].'">'
							.'<img src="uploads/offer/'.$row['OfImg'].'" >'
							.'<h4>'.$row['OfName'].'</h4>'
							.'<p>'.$row['OfDes'].'</p>'
						.'</a>'
					.'</li>';
		}
	}*/
	//to choose if user is loged welcome user else show login form
	function display_user(){
		if(isset($_SESSION['user'])){
			$row = getShop($_SESSION['user']);
			$name = $row['ShopName'];
			print '
				<p>Welcome, <a id="userLink" href="profile.php?sh='.$_SESSION['user'].'">'.$name.' </a></p>
				<a href="logout.php">logout</a>
				';
		} else {
			print '
				<form action="login_check.php" method="post">
					<span id="logError">
					';
			showErrors($_SESSION['logError']);
			print '
					</span>
					<input type="text" name="userName" placeholder="E-Mail" required/>
					<input type="password" name="userPass" placeholder="Password" required/>
					<input type="submit" value="login"/>
				</form>
				';
		}
	}
	//to view errors as array
	function showErrors($arr){
		if(isset($arr)&&count($arr)>0){
			echo "<ul>";
			foreach($arr as $error){
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
		}
		unset($_SESSION['logError']);
		unset($_SESSION['adError']);
		unset($_SESSION['signupError']);
	}
	//check if field have value else print --
	function display_field($v){
		if(isset($v)){
			return $v;
		} else {
			return "Not Available.";
		}
	}
	//validate login for user
	function validate_user($e,$p){
		$db = db_con();
		$er = array();
		$try = "SELECT * FROM `advertisor`
					WHERE `ShopEmail` = '$e'
					AND `ShopPass` = '$p';";
		$q = $db->prepare($try);
		try{
			if($q->execute()){
				if($q->rowCount() == 1){
					$row = $q->fetch(PDO::FETCH_ASSOC);
					$_SESSION['user'] = $row['ShopID'];
					$_SESSION['username']=$row['ShopName'];
					$_SESSION['logError']=array();
					$_SESSION['signupError']=array();
					$_SESSION['adError']=array();
				}else{
					$er[] = 'Invalide user name or password!';
				}
			}else{
				$er[] = 'Invalide user name or password!';
			}
		}catch(PDOException $e){
			echo $e->getMessage();
			$er[] = 'Invalide user name or password!';
		}
		return $er;
	}
	//validate login for user for android
	function validate_user_for_android($e,$p){
		$theID = null;
		$db = db_con();
		$try = "SELECT * FROM `advertisor`
					WHERE `ShopEmail` = '$e'
					AND `ShopPass` = '$p';";
		$q = $db->prepare($try);
		try{
			if($q->execute()){
				if($q->rowCount() == 1){
					$row = $q->fetch(PDO::FETCH_ASSOC);
					$theID = $row['ShopID'];
				}//make else statment to make error and sho  to user
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		return $theID;
	}
	//check if user logged in
	function check_log(){
		if(isset($_SESSION['user'])){
			return true;
		}else{
			return false;
		}
	}
	//display form to upload new offer
	function show_advertise_form(){
		print'
			<form id="newOfferForm" method="post" action="upload_offer.php" enctype="multipart/form-data">
			';
		showErrors($_SESSION['adError']);
		print	'
				<table>
					<h2>Fill Advertisement Data</h2>
					<tr>
						<td>Title:</td>
						<td><input name="ot" type="text" required/></td>
					</tr>
					<tr>
						<td>Start Date:</td>
						<td>
							<select name="daystart">
								<option> 1 </option>
								<option> 2 </option>
								<option> 3 </option>
								<option> 4 </option>
								<option> 5 </option>
								<option> 6 </option>
								<option> 7 </option>
								<option> 8 </option>
								<option> 9 </option>
								<option> 10 </option>
								<option> 11 </option>
								<option> 12 </option>
								<option> 13 </option>
								<option> 14 </option>
								<option> 15 </option>
								<option> 16 </option>
								<option> 17 </option>
								<option> 18 </option>
								<option> 19 </option>
								<option> 20 </option>
								<option> 21 </option>
								<option> 22 </option>
								<option> 23 </option>
								<option> 24 </option>
								<option> 25 </option>
								<option> 26 </option>
								<option> 27 </option>
								<option> 28 </option>
								<option> 29 </option>
								<option> 30 </option>
								<option> 31 </option>
							</select>
							
							<select name="monthstart">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
								<option>9</option>
								<option>10</option>
								<option>11</option>
								<option>12</option>
							</select>

							<select name= "yearstart">
								<option> 2015 </option>
								<option> 2016 </option>
								<option> 2017 </option>
								<option> 2018 </option>
								<option> 2019 </option>
								<option> 2020 </option>
								<option> 2021 </option>
								<option> 2022 </option>
								<option> 2023 </option>
								<option> 2024 </option>
								<option> 2025 </option>
							</select>
						</td>
					</tr>
					<tr>
						<td>End Date:</td>
						<td>
							<select name="dayend">
								<option> 1 </option>
								<option> 2 </option>
								<option> 3 </option>
								<option> 4 </option>
								<option> 5 </option>
								<option> 6 </option>
								<option> 7 </option>
								<option> 8 </option>
								<option> 9 </option>
								<option> 10 </option>
								<option> 11 </option>
								<option> 12 </option>
								<option> 13 </option>
								<option> 14 </option>
								<option> 15 </option>
								<option> 16 </option>
								<option> 17 </option>
								<option> 18 </option>
								<option> 19 </option>
								<option> 20 </option>
								<option> 21 </option>
								<option> 22 </option>
								<option> 23 </option>
								<option> 24 </option>
								<option> 25 </option>
								<option> 26 </option>
								<option> 27 </option>
								<option> 28 </option>
								<option> 29 </option>
								<option> 30 </option>
								<option> 31 </option>
							</select>
							
							<select name="monthend">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
								<option>9</option>
								<option>10</option>
								<option>11</option>
								<option>12</option>
							</select>

							<select name= "yearend">
								<option> 2015 </option>
								<option> 2016 </option>
								<option> 2017 </option>
								<option> 2018 </option>
								<option> 2019 </option>
								<option> 2020 </option>
								<option> 2021 </option>
								<option> 2022 </option>
								<option> 2023 </option>
								<option> 2024 </option>
								<option> 2025 </option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Sale Amount:</td>
						<td><input name="sv" type="text"  required/></td>
					</tr>
					<tr>
						<td>Short Description:</td>
						<td><input name="od" type="text"/></td>
					</tr>
					<tr>
						<td>Long Description:</td>
						<td><textarea name="old" form="newOfferForm"></textarea></td>
					</tr>
					<tr>
						<td>Upload Image:</td>
						<td><input name="pics" type="file"/></td>
					</tr>
					<tr><td colspan="2"><input type="submit" value="Save Offer" /></td></tr>
				</table>
			</form>
		';
	}
	//display form to sign up
	function show_signup_form(){
		print'
			<form id="form" method="post" action="shop_reg.php" enctype="multipart/form-data">
			';
		showErrors($_SESSION['signupError']);
		print	'
				<table>
					<h2>Sign Up With Us</h2>
					<tr>
						<td>Shop Name:</td>
						<td><input name="sn" type="text" required/></td>
					</tr>
					<tr>
						<td>Category:</td>
						<td><input name="st" type="text" required/></td>
					</tr>
					<tr>
						<td>Date Started:</td>
						<td>
							<select name="day">
								<option> 1 </option>
								<option> 2 </option>
								<option> 3 </option>
								<option> 4 </option>
								<option> 5 </option>
								<option> 6 </option>
								<option> 7 </option>
								<option> 8 </option>
								<option> 9 </option>
								<option> 10 </option>
								<option> 11 </option>
								<option> 12 </option>
								<option> 13 </option>
								<option> 14 </option>
								<option> 15 </option>
								<option> 16 </option>
								<option> 17 </option>
								<option> 18 </option>
								<option> 19 </option>
								<option> 20 </option>
								<option> 21 </option>
								<option> 22 </option>
								<option> 23 </option>
								<option> 24 </option>
								<option> 25 </option>
								<option> 26 </option>
								<option> 27 </option>
								<option> 28 </option>
								<option> 29 </option>
								<option> 30 </option>
								<option> 31 </option>
							</select>
							
							<select name="month">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
								<option>9</option>
								<option>10</option>
								<option>11</option>
								<option>12</option>
							</select>

							<select name= "year">
								<option> 1990 </option>
								<option> 1991 </option>
								<option> 1992 </option>
								<option> 1993 </option>
								<option> 1994 </option>
								<option> 1995 </option>
								<option> 1996 </option>
								<option> 1997 </option>
								<option> 1998 </option>
								<option> 1999 </option>
								<option> 2000 </option>
								<option> 2001 </option>
								<option> 2002 </option>
								<option> 2003 </option>
								<option> 2004 </option>
								<option> 2005 </option>
								<option> 2006 </option>
								<option> 2007 </option>
								<option> 2008 </option>
								<option> 2009 </option>
								<option> 2010 </option>
								<option> 2011 </option>
								<option> 2012 </option>
								<option> 2013 </option>
								<option> 2014 </option>
								<option> 2015 </option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Mobile:</td>
						<td><input name="sm" type="text" required/></td>
					</tr>
					<tr>
						<td>E-mail:</td>
						<td><input name="se" type="text" required/></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input name="sp" type="password" required/></td>
					</tr>
					<tr>
						<td>Confirm Password:</td>
						<td><input name="spc" type="password" required/></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><input name="sa" type="text" required/></td>
					</tr>
					<tr>
						<td>Upload Image:</td>
						<td><input name="pics" type="file"/></td>
					</tr>
					<tr>
						<td>Pick-up your location:</td>
						<td><div id="googleMap" style="width:500px;height:200px;"></div></td>
					</tr>
					<tr><td colspan="2"><input type="submit" value="Sign Up" /></td></tr>
					<tr><td colspan="2">Or if you already have account, please login.</td></tr>
				</table>
			</form>
		';
	}
	//to display the offer on seperate page
	function display_big_offer($theOffer){
		$data = getOffer($theOffer);
		$rec = getShop($data['OfShopID']);
		$shopAddress = $rec['ShopAddress'];
		$shopName = $rec['ShopName'];
		print '
				<img src="uploads/offer/'.$data['OfImg'].'">
				<h2>'.$data['OfName'].'</h2>
				<span id="sale">Sale '.display_field($data['OfSale']).'%</span>
				<ul id="details">
					<li>
						<span class="section">Shop:</span>
						<p>'.$shopName.'</p>
					</li>
					<li>
						<span class="section">Category:</span>
						<p>'.display_field($data['OfType']).'</p>
					</li>
					<li>
						<span class="section">Start Date:</span>
						<p>'.display_field($data['OfSDate']).'</p>
					</li>
					<li>
						<span class="section">End Date:</span>
						<p>'.display_field($data['OfEDate']).'</p>
					</li>
					<li>
						<span class="section">Description:</span>
						<p>
							'.display_field($data['OfLongDes']).'
						</p>
					</li>
					<li>
						<span class="section">Address:</span>
						<p>'.display_field($shopAddress).'</p>
					</li>
					<li>
						<span class="section">Location:</span>
						<p><div id="googleMap" style="width:500px;height:200px;"></div></p>
					</li>
				</ul>
				<div id="dom-target1" style="display: none;">
				'.$data['OfLat'].'
				</div>
				<div id="dom-target2" style="display: none;">
				'.$data['OfLon'].'
				</div>
					
				';
	}
	//the main offers page showing all
	function display_all_offers_page($range , $fromLat, $fromLon){
		if(!isset($range)){
			$range = 7000;
		}
		if(!isset($fromLat)){
			$fromLat = 29.59493454965144;
		}
		if(!isset($fromLon)){
			$fromLon = 31.3330078125;
		}
		$db = db_con();
		$retrieveOffers = "SELECT *, ( 3959 
										* acos( cos( radians($fromLat) ) 
										* cos( radians(`OfLat`) ) 
										* cos( radians(`OfLon`) 
										- radians($fromLon) ) + sin( radians($fromLat) ) 
										* sin( radians(`OfLat`) ) ) ) AS distance 
										FROM `offer` HAVING distance < ? ORDER BY distance LIMIT 0 , 20;";
		
		$q = $db->prepare($retrieveOffers);
		$q->bindParam(1,$range);
		try{
			if($q->execute()){
				while($row = $q->fetch(PDO::FETCH_ASSOC)){
					$theImg = "uploads/offer/default.jpg";
					if($row['OfImg']!=""){
						$theImg = "uploads/offer/".$row['OfImg'];
					}
					print '
						<li class="singleOffer" style="background:url('.$theImg.') no-repeat;-webkit-background-size: 100% 100%;background-size:100%;">
							<a href="show_offer.php?of='.$row['OfID'].'">
								<div class="OfDet">
									<h3 class="singleOfferTitle">'.$row['OfName'].'</h3>
									<p class="singleOfferDescription">'.$row['OfDes'].'.</p>
								</div>
							</a>
						</li>
					';
				}
			}
		}catch(PDOException $ex){
			echo $ex->getMessage();
		}
	}
	//to display offers in profile
	function display_offers_of($id){
		$db = db_con();
		$retOf = "SELECT * FROM `offer` WHERE `OfShopID`='$id'
					ORDER BY `OfID` DESC;";
		$q = $db->prepare($retOf);
		try{
			if($q->execute()){
				while($row = $q->fetch(PDO::FETCH_ASSOC)){
					$theImg = "uploads/offer/default.jpg";
					if($row['OfImg']!=""){
						$theImg = "uploads/offer/".$row['OfImg'];
					}
					print '
						<li>
							<a href="show_offer.php?of='.$row['OfID'].'">
								<img src="'.$theImg.'"/>
								<h3>'.$row['OfName'].'</h3>
								<p>'.$row['OfDes'].'</p>
							</a>
						</li>
					';
				}
			}
		}catch(PDOException $ex){
			echo $ex->getMessage();
		}
	}
	ob_flush();
?>
<?php
/* [1]
$shopName = "";
$getstmt = $db->prepare($getShopName);

$getstmt->bindParam(1,$row['OfShopID']);
try{
	if($getstmt->execute()){
		if($getstmt->rowCount() == 1){
			$shopName = $getstmt->fetchColumn();
		}
	}
}catch(PDOException $ex){
	echo $ex->getMessage();
}
*/
?>
















