<main>
	<h1>Your Portfolio</h1>
	<form action="onlinebroker.php" method="post">
	
	<p>Account Balance: <?php echo $account['balance']?>$</p>
			
	<ol>
	
	<?php
		foreach($allStockOwnership as $stockOwnership):
	?>		
			<li>
			<input type="hidden" id="stock" name="stock" value="<?php $stock = getStock($stockOwnership['stockid']);?>">
			<h2><a href="onlinebroker.php?action=viewstock&id=<?php echo $stock['id']?>"><?php echo $stock['ticker']?></a> </h2>
			<p><?php echo $stockOwnership['quantity']?> shares owned</p>
			<p><?php echo $stock['price']?>$</p>
			<p><?php echo $stock['percentagechange']."%"?></p>
			
			<p><a href="onlinebroker.php?action=sell&id=<?php echo $stock['id']?>">Sell</a>
			
			</li>
			
	<?php
		endforeach;
	?>
	</ol>
			
			
			
			
			
			
			
	
	</ol>
	
	
	</main>
</body>
</html>