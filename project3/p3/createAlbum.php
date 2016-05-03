<?php session_start(); ?>
<!DOCTYPE html>
	<head>
		<title>Create an album</title>
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
			if ( isset($_SESSION['logged_user'] ) ) {
				$db_username = $_SESSION['logged_user'];
				print("<h2>Welcome back, $db_username.</h2>");
			}
			else {
				echo '<p>You did not login successfully.</p>';
				echo '<p>Please <a href="index.php">try</a> again.</p>';
				die();
			}
			if (isset($_POST['createAlbum'])) {
				$username = $_SESSION['logged_user'];
				$result = $mysqli->query("select * from User where username = '$username'");
				$row = $result->fetch_assoc();
				$uID = $row['uID'];

				$albumName = $_POST['albumName'];
				$comment = $_POST['comment'];
				$sql = "insert into albums values(NULL, '$albumName', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$comment', $uID);";
				$mysqli->query("$sql");
				if ($mysqli->errno) {
					print("<p>Fail to create the album: $albumName</p>");
					print("<br><br>");
				}
				else {
					print("<p>Successfully create the album: $albumName<p>");
					print("<br><br>");
				}
			}

		?>
		
		<form method="post" style="padding-left:50px">
			<label for="albumName">Album Name: </label>
			<input type="text" id="albumName" name="albumName">
			<br><br>
			<label for="comment" style="padding-left:23px">Comment: </label>
			<input type="text" id="comment" name="comment">
			<br><br>
			<div style="padding-left:144px">
				<input type="submit" id="createAlbum" name="createAlbum" value="create album">	
			</div>		
		</form>
		<br><br><br><br><br><br>
	</body>

</html>