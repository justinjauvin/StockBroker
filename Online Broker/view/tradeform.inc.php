<main>
	<h1>Trade | <?php echo $action?></h1>
	<form action="onlinebroker.php" method="post">
	<ol>
			<p>Account Balance: <?php echo $account['balance']?>$</p>
			
			<h2><a href="blog.php?action=viewstock&id=<?php echo $stock['id']?>"><?php echo $stock['ticker']?></a> </h2>
			<p>Current Price: <?php echo $stock['price']?>$</p>
			<p><?php echo $stock['percentagechange']."%"?></p>
			<p><?php echo $ownershipMessage ?></p>
			<p><label for="title">Quanity:</label> 
			<input type="text" name="quantity" id="quantity" value="" > @ <?php echo $stock['price']?></p>
			<p><?php echo $error ?></p><br>
			
			
			<input type="hidden" id="stockid" name="stockid" value="<?php echo $stock['id']?>">
			
			<input type="hidden" id="tradeType" name="tradeType" value="<?php echo $action?>">
			
			
			<input type="submit" name = "action" value="Process Trade">
			
			
			
			
			
	
	</ol>
	
	
	</main>
</body>
</html>
