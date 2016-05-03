<?php session_start(); ?>
<!DOCTYPE html>
	<head>
		<title>Search an album</title>
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
			if (isset($_POST['searchPhoto'])) {
				$photoName = filter_input( INPUT_POST, 'photoName', FILTER_SANITIZE_STRING );
				$star = filter_input( INPUT_POST, 'star', FILTER_SANITIZE_NUMBER_INT );
				// print("photo name: $photoName, star: $star");
				if (empty($photoName) && ( empty($star) || $star < 1 || $star > 5 )) {
					print("Invalid photo name or star, please input again<br>");
				}
				else {
					if (empty($photoName)) {
						$sql = "select pURL from photos where pStar = $star;";
					}
					else if (empty($star) || $star < 1 || $star > 5) {
						$sql = "select pURL from photos where pName = '$photoName';";
					}
					else {
						$sql = "select pURL from photos where pName = '$photoName' OR pStar = $star;";
					}
					$result = $mysqli->query("$sql");
					if ($mysqli->errno) {
						print("Fail to search photos.");
					}
					else {
						while ($row = $result->fetch_assoc()) {
							$src = "img/".$row['pURL'];
							print("<img src=\"$src\" class=\"photo\">");
						}
						print("<br><br>");
					}
				}
			}

		?>

		<form method="post" style="padding-left:50px">
			<label for="photoName">Photo Name: </label>
			<input type="text" id="photoName" name="photoName">
			<br><br>
			<label for="star" style="padding-left:54px">Star: </label>
			<input type="text" id="star" name="star">
			<br><br>
			<div style="padding-left:140px">
				<input type="submit" id="searchPhoto" name="searchPhoto" value="search photo">		
			</div>	
		</form>
		<br><br><br><br><br><br><br>
	</body>

</html>