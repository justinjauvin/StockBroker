<main>
	<form action="onlinebroker.php" method="post">

	<h1><?php echo $stock['name']?></h1>
	
	<ol>
			
			<h2><a href="onlinebroker.php?action=viewstock&id=<?php echo $stock['id']?>"><?php echo $stock['ticker']?></a> </h2>
			<p><?php echo $stock['price']?></p>
			<p><?php echo $stock['pricechange']."$"?></p>
			<p><?php echo $stock['percentagechange']."%"?></p>
									
			
			<input type="hidden" id="stockid" name="stockid" value="<?php echo $stock['id']?>">
			
			<?php if($loggedin){ ?>
			<p><a href="onlinebroker.php?action=buy&id=<?php echo $stock['id']?>">Buy</a>
			<?php } ?>
					
	
	</ol>
	
	
	</main>
</body>
</html>