<?php
session_start();

if(isset($_SESSION['loggedin'])){
	$loggedin = $_SESSION['loggedin'];
	$accountid = $_SESSION['accountid'];
	$userDisplay = $_SESSION['userDisplay'];
	$username = $_SESSION['username'];
	$email = $_SESSION['email'];
	$balance = $_SESSION['balance'];
	$admin = $_SESSION['admin'];
}
else{
	$loggedin = FALSE;
}

include("model/functions.inc.php");

$action = filter_input(INPUT_POST, 'action');
$error="";

if($action == NULL){
	$action = filter_input(INPUT_GET, 'action');
}


//This if statement is when a user clicks "Search" with their input in the field to search the database
//for a stock. You can search by name or ticker symbol. This statement is before the loggedin check
//because all users have access to the search function. There is also empty field checking and 
//an error message is shown if the search yields no results.
//(example of a ticker: jnj is the ticker symbol for Johnson & Johnson)
if($action == "Search"){
	$search = filter_input(INPUT_POST, 'search');
	
	if(!empty($search)){
		//This function sends the user's search input to the database and 
		//returns the stock by accessing the stock table in the ticker column for a match.
		$stock = searchStockViaTicker($search);
		
		if($stock != NULL){
			//The user is rederected to this view if the search result yields a stock by matching
			//a ticker sybol and shows the stock view and header.
			
			//This view displays a single stock.
			include("view/header.inc.php");
			include("view/viewstock.inc.php");
		}
		
		elseif($stock == Null){
			//The user is redirected here if the search does not match a ticker symbol
			//to check if their seach matches a name of a stock.
			
			//This function sends the user's search input to the database and
			//returns the stock by accessing the stock table in the name column for a match.
			$stock = searchStockViaName($search);
			
			if($stock != NULL){
				//The user is rederected to this view if the search result yields a stock by matching
				//a name and shows the stock view and header.
				include("view/header.inc.php");
				include("view/viewstock.inc.php");
			}
			
			else{
				//The user is redirected here if the search yields no results 
				//(does not match a ticker symbol or name).
				$error = "Unfortunately this stock does not seem to be in our database.";
				//This function returns all stocks in the database
				$stocks = getStocks();
				
				//This function sends the accountid variable set by the session and returns the account.
				if($loggedin)
					$account = getAccount($accountid);
				
				//This view shows the header and displays the all the stocks with a foreach loop.
				include("view/header.inc.php");
				include("view/stocklist.inc.php");
			}
		}
	}
	
	else{
		//The user is redirected here if the search input field is empty.	
		$error = "Please enter a ticker symbole or a stock name.";
		//This function returns all stocks in the database
		$stocks = getStocks();
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		
		//This view shows the header and displays the all the stocks with a foreach loop.
		include("view/header.inc.php");
		include("view/stocklist.inc.php");
	}
}

elseif($action == "viewstock"){
		//The user is redirected here when they search a stock or click on a stock to view it.
		$id = filter_input(INPUT_GET, 'id');
		
		//This function sends the stockid and returns stocks that matches the id in the database
		$stock = getStock($id);
		
		//This view is to display a single stock and the header.
		include("view/header.inc.php");
		include("view/viewstock.inc.php");
}
	

//Actions only authenticated users can take.
if($loggedin){
	
	//Actions only authenticated users that are admins can take.
	if($admin == 1){
		//A new link appears when the account is an admin that brings the user to the stock submission form.
		if($action == "newStock"){
			
			//the add stock form view
			include("view/header.inc.php");
			include("view/addstockform.inc.php");
		}
		
		//The only new function an admin can take is to submit a new stock entry, there is also empty field checking.
		elseif($action == "Submit New Stock"){
			$name = filter_input(INPUT_POST, 'name');
			$ticker = filter_input(INPUT_POST, 'ticker');
			$price = filter_input(INPUT_POST, 'price');
			$dollar = filter_input(INPUT_POST, 'dollar');
			$percent = filter_input(INPUT_POST, 'percent');
		
			if(!empty($name) && !empty($ticker) && !empty($price) && !empty($dollar) && !empty($percent)){
				
				//This function sends the stock information gathered from the usrs input to the database.
				addStock($name, $ticker, $price, $dollar, $percent);
				
				//This function returns all stocks in the database.
				$stocks = getStocks();
				//This function sends the accountid variable set by the session and returns the account.
				$account = getAccount($accountid);
		
				//This view shows the header and displays the all the stocks with a foreach loop.
				include("view/header.inc.php");
				include("view/stocklist.inc.php");
			}
			
			else{
				$error = "All fields must be filled with the proper value!";
				//else not all field were filled so the addstockform is still displayed.
				include("view/header.inc.php");
				include("view/addstockform.inc.php");
			}
			
		}
	}
	
	if($action == NULL){
		//The user is redirected here if the action is null and the user is logged in.
		$error = "";
		$pagetitle = "Online Broker";
		//This function returns all stocks in the database.
		$stocks = getStocks();
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		
		//This view shows the header and displays the all the stocks with a foreach loop.
		include("view/header.inc.php");
		include("view/stocklist.inc.php");
	}
	
	elseif($action == "account"){
		//A logged in user is redirected here if the user clicks account link on the nav bar 
		
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		
		//This view shows the header and 
		include("view/header.inc.php");
		include("view/accountform.inc.php");

	}
	
	//user is directed here is when the watchlist link is clicked.
	elseif($action == "watchlist"){
		
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		
		//This function sends the accountid and returns that accounts watchlist.
		$watchlist = getWatchlist($accountid);
		
		//The view for the watchlist
		include("view/header.inc.php");
		include("view/watchlist.inc.php");
	}
	
	//user is redirected here is they click +Watchlist next to a stock
	elseif($action == "addWatchlist"){
		$id = filter_input(INPUT_GET, 'id');
		
		//This function sends the accountid and stockid first checks if the user has this stock in their watchlist
		if(checkIfInWatchlist($accountid, $id)){
			//This function sends the accountid and stockid and add that stock to the users watchlist.
			addWatchlist($accountid, $id);
			//The home page is reloaded.
			header("Location:onlinebroker.php");
		}
		else{
			//else the stock is already in the uses watchlist.
			$error = "That stock is already in your watchlist!";
			
			//This function returns all stocks in the database
			$stocks = getStocks();
			
			//This function sends the accountid variable set by the session and returns the account.
			$account = getAccount($accountid);
			
			include("view/header.inc.php");
			include("view/stocklist.inc.php");
		}
	}
	
	//if the remove link is clicked next to a stock in the users watchlist.
	elseif($action == "deleteFromWatchlist"){
		$id = filter_input(INPUT_GET, 'id');
		
		//This function sends the users accountid and the stockid to delete that entry in the database.
		deleteFromWatchlist($accountid, $id);
		
		//The home page with action = watchlist is reloaded.
		header("Location:onlinebroker.php?action=watchlist");
	}
	
	elseif($action == "addfunds"){
		//A user is redirected here when they click the add funds+ link when they are viewing their account.
		
		$transactionTitle = "Fund Account";
		$transactionMessage = "Enter the amount you would like to add to your account:";
		
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		
		//They are then redirected to the addfundform so they can input the amount and their card details.
		include("view/header.inc.php");
		include("view/addfundsform.inc.php");
	}
	
	elseif($action == "withdrawfunds"){
		//A user is redirected here when they click the withdraw funds link when they are viewing their account.
		
		$transactionTitle = "Withdraw From Account";
		$transactionMessage = "Enter the amount you would like to withdraw:";
		
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		
		//They are then redirected to the addfundform so they can input the amount and their card details.
		include("view/header.inc.php");
		include("view/addfundsform.inc.php");
	}
	
	elseif($action == "Complete Transaction"){	
		//The user is redirected here when they click the complete transaction to add or withdraw funds
		//depending on what the $transactionType is.
		$card = filter_input(INPUT_POST, 'card');
		$pin = filter_input(INPUT_POST, 'pin');
		$amount = filter_input(INPUT_POST, 'amount');
		$transactionType = filter_input(INPUT_POST, 'transactionType');
		
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		
		if(!empty($card) && !empty($pin) && !empty($amount)){		
			if($transactionType == "addfunds"){
				$newTotal = $account['balance'] + $amount;
			}
		
			else{
				$newTotal = $account['balance'] - $amount;
			}
			//This function sends they $newTotal and the $accountid and will update the users account balance 
			//with the $newTotal the total will increase or decrease depending if they withdraw or add funds.
			addFunds($newTotal, $accountid);
			//This view reloads the default onlinebroker.php account view to show the new balance.
			header("Location:onlinebroker.php?action=account");
		}		
	
		else{
			$error = "All fields must be complete!";
			$transactionTitle = "Error";
			$transactionMessage = "Amount:";
			include("view/header.inc.php");
			include("view/addfundsform.inc.php");
		}
	}
	
	elseif($action == "buy"){
		//The user is redirected here when they click the buy link associated with a particular stock.
		$id = filter_input(INPUT_GET, 'id');
		
		//This function sends the stockid and returns stocks that matches the id in the database
		$stock = getStock($id);
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		
		$ownershipMessage = "";

		//This view redirects you to the header and the trade form view which shows you information on the 
		//stock and allows the user to input a quantity of shares to be purchased or sold	
		include("view/header.inc.php");
		include("view/tradeform.inc.php");
	}
	
	elseif($action == "sell"){
		//The user is redirected here when they click the buy link associated with a particular stock in their portfolio.
		$id = filter_input(INPUT_GET, 'id');
		
		//This function sends the stockid and returns stocks that matches the id in the database.
		$stock = getStock($id);
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		//This function call sends the stockid and the accountid and returns the stockownership of an
		//individual account and stock, this is to check how many shares the individual owns.
		$stockOwnership = getStockOwnership($id, $accountid);
		
		$ownershipMessage = "You own ".$stockOwnership['quantity']." shares";
		
		//This view redirects you to the header and the trade form view which shows you information on the 
		//stock and allows the user to input a quantity of shares to be purchased or sold	
		include("view/header.inc.php");
		include("view/tradeform.inc.php");
	}
	
	elseif($action == "Process Trade"){
		//The user is redirected here after they click buy shares as a confirmation screen.
		//It shows general information on the stock as well as the change to the users account balance. There is also empty field checking.
		$stockid = filter_input(INPUT_POST, 'stockid');
		$quantity = filter_input(INPUT_POST, 'quantity');
		$tradeType = filter_input(INPUT_POST, 'tradeType');
		
		//This function sends the stockid and returns stocks that matches the id in the database.
		$stock = getStock($stockid);
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		if($quantity != NULL){
			
			//This if/else statement checks if the trade type is buy or sell and calculates the users account balance accordingly.
			if($tradeType == "buy"){
				$commissionMessage = "+5$ Commission";
				
				$shareCost = $stock['price'] * $quantity;
				$totalCost = $shareCost + 5;
				$balanceAfter = $account['balance'] - $totalCost;
			}
		
			else{
				$commissionMessage="-5$ Commission";
			
				$shareCost = $stock['price'] * $quantity;
				$totalCost = $shareCost - 5;
				$balanceAfter = $account['balance'] + $totalCost;
			}
			//This view shows the header and trade confirmation window.
			include("view/header.inc.php");
			include("view/tradeconfirmation.inc.php");
		}
		
		else{
			$error = "You need to enter a valid quantity.";
			$ownershipMessage = "";
			//This view resubmits the trade form if there is an error.
			include("view/header.inc.php");
			include("view/tradeform.inc.php");
		}
	}
	
	elseif($action == "Confirm"){
		//After the user clicks confirm on the trade confrimation window, their shareOwnership quantity and account balance is updated.
		$balanceAfter = filter_input(INPUT_POST, 'balanceAfter');
		$stockid = filter_input(INPUT_POST, 'stockid');
		$quantity = filter_input(INPUT_POST, 'quantity');
		$priceBought = filter_input(INPUT_POST, 'priceBought');
		$tradeType = filter_input(INPUT_POST, 'tradeType');
		
		//The function in this if statement checks if the user owns this stock before purchasing the new quantity.
		//If the user has no database entry for ownership on a particular stock the following else statement will create one.
		//If the user has a database entry for ownership on a particular stock the following if statement will update the quantity the user owns.
		
		if($tradeType == "buy"){
			if(checkIfOwned($stockid, $accountid)){
			
				//This function call sends the stockid and the accountid and returns the stockownership of an
				//individual account and stock, this is to check how many shares the individual owns.
				$stockOwnership = getStockOwnership($stockid, $accountid);
			
				$newQuantity = $quantity + $stockOwnership['quantity'];
			
				//This function call sends the stockid, accountid, and newQuantity to update the newQuantity column.
				updateShareQuantity($newQuantity, $stockid, $accountid);
			}
		
			else{
				//This function call sends the accountid, stockid, quantity, and priceBought to create a new entry in the stockOwnership table
				buyShares($accountid, $stockid, $quantity, $priceBought);
			}
		
			//This function call sends the balanceAfter and the accountid and updates the users balance after a transaction.
			processPayment($balanceAfter, $accountid);
			
			//The website is reloaded to the portfolio link so that the updated numbers show.
			header("Location:onlinebroker.php?action=portfolio");	
		}
		
		else{
			//This function call sends the stockid and the accountid and returns the stockownership of an
			//individual account and stock, this is to check how many shares the individual owns.
			$stockOwnership = getStockOwnership($stockid, $accountid);
		
			$newQuantity = $stockOwnership['quantity'] - $quantity;
		
			//This function call sends the stockid, accountid, and newQuantity to update the newQuantity column.
			updateShareQuantity($newQuantity, $stockid, $accountid);
		
			//This function call sends the balanceAfter and the accountid and updates the users balance after a transaction.
			processPayment($balanceAfter, $accountid);
		
			//The website is reloaded to the portfolio link so that the updated numbers show.
			header("Location:onlinebroker.php?action=portfolio");
		}
	}
	//When the user clicks the portfolio link
	elseif($action == "portfolio"){
		//This function sends the accountid variable set by the session and returns the account.
		$account = getAccount($accountid);
		//This function call sends the account id returns all the stockOwnership of an individual.
		$allStockOwnership = getAllStockOwnership($accountid);
		
		//This view shows the header and the users portfolio list (lists all stocks owned by user)
		include("view/header.inc.php");
		include("view/portfolio.inc.php");
	}
	
	//When the user clicks the logout link, this also destroys the session.
	elseif($action == "logout"){
		
		$_SESSION = array();
		session_destroy();
		header("Location:onlinebroker.php");	
	}
}

//actions only non-authenticated users can take.
else{
	//if user clicks createaccount link
	if ($action == "createaccount"){
		$error = "";
		$username = "";
		$email = "";
		$fname = "";
		$lname = "";
		
		//This view will show the create account form.
		include("view/header.inc.php"); 
		include("view/createaccountform.inc.php");
	}
	
	//if the user clicks the submit registration button, there is empty field checking
	elseif ($action == "Submit Registration"){	
		$username = filter_input(INPUT_POST, 'username');
		$password = filter_input(INPUT_POST, 'password');
		$email = filter_input(INPUT_POST, 'email');
		$fname = filter_input(INPUT_POST, 'fname');
		$lname = filter_input(INPUT_POST, 'lname');
		
		if(!empty($username) && !empty($password) && !empty($email) && !empty($fname) && !empty($lname)){
			
			//The function inside the if statement sends the username and checks if the username is taken.
			if(checkUsername($username)){
				createaccount($username, $password, $email, $fname, $lname);
				//This view reloads the home page.
				header("location:onlinebroker.php");
			}
			else{
				$error = "Username is not available. Please choose another.";
				//This view shows the create account form again with an error because the username was taken.
				include("view/header.inc.php");
				include("view/createaccountform.inc.php");
			}
		}
		
		else{
			$error = "All fields must be complete!";
			
			
			//This view shows the create account form again with an error because some fields were left empty.
			include("view/header.inc.php");
			include("view/createaccountform.inc.php");
		}
	}

	//If the user clicks the login link.
	elseif($action == "loginform"){
		$pagetitle="Login Form";
		$username = "";
		$error="";
		
		//This view shows the login form
		include("view/header.inc.php");
		include("view/loginform.inc.php");		
	}
	
	//If the user clicks the login button on the login form.
	elseif ($action == "login"){
		$error = "";
		$username = "";
		
		$username = filter_input(INPUT_POST, 'username');
		$password = filter_input(INPUT_POST, 'password');
		
		//This function call sends the username and password and processes the login by checking
		//the username and password against the ones in the database 
		$account = processLogin($username, $password);
		
		if($account != NULL){	
			$_SESSION['loggedin'] = True;
			$_SESSION['username'] = $account['username'];
			$_SESSION['accountid']= $account['id'];
			$_SESSION['email'] = $account['email'];
			$_SESSION['userDisplay'] = $account['fname']." ".$account['lname'];
			$_SESSION['balance'] = $account['balance'];
			$_SESSION['admin'] = $account['admin'];
			header("Location:onlinebroker.php");
		}
		
		else{
			$error = "<p>Incorrect login, try again</p>";
					
			$pagetitle="Login Form";
			include("view/header.inc.php");
			include("view/loginform.inc.php");	
		}
	}
	//This is the default view for a non-authenticated user.
	elseif($action == NULL){
		$pagetitle = "Blog Home";
		
		//This function returns all stocks in the database.
		$stocks = getStocks();
		
		//This view displays all stocks in list format and is the default view/ 
		include("view/header.inc.php");
		include("view/stocklist.inc.php");
	}
}
?>














