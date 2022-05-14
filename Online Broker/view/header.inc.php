<!DOCTYPE html>
<html>
<head>	
	<title>Online Broker</title>
	<link rel="stylesheet" href="view/styles/onlinebroker.css">
</head>
<body>
	<header>
		<?php if($loggedin) 
		{ ?>
			<p><a href="onlinebroker.php">Home</a> | <a href="onlinebroker.php?action=account">Account</a> | <a href="onlinebroker.php?action=portfolio">Portfolio</a> | <a href="onlinebroker.php?action=watchlist">Watchlist</a> | <a href="onlinebroker.php?action=logout">Logout</a><?php if($admin == 1) { ?> | <a href="onlinebroker.php?action=newStock">Add New Stock Entry</a><?php } ?></p>
		<?php 
		} 
		else 
		{ ?>
			<p><a href="onlinebroker.php">Home</a> | <a href="onlinebroker.php?action=createaccount">Create Account</a> | <a href="onlinebroker.php?action=loginform">Login</a></p>
		<?php 
		} 
		?>
		<form action="onlinebroker.php" method="post">
		<label for="title">Enter a Stock name or ticker in the search field:</label><br>
		<input type="text" name="search" id="search" value="" > <input type="submit" name = "action" value="Search"><br>
		</form>
		<br>
	</header>