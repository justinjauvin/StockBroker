<main>
        <h1>Login Form</h1>
		<form action="onlinebroker.php" method="post">

			<p><?php echo $error ?></p>
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo $username ?>"><br>

                <label>Password:</label>
                <input type="text" name="password"><br>
				          
                <input type="submit" name = "action" value="login"><br>
            
        </form>
		
    </main>
	</body>
	</html>