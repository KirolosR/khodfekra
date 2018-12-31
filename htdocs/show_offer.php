<?php
	ob_start();
	session_start();
	require_once('helper.php');
	$theOffer = $_GET['of'];
	//$shopLocation = 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
					"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>5od Fekra - Offer</title>
		<script>document.documentElement.className='js';</script>
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
						<li><a href="show_offers.php">Offers</a></li>
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
			<div class="warp"  id="main-offer">
				<article>
					<?php display_big_offer($theOffer); ?>
					<!--
					<img src="#">
					<h2>This is Offer Title</h2>
					<span id="sale">Sale 50%</span>
					<ul id="details">
						<li>
							<span class="section">Category:</span>
							<p>the cat belongs to</p>
						</li>
						<li>
							<span class="section">Start Date:</span>
							<p>2009-2-5</p>
						</li>
						<li>
							<span class="section">End Date:</span>
							<p>2009-2-5</p>
						</li>
						<li>
							<span class="section">Description:</span>
							<p>
								lorem text kmad asdj ljnad askjnsfd  vsprintf
								ldcndf fsdn s cansdfnan fnlakdlasx fnlanlax  cnl
								alndlalxa kmad asdj ljnad askjnsfd  vsprintf
								ldcndf fsdn s cansdfnan fnlakdlasx fnlanlax  cnl
								alndlalxakmad asdj ljnad askjnsfd  vsprintf
								ldcndf fsdn s cansdfnan fnlakdlasx fnlanlax  cnl
								alndlalxakmad asdj ljnad askjnsfd  vsprintf
								ldcndf fsdn s cansdfnan fnlakdlasx fnlanlax  cnl
								alndlalxa
							</p>
						</li>
						<li>
							<span class="section">Address:</span>
							<p>Egypt, akjsd, kmasdksdcsd1 15313</p>
						</li>
						<li>
							<span class="section">Location:</span>
							<p><div id="googleMap" style="width:500px;height:200px;"></div></p>
						</li>
					</ul>
					<!-- space for map to indecate location -->
				</article>
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
		<script src="js/script.js"></script>
	</body>
</html>