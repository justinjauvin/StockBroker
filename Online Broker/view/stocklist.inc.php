	<main>
	<form action="onlinebroker.php" method="post">
	<br><?php echo $error?>
	
	<h1>Market Movers</h1>

	<?php
		if($loggedin){
	?>	
			<p>Account Balance: <?php echo $account['balance']?>$</p>
	<?php
		}
	?>	
	<ol>
	
	<?php
		foreach($stocks as $stock):
	?>		
			<li><h2><a href="onlinebroker.php?action=viewstock&id=<?php echo $stock['id']?>"><?php echo $stock['ticker']?></a> </h2>
			<p><?php echo $stock['price']?></p>
			<p><?php echo $stock['percentagechange']."%"?></p>
			<p><?php echo $stock['pricechange']."$"?></p>
			<?php if($loggedin){ ?>
			<p><a href="onlinebroker.php?action=buy&id=<?php echo $stock['id']?>">Buy</a> | <a href="onlinebroker.php?action=addWatchlist&id=<?php echo $stock['id']?>">+Watchlist</</p>
			<?php } ?>
			
			
			</li>
			
	<?php
		endforeach;
	?>
	</ol>
	
	
	</main>
</body>
</html>




