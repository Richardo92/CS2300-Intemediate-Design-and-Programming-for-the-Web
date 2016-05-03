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
			$username = $_SESSION['logged_user'];
			$result = $mysqli->query('select * from photos;');
			while ($row = $result->fetch_assoc()) {
				$src = "img/".$row['pURL'];
				$pID = $row['pID'];
				print("<a href=\"photo.php?src=$pID\"> <img src=\"$src\" class=\"photo\"></a>");
			}
			// if ($username === "admin") {
			// 	$result = $mysqli->query('select * from photos;');
			// 	while ($row = $result->fetch_assoc()) {
			// 		$src = "img/".$row['pURL'];
			// 		$pID = $row['pID'];
			// 		print("<a href=\"photo.php?src=$pID\"> <img src=\"$src\" class=\"photo\"></a>");
			// 	}
			// }
			// else {
			// 	$result = $mysqli->query("select * from User where username = '$username';");
			// 	$row = $result->fetch_assoc();
			// 	$uID = $row['uID'];

			// 	$result = $mysqli->query("select * from albums where uID = $uID;");
			// 	while ($row = $result->fetch_assoc()) {
			// 		$aID = $row['aID'];
			// 		$photos = $mysqli->query("select * from AlbumsToPhotos where aID = $aID;");
			// 		while ($row2 = $photos->fetch_assoc()) {
			// 			$pID = $row2['pID'];
			// 			$photo = $mysqli->query("select * from photos where pID = $pID");
			// 			$row3 = $photo->fetch_assoc();
			// 			$src = "img/".$row3['pURL'];
			// 			print("<a href=\"photo.php?src=$pID\"> <img src=\"$src\" class=\"photo\"></a>");
			// 		}
			// 	}
			// }
		?>
	</body>


</html>