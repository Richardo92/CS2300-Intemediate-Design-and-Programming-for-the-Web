<?php session_start(); ?>
<!DOCTYPE html>
	<head>
		<title>Show photos</title>
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
		?>




		<form method="post" enctype="multipart/form-data" style="padding-left:20px">
			<p>
				<label for="new-photo">Single photo upload: </label>
				<input id="new-photo" type="file" name="newphoto"> <br>

				<div style="padding-left: 50px">
					<label for="photoName">Photo Name: </label>
					<input type="text" id="photoName" name="photoName">
				</div>
				<br>
				<div style="padding-left: 15px">
					<label for="photoDesc">Photo Description: </label>
					<input type="text" id="photoDesc" name="photoDesc">
				</div>
				<br>
				<div style="padding-left: 50px">
					<label for="star" style="padding-left:54px">Star: </label>
					<input type="text" id="star" name="star">
				</div>
				<br>

				<?php
					$username = $_SESSION['logged_user'];
					if ($username === "admin") {
						$result = $mysqli->query("select * from albums;");
					}
					else {
						$result = $mysqli->query("select * from User where username = '$username'");
						$row = $result->fetch_assoc();
						$uID = $row['uID'];
						$result = $mysqli->query("select * from albums where uID = $uID");
					}
					print("<ul>");
					while ($row = $result->fetch_assoc()) {
						$name = $row['aName'];
						$aID = $row['aID'];
						print("<li><label for=\"$aID\">$name: </label>");
						print("<input type=\"checkbox\" id=\"$aID\" name=\"$aID\"></li>");
						print("<br>");
					}
					print("</ul>");
				?>
				<input type="submit" value="Upload photo">
			</p>
		</form>
		<?php

			//Check to see if a file was uploaded using the "single file" form
			if ( ! empty( $_FILES['newphoto'] ) ) {
				$newPhoto = $_FILES['newphoto'];
				$originalName = $newPhoto['name'];
				if ( $newPhoto['error'] == 0 ) {
					$tempName = $newPhoto['tmp_name'];
					move_uploaded_file( $tempName, "img/$originalName");

					$pName = filter_input( INPUT_POST, 'photoName', FILTER_SANITIZE_STRING );
					$pDesc = filter_input( INPUT_POST, 'photoDesc', FILTER_SANITIZE_STRING );
					$pStar = filter_input( INPUT_POST, 'star', FILTER_SANITIZE_NUMBER_INT );
					
					if (empty($pName) || empty($pDesc) || empty($pStar) || $pStar < 1 || $pStar > 5 ) {
						print("Fail to add this photo: $pName");
						die();
					}

					$sql = "insert into photos values(NULL, '$pName', '$originalName', 'pDesc', pStar);";
					$result = $mysqli->query("$sql");
					if ($mysqli->errno) {
						print("Fail to insert the photo: $originalName");
						exit;
					}
					$pID = $mysqli->insert_id;
					$ret = $mysqli->query('select * from albums');
					while ($row = $ret->fetch_assoc()) {
						$aID = $row['aID'];
						// print("$name");
						print("<br>");
						if (isset($_POST["$aID"])) {
							$aID = $row['aID']; 
							$sql = "insert into AlbumsToPhotos values(NULL, $aID, $pID);";
							// print("$sql");
							$ret2 = $mysqli->query("$sql");
							if ($mysqli->errno) {
								print("Fail to insert photo into the album: $name");
								exit;
							}
						}
					}
					print("<p>&nbsp&nbsp insert photo: $originalName into albums successfully<p>");
				} 
				else {
					print("<p>&nbsp&nbsp Error: The file $originalName was not uploaded.</p>");
				}
			}
		?>
	</body>

           
</html>