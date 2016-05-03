<?php session_start(); ?>
<!DOCTYPE html>
	<head>
		<title>Show albums</title>
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

			if (isset($_POST['deleteAlbum'])) {
				$aID = filter_input( INPUT_GET, 'aID', FILTER_SANITIZE_STRING );
				$mysqli->query("delete from AlbumsToPhotos where aID = $aID;");
				$mysqli->query("delete from albums where aID = $aID;");

				if ($mysqli->errno) {
					print("<p>Fail to delete this photo</p>");
				}
				else {
					print("<p>Successfully delete this photo</p>");
					die();
				}
			}
			else if (isset($_POST['updateAlbum'])) {
				$albumName = filter_input( INPUT_POST, 'albumName', FILTER_SANITIZE_STRING );
				$albumComment = filter_input( INPUT_POST, 'comment', FILTER_SANITIZE_STRING );
				$aID = $_GET['aID'];
				$result = $mysqli->query("update albums SET aName = '$albumName', aDateModified = CURRENT_TIMESTAMP, aComment = '$albumComment' where aID = $aID;");
				if ($mysqli->errno) {
					print("Fail to update the album: $albumName");
				}
				else {
					print("Successfully update the album: $albumName");
				}
			}

			if(isset($_GET['aID'])) {
				$aID = $_GET['aID'];
				$result = $mysqli->query("select * from albums where aID = $aID;");
				$row = $result->fetch_assoc();
				$albumName = $row['aName'];
				$albumCreateDate = $row['aDateCreated'];
				$albumModifiedDate = $row['aDateModified'];
				$albumComment = $row['aComment'];
				print("<div style=\"padding-left: 70px\"><h3>Album Name: $albumName</h3></div>");
				print("<div style=\"padding-left: 70px\"><h3>Create Date: $albumCreateDate</h3></div>");
				print("<div style=\"padding-left: 70px\"><h3>Modified Date: $albumModifiedDate</h3></div>");
				print("<div style=\"padding-left: 70px\"><h3>Comment: $albumComment</h3></div>");

				$result = $mysqli->query("select * from AlbumsToPhotos where aID = $aID;");
				print("<div style=\"padding-left: 70px\">");
				while ($row = $result->fetch_assoc()) {
					$pID = $row['pID'];
					$photos = $mysqli->query("select * from photos where pID = $pID;");
					$photo = $photos->fetch_assoc();
					$src = "img/".$photo['pURL'];
					print("<a href=\"photo.php?src=$pID\"> <img src=\"$src\" class=\"photo\"></a>");
					//print("<img src=\"$src\" class=\"photo\">");
				}
				print("</div><br><br>");
				?>
				<br><br>
				<div style="padding-left:23px">
					<h2>Delete Album</h2>
				</div>
				<form method="post" style="padding-left:50px">
					<div style="padding-left:70px">
						<input type="submit" id="deleteAlbum" name="deleteAlbum" value="Delete Album">		
					</div>	
				</form>

				<br><br>
				<div style="padding-left:23px">
					<h2>Update Album</h2>
				</div>
				<form method="post" style="padding-left:50px">
					<label for="albumName">Album Name: </label>
					<input type="text" id="albumName" name="albumName">
					<br><br>
					<label for="comment" style="padding-left:23px">Comment: </label>
					<input type="text" id="comment" name="comment">
					<br><br>
					<div style="padding-left:144px">
						<input type="submit" id="updateAlbum" name="updateAlbum" value="Update Album">	
					</div>		
				</form>
				<br><br><br><br><br><br>

				<?php
			}
			else {
				$username = $_SESSION['logged_user'];
				if ($username === "admin") {
					$result = $mysqli->query('select * from albums;');
				}
				else {
					$result = $mysqli->query("select * from User where username = '$username';");
					$row = $result->fetch_assoc();
					$uID = $row['uID'];
					$result = $mysqli->query("select * from albums where uID = $uID;");
					
				}
				
				print("<ul>");
				while ($row = $result->fetch_assoc()) {
					$aName = $row['aName'];
					$aID = $row['aID'];
					print("<li><a href=\"albums.php?aID=$aID\">$aName</a></li>");
				}
				print("</ul>");
			}
		?>
	</body>
</html>