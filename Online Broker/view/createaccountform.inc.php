<main>
        <h1>Account Registration</h1>
		<form action="onlinebroker.php" method="post">

				<p><?php echo $error ?></p>
                <label>Username:</label>
                <input type="text" name="username" value=""><br>

                <label>Password:</label>
                <input type="text" name="password"><br>
				
				<label>Email:</label>
                <input type="text" name="email" value=""><br>
				
				<label>First Name:</label>
                <input type="text" name="fname" value=""><br>
				
				<label>Last Name:</label>
                <input type="text" name="lname" value=""><br>
				          
                <input type="submit" name = "action" value="Submit Registration"><br>
            

        </form>
		
    </main>
	</body>
	</html>