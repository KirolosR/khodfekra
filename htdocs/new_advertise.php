<?php
	ob_start();
	session_start();
	require_once('helper.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
					"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>5od Fekra - Advertise</title>
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
						<li class="selected"><a href="new_advertise.php">Advertise</a></li>
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
			<div class="warp"  id="main-new-advertise">
				<?php
					if(check_log()){
						show_advertise_form();
					}else{
						show_signup_form();
					}
				?>
			</div><!-- warp -->	
		</div>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script src="http://maps.googleapis.com/maps/api/js"></script>
		<script src="js/script.js"></script>
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