<?php

	$dsn = 'mysql:host=localhost;dbname=online_broker';
	$dbuser = 'root';
	$dbpass = '';

	$db = new PDO($dsn, $dbuser, $dbpass);

function createaccount($username, $password, $email, $fname, $lname){
	
	global $db;
				
	$query = 'INSERT INTO accounts (username, password, email, fname, lname)
			  VALUES (:username, :password, :email, :fname, :lname )';
				  
		
	$statement = $db->prepare($query);
		
		
	$statement->bindValue(':username', $username);
	$statement->bindValue(':password', $password);
	$statement->bindValue(':email', $email);
	$statement->bindValue(':fname', $fname);
	$statement->bindValue(':lname', $lname);
	
	$statement->execute();
		
		
	$statement->closeCursor();
}

function checkUsername($username){
		global $db;
		$queryUser = 'SELECT id FROM accounts
					  WHERE username = :username' ;
		$statement = $db->prepare($queryUser);
		$statement->bindValue(':username', $username);
		
		$statement->execute();
		$userAccount = $statement->fetch();
		$statement->closeCursor();
		
		if($userAccount == NULL)
			return true;  
		else
			return false;  
}

function processLogin($username, $password){
		
		global $db;
		$queryUser = 'SELECT * FROM accounts
					  WHERE username = :username' ;
					  
		$statement = $db->prepare($queryUser);
		$statement->bindValue(':username', $username);
			
		$statement->execute();
		$userAccount = $statement->fetch();
		$statement->closeCursor();
			
		if($userAccount != NULL){
			if($password != $userAccount['password'])
				$userAccount = NULL;
		}
			return $userAccount;
			
}

function getStock($id){
		global $db;
		
		$query = 'SELECT * FROM stocks WHERE id = :id';
		
		$statement = $db->prepare($query);
		
		
		$statement->bindValue(':id', $id);
		$statement->execute();
		
		
		$stock = $statement->fetch();
		$statement->closeCursor();	
		
		return $stock;
}

function searchStockViaTicker($search){
	global $db;
		
		$query = 'SELECT * FROM stocks WHERE ticker = :search';
		
		$statement = $db->prepare($query);
		
		
		$statement->bindValue(':search', $search);
		$statement->execute();
		
		
		$stock = $statement->fetch();
		$statement->closeCursor();	
		
		return $stock;
}

function searchStockViaName($search){
	global $db;
		
		$query = 'SELECT * FROM stocks WHERE name = :search';
		
		$statement = $db->prepare($query);
		
		
		$statement->bindValue(':search', $search);
		$statement->execute();
		
		
		$stock = $statement->fetch();
		$statement->closeCursor();	
		
		return $stock;	
}

function getStocks(){
		
		global $db;
		
		$query = 'SELECT * FROM stocks';
		$statement = $db->prepare($query);
		
		$statement->execute();
		
		$stocks = $statement->fetchAll();
		$statement->closeCursor();	
		
		return $stocks;
}

function getAccount($accountid){
		global $db;
		
		$query = 'SELECT * FROM accounts WHERE id = :accountid';
		
		$statement = $db->prepare($query);
		
	
		$statement->bindValue(':accountid', $accountid);
		$statement->execute();
	
		$account = $statement->fetch();
		$statement->closeCursor();	
		
		return $account;
		
	}

function addFunds($newTotal, $accountid){
	global $db;
		
	$query = 'UPDATE accounts SET balance = :newTotal WHERE id = :accountid';
	
	$statement = $db->prepare($query);
		
	
	$statement->bindValue(':newTotal', $newTotal);
	$statement->bindValue(':accountid', $accountid);
	
	$statement->execute();
	
	$statement->closeCursor();	
}

function processPayment($balanceAfter, $accountid){
	global $db;
		
	$query = 'UPDATE accounts SET balance = :balanceAfter WHERE id = :accountid';
	
	$statement = $db->prepare($query);
		
	
	$statement->bindValue(':balanceAfter', $balanceAfter);
	$statement->bindValue(':accountid', $accountid);
	
	$statement->execute();
	
	$statement->closeCursor();
}

function buyShares($accountid, $stockid, $quantity, $priceBought){
	
	global $db;
		
	$query = 'INSERT INTO stockownership (accountid, stockid, quantity, priceBought)
			VALUES (:accountid, :stockid, :quantity, :priceBought)';
				  
	$statement = $db->prepare($query);
		
	$statement->bindValue(':accountid', $accountid);
	$statement->bindValue(':stockid', $stockid);
	$statement->bindValue(':quantity', $quantity);
	$statement->bindValue(':priceBought', $priceBought);
		
	$statement->execute();
		
	$statement->closeCursor();
}

function checkIfOwned($stockid, $accountid){
	global $db;
	$query = 'SELECT * FROM stockownership
				  WHERE accountid = :accountid AND stockid = :stockid' ;
					  
	$statement = $db->prepare($query);
		
	$statement->bindValue(':accountid', $accountid);
	$statement->bindValue(':stockid', $stockid);
		
	$statement->execute();
		
	$stockOwned = $statement->fetch();
		
	$statement->closeCursor();
		
	if($stockOwned == NULL)
		return false;
	else
		return true;
	}

function getStockOwnership($stockid, $accountid){
	global $db;
	$query = 'SELECT * FROM stockownership
				WHERE accountid = :accountid AND stockid = :stockid';
					  
	$statement = $db->prepare($query);
		
	$statement->bindValue(':accountid', $accountid);
	$statement->bindValue(':stockid', $stockid);
		
	$statement->execute();
	$stockOwnership = $statement->fetch();
	$statement->closeCursor();
	
	return $stockOwnership;
}

function getAllStockOwnership($accountid){
	global $db;
	$query = 'SELECT * FROM stockownership
					  WHERE accountid = :accountid';
					  
	$statement = $db->prepare($query);
		
	$statement->bindValue(':accountid', $accountid);
		
	$statement->execute();
	$allStockOwnership = $statement->fetchall();
	$statement->closeCursor();
	
	return $allStockOwnership;
}

function updateShareQuantity($newQuantity, $stockid, $accountid){
	global $db;
		
	$query = 'UPDATE stockownership SET quantity = :newQuantity 
					WHERE accountid = :accountid AND stockid = :stockid' ;
	
	$statement = $db->prepare($query);
		
	
	$statement->bindValue(':newQuantity', $newQuantity);
	$statement->bindValue(':accountid', $accountid);
	$statement->bindValue(':stockid', $stockid);
	
	$statement->execute();
	
	$statement->closeCursor();
}

function checkIfInWatchlist($accountid, $id){
	global $db;
	$query = 'SELECT * FROM watchlist
				WHERE accountid = :accountid AND stockid = :id';
	$statement = $db->prepare($query);
	
	$statement->bindValue(':accountid', $accountid);
	$statement->bindValue(':id', $id);
		
	$statement->execute();
	$stock = $statement->fetch();
	$statement->closeCursor();
		
	if($stock == NULL)
		return true;  
	else
		return false;
}

function addWatchlist($accountid, $id){
	global $db;
		
		
	$query = 'INSERT INTO watchlist (accountid, stockid)
			  VALUES (:accountid, :id)';
				  
	$statement = $db->prepare($query);
		
		
	$statement->bindValue(':accountid', $accountid);
	$statement->bindValue(':id', $id);
	
	
	$statement->execute();
		
		
	$statement->closeCursor();
}

function getWatchlist($accountid){
	global $db;
	$query = 'SELECT * FROM watchlist
					  WHERE accountid = :accountid';
					  
	$statement = $db->prepare($query);
		
	$statement->bindValue(':accountid', $accountid);
		
	$statement->execute();
	$watchlist = $statement->fetchall();
	$statement->closeCursor();
	
	return $watchlist;
}

function deleteFromWatchlist($accountid, $id){
	global $db;
		
	$query = 'DELETE FROM watchlist WHERE accountid = :accountid AND stockid = :id';
		
	$statement = $db->prepare($query);
	
	$statement->bindValue(':accountid', $accountid);
	$statement->bindValue(':id', $id);
	
	$statement->execute();
		
	$statement->closeCursor();
}

function addStock($name, $ticker, $price, $dollar, $percent){
	global $db;
		
		
	$query = 'INSERT INTO stocks (name, ticker, price, pricechange, percentagechange)
			  VALUES (:name, :ticker, :price, :dollar, :percent)';
				  
		
	$statement = $db->prepare($query);
		
		
	$statement->bindValue(':name', $name);
	$statement->bindValue(':ticker', $ticker);
	$statement->bindValue(':price', $price);
	$statement->bindValue(':dollar', $dollar);
	$statement->bindValue(':percent', $percent);
	
	$statement->execute();
		
		
	$statement->closeCursor();
}

?>



















