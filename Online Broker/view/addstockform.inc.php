<main>
        <h1>Stock Submission Form</h1>
		<form action="onlinebroker.php" method="post">

				<p><?php echo $error ?></p>
                <label>Name:</label>
                <input type="text" name="name" value=""><br>

                <label>Ticker:</label>
                <input type="text" name="ticker"><br>
				
				<label>Price:</label>
                <input type="text" name="price" value=""><br>
				
				<label>Price Change Dollar:</label>
                <input type="text" name="dollar" value="">$<br>
				
				<label>Price Change Percentage:</label>
                <input type="text" name="percent" value="">%<br>
				          
                <input type="submit" name = "action" value="Submit New Stock"><br>
            

        </form>
		
    </main>
	</body>
	</html>