<!DOCTYPE html>
	<head>
		<title>Register</title>
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
			$post_username = filter_input( INPUT_POST, 'registerUsername', FILTER_SANITIZE_STRING );
			$post_password = filter_input( INPUT_POST, 'registerPassword', FILTER_SANITIZE_STRING );
			if ( empty( $post_username ) || empty( $post_password ) ) {
		?>
				<br>
				<form action="register.php" method="post">
					Username: <input type="text" name="registerUsername">
					Password: <input type="password" name="registerPassword">
					<input type="submit" value="Register">
				</form>
				<br>			
		<?php
			}
			else {
				$hashed_password = password_hash("$post_password", PASSWORD_DEFAULT);
				// print("$hashed_password<br>");
				$query = "insert into User value(NULL, '$post_username', '$hashed_password');";
				// print($query);
				$mysqli->query($query);
				if ($mysqli->errno) {
					print("<h2>Fail to write your username and password into database. Please do it again</h2>");
					?>
						<form action="register.php" method="post">
						Username: <input type="text" name="registerUsername">
						Password: <input type="password" name="registerPassword">
						<input type="submit" value="Register">
						</form>
					<?php
				}
				else {
					// print("$post_username, $post_password");
					print("<h2>Successfully Registered!</h2>");
					printf("<a href=\"index.php\">Go Back</a>");
				}
				
			}
		?>

	</body>
</html>