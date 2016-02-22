<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Search a Job</title>
		<?php 
			require "php/functions.php";
			require 'php/openFile.php';
			require 'php/readFile.php';
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
		</header>

		<h3>Search a Job</h3>

		<form method="post" style="padding-left:50px">
	        <div class="name">
	            <span style="font:status-bar; font-size:20px; margin-left:42px">Company Name</span>
	            <span style="margin-left:50px">
	                <input type="text" name="jobName" placeholder="Enter Job Name">
	            </span><br><br>

	            <span style="font:status-bar; font-size:20px; margin-left:122px">Job ID</span>
	            <span style="margin-left:53px">
	                <input type="text" name="jobID" placeholder="Enter Job ID">
	            </span><br><br>

	            <span style="font:status-bar; font-size:20px; margin-left:102px">Location</span>
	            <span style="margin-left:54px">
	                <input type="text" name="location" placeholder="Enter Your Location">
	            </span><br><br>

	            <br>
	            <button type="submit" name="search" value="search" style="margin-left:372px; width:100px">
	                <span style="font:status-bar; font-size:20px">Search</span>
	            </button> 
	        </div>
     	</form> 

		<?php
			if (isset($_POST["search"])) {
				if ($_POST["jobName"] != "" || $_POST["jobID"] != "" || $_POST["location"] != "") {
					/* open file to search */
					$file_pointer = openFile("data.txt", "r");
					/* read info */
					$jobs = readFileFromData($file_pointer);
					/* initialize search requirements */
					$jobName = ($_POST["jobName"] != "" ? $_POST["jobName"] : "");
					$jobID = ($_POST["jobID"] != "" ? $_POST["jobID"] : "");
					$location = ($_POST["location"] != "" ? $_POST["location"] : "");
					$jobName = htmlentities($jobName);
					$jobID = htmlentities($jobID);
					$jobID = str_pad($jobID, 6, '0', STR_PAD_LEFT);
					$location = htmlentities($location);

					if (!is_string($jobName) || !preg_match("/[0-9]*/", $jobID) || strlen($jobID) > 6 
						|| !is_string($location)         ) {
                   	 	print("<p>Invalid input!</p>");
                    	exit;
	                }
	                if ($jobName != "" && strlen($jobName) > 15) {
	                    print("<p>Invalid input!</p>");
	                    exit;
	                }
	                if ($jobID != "" && (!preg_match("/^[0-9]*$/", $jobID) || (strlen($jobID) > 6))) {
	                    print("<p>Invalid input!</p>");
	                    exit;
	                }
	                if ($location != "" && strlen($location) > 30) {
	                    print("<p>Invalid input!</p>");
	                    exit;
	                }


					/* search */
					print("<table border='1' style='width: 55%'>");
					print("<thead style='height:50px'>");
					print("<th style='width:200px'>Job Name</th>");
					print("<th style='width:150px'>Job ID</th>");
					print("<th style='width:200px'>Location</th>");
					print("<th style='width:150px'>Salary</th>");
					print("</thead>");


					foreach ($jobs as $rideIndex => $job) {
						if ((strcasecmp($job[0], $jobName) === 0 || $jobName === "")
							&& (strcasecmp($job[1], $jobID) === 0 || $jobID === "")
							&& (strcasecmp($job[2], $location) === 0 || $location === "")) {

						// if ( ($ride[0] === $jobName || $jobName === "")
						// 	 	&& ($ride[1] === $jobID || $jobID === "") 
						// 	 	&& ($ride[2] === $location || $location === "") ) {
							print("<tr>");
							foreach ($job as $elementIndex => $element) {
								$safe_element = htmlentities( $element );
								//The fourth column gets a special class
								if ( $elementIndex == 3 ) {
									$class = "id='salary'";
								} else {
									$class = '';
								}
								if ($elementIndex == 4)
									continue;
								if ($elementIndex == 0 && count($job) == 5) {
									print("<td $class><a href='$job[4]'>$safe_element</a></td>");
								}
								else {
									print("<td $class>$safe_element</td>");
								}
							}
							print("</tr>");
						}
					}

				}
				else {
					print("<h3>Cannot find any records meet your requirement.</h3>");
				}

			}
		?>






	</body>



</html>


