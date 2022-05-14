<main>
	<h1><?php echo $transactionTitle ?></h1>
	<p><?php echo $error ?></p><br>
	<form action="onlinebroker.php" method="post">
	<p>Name: <?php echo $userDisplay ?></p>
	<p>Balance: <?php echo $account['balance'] ?></p>
	
	<label for="title">Credit Card Number:</label><br>
	<input type="text" name="card" id="card" value="" ><br>
	<label for="title">Pin:</label><br>
	<input type="text" name="pin" id="pin" value="" ><br><br>
	
	<input type="hidden" id="transactionType" name="transactionType" value="<?php echo $action?>">
	
	<label for="amount"><?php echo $transactionMessage ?></label><br>
	<input type="text" name="amount" id="amount" value="" >$<br><br>
	<input type="submit" name = "action" value="Complete Transaction">

	</main>
</body>
</html>