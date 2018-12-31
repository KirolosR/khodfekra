<?php
	ob_start();
	session_start();
	require_once('helper.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
					"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>5od Fekra</title>
		<meta charset="utf-8"/>
		<link href="css/style.css" rel="stylesheet"/>
	</head>
	<body id="main-page">
		<div id="header-home">
			<div class="warp">
				<div id="logo-home">
					<h1><a href="home.php">5od Fekra</a></h1>
				</div><!-- logo-home -->
				<div id="head-Side">
					<ul id="nav">
						<li class="selected"><a href="home.php">Home</a></li>
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
		<div id="main-home">
			<div id = "main-home-container">
				<article>
					<h2>Advertise With Us</h2>
					<p>
						<span>We make advertising for offers more easy, reachable and fancy!<span>
						Our agency is the best reliable offers agency, We know our customer needs
						and try to reach the top experience our customer can take.
					</p>
					<a href="new_advertise.php">Advertise Now!</a>
				</article>
				<article>
					<h2>Explore New Offers Near You</h2>
					<p>
						<span>Find best offers near you!</span>
						With us you can find the best offers to enjoy your shopping tour
						with best prices. NO NEED TO CREATE ACCOUNT!
					</p>
					<a href="show_offers.php">View Offers</a>
				</article>
			</div><!-- main-home-container -->
			<!--
			<div id="sideBar-home">
				<h3>Top Offers</h3>
				<ul id="topOffers">
				<?php //display_top_offers(); ?>
				--------
					<li>
						<a href="#">
							<img src="http://www.splendido.hr/wp-content/uploads/2010/11/special-offer-baska-krk.gif" alt="">
							<h4>this is title for offer</h4>
							<p>this is description for offer</p>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="" alt="">
							<h4></h4>
							<p></p>
						</a>
					</li>
				--------
				</ul>
			</div><!-- sideBar-home --
			-->
		</div><!-- warp -->	
		<footer id="homeFooter">
			<div class="warp" id="foot">
				<div id="homeCopyrightState">
					<p>
						Copyright &copy; 2015, Designed and Developed by Team.
					</p>
				</div><!-- copyrightState -->
			</div><!-- foot --><!-- warp -->
		</footer>
	</body>
</html>