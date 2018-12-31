<?php
	ob_start();
	session_start();
	require_once('helper.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
					"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>5od Fekra - Offers</title>
		
		<meta charset="utf-8"/>
		<link href="css/style.css" rel="stylesheet"/>
	</head>
	<body>
		<div id="header-home">
			<div class="warp">
				<div id="logo-home">
					<h1><a href="home.php">5od Fekra</a></h1>
				</div><!-- logo-home -->
				<div id="head-Side">
					<ul id="nav">
						<li><a href="home.php">Home</a></li>
						<li class="selected"><a href="show_offers.php">Offers</a></li>
						<li><a href="new_advertise.php">Advertise</a></li>
						<?php
							if(isset($_SESSION['user'])){
								$d = $_SESSION['user'];
								echo '<li><a href="profile.php?sh='.$d.'">Profile</a></li>';
							}
						?>
					</ul>
					<div id="loginForm">
						<?php display_user(); ?>
					</div><!-- loginForm -->
				</div>
			</div><!-- warp -->
		</div><!-- header-home -->
		<div>
			<div class="warp"  id="main-offers">
				<div id="offers">
					<h2>Featured Offers</h2>
					<ul>
						<?php
							
							//initial value
							$range = 7000;
							$fromLat = 29.59493454965144;
							$fromLon = 31.3330078125;
						
							$r = $_POST['rang'];
							$fromLat = $_POST['lat']; 
							$fromLon = $_POST['lon'];
							display_all_offers_page($r,$fromLat, $fromLon);
						?>
						<!--
						<li class="singleOffer" style="background:url(temp/home_bg.jpg) no-repeat;">
							<a href="#">
								<div class="OfDet">
									<h3 class="singleOfferTitle">Title For singleOffer</h3>
									<p class="singleOfferDescription">Description For Cat.</p>
								</div>
							</a>
						</li>
						-->
					</ul>
				</div><!-- #offers -->
				<div id = "offersOptions">
					<h2>Filter Offers</h2>
					<form id="form" action="show_offers.php" method="post">
						<h4>Pick your current location:</h4>
						<div id="googleMap" style="width:100%;height:200px;"></div>
						<h4>Choose maximum distance suit you:</h4>
						<p style="text-align:center;"><span id="val">3500</span> Miles</p>
						<input type="range" id="slider" name="rang" 
						min ="0" max="7000" value ="3500"
						style="border:0px; width:80%;"
						onchange="showVal(this.value)">
						<h4>Check your favorite categories:</h4>
						<input type="submit" name="reshow" value="Show Offers">
					</form>
				</div><!-- offersOptions -->
			</div><!-- warp -->
		</div>
		<footer id="homeFooter">
			<div class="warp" id="foot">
				<div id="homeCopyrightState">
					<p>
						Copyright &copy; 2015, Designed and Developed by Team.
					</p>
				</div><!-- copyrightState -->
			</div><!-- foot --><!-- warp -->
		</footer>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script src="http://maps.googleapis.com/maps/api/js"></script>
		<script src="js/offers_script.js"></script>
	</body>
</html>