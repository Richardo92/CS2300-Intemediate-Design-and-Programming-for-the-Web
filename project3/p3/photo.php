<?php session_start(); ?>
<!DOCTYPE html>
	<head>
		<title>Show Photo</title>
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
			//echo '<pre>' . print_r( $_GET, true ) . '</pre>';
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

			if (isset($_POST['deletePhoto'])) {
				$pID = filter_input( INPUT_GET, 'src', FILTER_SANITIZE_STRING );

				$username = $_SESSION['logged_user'];
				if ($username === "admin") {
					$mysqli->query("delete from AlbumsToPhotos where pID = $pID;");
					$mysqli->query("delete from photos where pID = $pID;");
					if ($mysqli->errno) {
						print("<p>Fail to delete this photo</p>");
					}
					else {
						print("<p>Successfully delete this photo</p>");
						die();
					}
				}
				else {
					print("<p>You don't have the root to delete this photo!</p>");
				}
			}
			else if (isset($_POST['updatePhoto'])) {
				$pID = filter_input( INPUT_GET, 'src', FILTER_SANITIZE_STRING );
				$pName = filter_input( INPUT_POST, 'photoName', FILTER_SANITIZE_STRING );
				$pDesc = filter_input( INPUT_POST, 'photoDesc', FILTER_SANITIZE_STRING );
				$pStar = filter_input( INPUT_POST, 'star', FILTER_SANITIZE_NUMBER_INT );
				
				if (empty($pName) || empty($pDesc) || empty($pStar) || $pStar < 1 || $pStar > 5 ) {
					print("<p>Invalid photo name or star, please input again</p><br>");
				}
				else {
					$result = $mysqli->query("update photos SET pName = '$pName', pDesc = '$pDesc', pStar = $pStar where pID = $pID; ");
					if ($mysqli->errno) {
						print("<p>Fail to update the photo: $pName</p>");
					}
					else {
						print("<p>Successfully update the photo: $pName</p>");
					}
				}
			}


			if (isset($_GET['src'])) {
				$pID = filter_input( INPUT_GET, 'src', FILTER_SANITIZE_STRING );
				
				$query = "select * from photos where pID = $pID;";
				$result = $mysqli->query($query);

				if ($mysqli->errno) {
					print("Cannot open this photo.");
				}
				else {
					$row = $result->fetch_assoc();
					$src = "img/".$row['pURL'];
					$pName = $row['pName'];
					$pDesc = $row['pDesc'];
					$pStar = $row['pStar'];
					print("<img src=\"$src\" class=\"singlePhoto\">");
					print("<div style=\"padding-left: 70px\"><h2>Description: $pDesc</h2></div>");
					print("<div style=\"padding-left: 70px\"><h2>Star: $pStar</h2></div>");
					$query = "select * from AlbumsToPhotos where pID = $pID;";
					$albums = $mysqli->query($query);
					if ($mysqli->errno) {
						print("Cannot open this photo.");
					}
					else {
						$aNames = "";
						$users = "";
						while ($row = $albums->fetch_assoc()) {
							$albumID = $row['aID'];
							$query = "select * from albums where aID = $albumID;";
							$result = $mysqli->query($query);
							$rowInAlbum = $result->fetch_assoc();
							$aNames = $aNames.$rowInAlbum['aName'].", ";
							$userID = $rowInAlbum['uID'];
							$query = "select * from User where uID = $userID;";
							$result = $mysqli->query($query);
							$rowInUser = $result->fetch_assoc();
							$users = $users.$rowInUser['username'].", ";
						}
						print("<div style=\"padding-left: 70px\"><h2>Album Names: $aNames</h2></div>");
						print("<div style=\"padding-left: 70px\"><h2>Album Creators: $users</h2></div>");
						print("<div style=\"padding-left: 70px\"><h2>Photo Name: $pName</h2></div>");
						print("<div style=\"padding-left: 70px\"><h2>Photo Description: $pDesc</h2></div>");
						print("<div style=\"padding-left: 70px\"><h2>Photo Star: $pStar</h2></div>");

						?>
						<br><br>
						<div style="padding-left:23px">
							<h2>Delete Photo</h2>
						</div>
						<form method="post" style="padding-left:50px">
							<div style="padding-left:70px">
								<input type="submit" id="deletePhoto" name="deletePhoto" value="Delete Photo">		
							</div>	
						</form>

						<br><br>
						<div style="padding-left:23px">
							<h2>Update Photo</h2>
						</div>
						<form method="post" style="padding-left:50px">
							<div style="padding-left: 36px">
								<label for="photoName">Photo Name: </label>
								<input type="text" id="photoName" name="photoName">
							</div>
							<br>
							<div style="padding-left: 0px">
								<label for="photoDesc">Photo Description: </label>
								<input type="text" id="photoDesc" name="photoDesc">
							</div>
							<br>
							<div style="padding-left: 36px">
								<label for="star" style="padding-left:54px">Star: </label>
								<input type="text" id="star" name="star">
							</div>
							<br>
							<div style="padding-left:170px">
								<input type="submit" id="updatePhoto" name="updatePhoto" value="Update Photo">		
							</div>	
						</form>
						<br><br><br><br>
						<?php
					}

				}
			}

		?>


	</body>


</html>