<?php
	ob_start();
	session_start();
	require_once('helper.php');
	if(!isset($_SESSION['user'])){
		header("refresh:0; url=home.php");
	}
	$userid = $_GET['sh'];
	$ShDets = getShop($userid);
	//make else if no image put default
	$img_url = "uploads/advertisor/default.jpg";
	if($ShDets['ShopImg']!=""){
		$img_url = "uploads/advertisor/".$ShDets['ShopImg'];
	}
	
	//echo $img_url;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
					"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>5od Fekra - Profile</title>
		<script>document.documentElement.className='js';</script>
		<meta charset="utf-8"/>
		<link href="css/style.css" rel="stylesheet"/>
	</head>
	<body>
		<div id="profile" class="warp">
			<div id="head-Side">
				<ul id="nav" class="for-profile">
					<li><a href="home.php">Home</a></li>
					<li><a href="show_offers.php">Offers</a></li>
					<li><a href="new_advertise.php">Advertise</a></li>
					<?php
						if(isset($_SESSION['user'])){
							$d = $_SESSION['user'];
							echo '<li class="selected"><a href="profile.php?sh='.$d.'">Profile</a></li>';
						}
					?>
				</ul>
				<div id="loginForm">
					<?php display_user(); ?>
				</div><!-- loginForm -->
			</div>
			<div id="proTop">
				<img src="<?php echo $img_url;?>">
				<?php echo '<h2><a href="profile.php?sh='.$userid.'">'.$ShDets['ShopName'].'</a></h2>'; ?>
			</div>
			<div id="proTabs" class="warp">
				<ul id="tabHeadings">
					<li class="selected">
						<a href="#info">Info</a>
					</li>
					<li>
						<a href="#myOffers">My Offers</a>
					</li>
				</ul>
				<section class="tabs">
					<div id="info">
						<ul>
							<li>
								<span class="section">Category:</span>
								<p><?php echo display_field($ShDets['ShopType']); ?></p>
							</li>
							<li>
								<span class="section">Start Date:</span>
								<p><?php echo display_field($ShDets['ShopDate']); ?></p>
							</li>
							<li>
								<span class="section">Mobile:</span>
								<p><?php echo display_field($ShDets['ShopMobile']); ?></p>
							</li>
							<li>
								<span class="section">E-Mail:</span>
								<p><?php echo display_field($ShDets['ShopEmail']); ?></p>
							</li>
							<li>
								<span class="section">Address:</span>
								<p><?php echo display_field($ShDets['ShopAddress']); ?></p>
							</li>
							<li>
								<span class="section">Location:</span>
								<p><div id="googleMap" style="width:60%;height:200px;"></div></p>
							</li>
						</ul>
					</div>
					<div id="myOffers">
						<a id="profile-new-offer" href="new_advertise.php">Add New Advertise</a>
						<ul>
							<?php
								display_offers_of($userid);
							?>
							<!--
							<li>
								<a href="#">
									<img src="#"/>
									<h3></h3>
									<p></p>
								</a>
							</li>
							-->
						</ul>
					</div>
				</section>
			</div>
		</div>
		<div id="dom-target1" style="display: none;">
			<?php echo $ShDets['ShopLat']; ?>
		</div>
		<div id="dom-target2" style="display: none;">
			<?php echo $ShDets['ShopLon']; ?>
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
		<script src="js/script.js"></script>
	</body>
</html>