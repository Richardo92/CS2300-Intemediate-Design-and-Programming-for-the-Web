<?php session_start(); ?>
<!DOCTYPE html>
<head>
	<title>Home</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<?php
		require_once 'includes/config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (mysqli_connect_errno($mysqli)) {
			echo "Failed to connect to Mysql ". mysqli_connect_error();
		}
	?>
</head>

<body>
	<?php
		include 'includes/representHeader.php';
		$post_username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
		$post_password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );

		if (isset($_POST['logout'])) {
			$olduser = $_SESSION['logged_user'];
			print("<p>Thanks for using our page, $olduser!</p>");
			print("<p>Return to our <a href='index.php'>login page</a></p>");
			unset($_SESSION['logged_user']);
		
		}
		else if ( isset($_SESSION['logged_user'] ) ) {
			$db_username = $_SESSION['logged_user'];
			print("<h2>Welcome back, $db_username.<h2>");
	?>
		<form action="index.php" method="post">
	    	<input type="submit" value="Log Out" name="logout">
	    </form>
	<?php
		}
		else if ( empty( $post_username ) || empty( $post_password ) ) {
	?>
			<br>
			<form action="index.php" method="post">
				Username: <input type="text" name="username">
				Password: <input type="password" name="password">
				<input type="submit" value="Log in">
			</form>
			<br>
			<a href="register.php"><h3>Don't have an account? Register it now!</h3></a>

			
	<?php
		}
		else {
			$query = "select *
					  from User
					  where username = '$post_username'";
			$result = $mysqli->query($query);
			//Make sure there is exactly one user with this username
			if ( $result && $result->num_rows == 1) {
				
				$row = $result->fetch_assoc();
				//Debugging
				//echo "<pre>" . print_r( $row, true) . "</p>";
				
				$db_hash_password = $row['hashphrase'];
				
				if( password_verify( $post_password, $db_hash_password ) ) {
					$db_username = $row['username'];
					$_SESSION['logged_user'] = $db_username;
				}
			} 
						
			if ( isset($_SESSION['logged_user'] ) ) {
				print("<h2>Welcome back, $db_username.<h2>");
	?>
			<form action="index.php" method="post">
	    		<input type="submit" value="Log Out" name="logout">
	    	</form>
	<?php
			} else {
				echo '<p>You did not login successfully.</p>';
				echo '<p>Please <a href="index.php">try</a> again.</p>';
			}
		}
	?>

	<?php
		print("<h1><center>Current Top 10 Photos</center></h1>");
		$result = $mysqli->query('select * from photos');
		while ($row = $result->fetch_assoc()) {
			$src = "img/".$row['pURL'];
			print("<img src=\"$src\" class=\"photo\">");
		}
	?>

</body>

<?php





?>

</html>