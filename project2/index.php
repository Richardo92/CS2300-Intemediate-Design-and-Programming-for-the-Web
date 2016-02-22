<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Job Wall</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<?php 
			require "php/functions.php";
			require 'php/openFile.php';
			require 'php/readFile.php';
			require 'php/drawTable.php';
			require 'php/validateUser.php';
			require 'php/writeFile.php';
			require 'php/createFile.php';
			//add_versioned_file( 'js/job.js', 'JavaScript' );
			add_versioned_file( 'css/style.css', 'Style' );
		?>
	</head>

  <body>
  	<header>
		<nav id="menubar">
			<ul>
				<li><a href="index.php"><strong>Job List</strong></a></li>
				<li><a href="addJob.php"><strong>Add Job</strong></a></li>
				<li><a href="searchJob.php"><strong>Search Job</strong></a></li>
			</ul>
		</nav>
		<form method="POST" style="padding-top:15px">
			Username:<input class="login" type="text" name="username" placeholder="Please enter your username">
			Password:<input class="login" type="password" name="password" placeholder="Please enter your password">
			<input  type="submit" style="width:100px; height:35px" name="login" value="Login">
			<input  type="submit" style="width:100px; height:35px;" name="register" value="Register">
			<input  type="submit" style="width:100px; height:35px;" name="cancel" value="Login Out">
		</form>
	</header>

	<br><br><br><br>
	<h1>Job Wall</h1>
	<p id="welcome"></p>
	<?php
		// $file_pointer = openFile('status.txt', 'r');
		/* status variable */
		$isLogined = "false";
		$usn = "";
		$pwd = "";
		$counter = 0;
		

		/* open file, data.txt to read all info about jobs */
		$file_open = openFile('data.txt', 'r');
		/* read info */
		$jobs = readFileFromData($file_open);



	?>

		<!-- <form method="post"> -->
	<form method="post">
		<table border="1" style="width: 55%">
			<thead style="height:50px">
				<th style="width:200px">Company Name</th>
				<th style="width:150px">Job ID</th>
				<th style="width:200px">Location</th>
				<th style="width:150px">Salary</th>
				<th>Add To Cart</th>
			</thead>
			<tbody id="jobBody">
				<?php
					/* draw table depending on the data read from data.txt */
					drawTableWithAdd($jobs);
				?>
			</tbody>
		</table>
	</form>
	<br><br><br>
	<h1>My Cart</h1>
	<table border="1" style="width: 46%">
		<thead style="height:50px">
			<th style="width:200px">Company Name</th>
			<th style="width:150px">Job ID</th>
			<th style="width:200px">Location</th>
			<th style="width:150px">Salary</th>
		</thead>

		<tbody id="cartBody">
			<?php
				if (isset($_POST["login"])) {
					$username = $_POST["username"];
					$password = $_POST["password"];
					$file_open = openFile("usr.txt", 'r');
					if (!validateUser($file_open, $username, $password)) {
						echo "<script> alert('Failed to login. Invalid username or password'); </script>";
						exit;
					}

					$file_usr = openFile("usr_cart/usr_$username.txt", 'r');
					$user_jobs = readFileFromData($file_usr);
					drawTableWithoutAdd($user_jobs);

					$file_pointer = openFile('status.txt', 'w+');
					$line = trim("true")."\n";
					$line = $line.trim($username);
					writeFileFromBegin($file_pointer, $line);
				}
				else if (isset($_POST["register"])) {
					$username = $_POST["username"];
					$password = $_POST["password"];
					$username = trim($username);
					$password = trim($password);

					if ($username != "" && $password != "") {
						// add new username and password into usr.txt
						$file_create = openFile('usr.txt', 'a+');
						if (isUserExisted($file_create, $username)) {
							echo "<script> alert('User has already existed!'); </script>";
							exit;
						}
						$file_create = openFile('usr.txt', 'a+');
						$line = $username."\t".$password."\n";
						writeFileAtEnd($file_create, $line);
						createFileForUser("usr_cart/usr_$username.txt");
						/* set user state as log out */
						$file_pointer = openFile('status.txt', 'w+');
						$line = trim("false");
						writeFileFromBegin($file_pointer, $line);
					}
					else {
						echo "<script> alert('Failed to register! Invalid username or password'); </script>";
					}
				}
				else if (isset($_POST["cancel"])) {
					$file_pointer = openFile('status.txt', 'w+');
					$line = trim("false");
					writeFileFromBegin($file_pointer, $line);
				}
				/* update user state */
				$file_pointer = openFile('status.txt', 'r');
				while( ! feof( $file_pointer ) ) {
					$line = fgets( $file_pointer );
					if (empty($line) || $line === "" || $line === "\n")
						continue;
					if ($counter === 0) {
						$isLogined = trim($line);
						if ($isLogined === "false") {
							break;
						}
					}
					else if ($counter === 1) {
						$usn = $line;
					}
					$counter++;
				}
				
				for ($i = 0; $i < count($jobs); $i++) {
					if (isset($_POST["job$i"])) {
						if ($isLogined === "false") {
							break;
						}
						$file_pointer = openFile("usr_cart/usr_$usn.txt", 'a+');
						if (isJobExisted($file_pointer, $jobs[$i])) {
							print("<p>The job has already existed.</p>");
						}
						else {
							$file_pointer = openFile("usr_cart/usr_$usn.txt", 'a+');
							$line = implode("\t", $jobs[$i]);

		                	$line = "\n".$line;
		                	writeFileAtEnd($file_pointer, $line);
						}
						
		                $file_pointer = openFile("usr_cart/usr_$usn.txt", 'r');
						$lines = readFileFromData($file_pointer);
						drawTableWithoutAdd($lines);
						break;
					}
				}
				
				if ($isLogined === "true") {
					echo "<script> document.getElementById('welcome').innerHTML = 'Welcome, $usn'; </script>";
				}
				else {
					echo "<script> document.getElementById('welcome').innerHTML = 'You are currently a guest. Please login or register ASAP.'; </script>";
				}
				//print("<p>No Login</p>");
			?>
		</tbody>
	</table>

	



  </body>

</html>
