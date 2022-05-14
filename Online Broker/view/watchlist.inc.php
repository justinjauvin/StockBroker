<main>
	<h1>Watchlist</h1>
	<form action="onlinebroker.php" method="post">
	
	<p>Account Balance: <?php echo $account['balance']?>$</p>
			
	<ol>
	
	<?php
		foreach($watchlist as $watchlistStock):
	?>		
			<li>
			<input type="hidden" id="stock" name="stock" value="<?php $stock = getStock($watchlistStock['stockid']);?>">
			<h2><a href="onlinebroker.php?action=viewstock&id=<?php echo $stock['id']?>"><?php echo $stock['ticker']?></a> </h2>
			<p><?php echo $stock['price']?>$</p>
			<p><?php echo $stock['percentagechange']."%"?></p>
			<p><?php echo $stock['pricechange']."$"?></p>
			
			<p><a href="onlinebroker.php?action=buy&id=<?php echo $stock['id']?>">Buy</a>  | <a href="onlinebroker.php?action=deleteFromWatchlist&id=<?php echo $stock['id']?>">Remove</p>
			
			</li>
			
	<?php
		endforeach;
	?>
	</ol>
			
			
			
			
			
			
			
	

	
	
	</main>
</body>
</html>