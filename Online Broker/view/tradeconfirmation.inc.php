<main>
	<h1><?php echo $tradeType?> confirmation</h1>
	<form action="onlinebroker.php" method="post">
	<ol>
			<p>Account Balance: <?php echo $account['balance']?>$</p>
			
			<h2><a href="blog.php?action=viewstock&id=<?php echo $stock['id']?>"><?php echo $stock['ticker']?></a> </h2>
			
			<p><?php echo $stock['price']?></p>
			<input type="hidden" id="priceBought" name="priceBought" value="<?php echo $stock['price']?>">
			
			<p><?php echo $stock['percentagechange']."%"?></p>
			
			<p><?php echo $quantity?> shares of <?php echo $stock['ticker']?> @ <?php echo $stock['price']?> USD</p>
			<input type="hidden" id="quantity" name="quantity" value="<?php echo $quantity?>">
			
			<p><p>Total Market Price:<br><?php echo $shareCost?>$</p>
			<p><?php echo $commissionMessage?></p><br>
			<p>Total Cost of Trade:<br> <?php echo $totalCost?>$</p><br>
			<p>Account Balance After Trade: <?php echo $balanceAfter?>$</p>
			<input type="hidden" id="balanceAfter" name="balanceAfter" value="<?php echo $balanceAfter?>">
			<input type="hidden" id="stockid" name="stockid" value="<?php echo $stock['id']?>">
			
			<input type="hidden" id="tradeType" name="tradeType" value="<?php echo $tradeType?>">
			
			<input type="submit" name = "action" value="Confirm">
			
			
			
			
			
			
			
			
			
	
	</ol>
	
	
	</main>
</body>
</html>