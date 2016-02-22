<!DOCTYPE html>
<html>
	<head>
    <meta charset="UTF-8">
		<title>Add a Job</title>
        <?php 
            require "php/functions.php";
            require 'php/openFile.php';
            require 'php/writeFile.php';
            require 'php/validateUser.php';
            add_versioned_file( 'css/style.css', 'Style' );
        ?>
	</head>

	<body>
		<header>
			<nav id="menubar">
				<ul>
          <li><a href="index.php"><strong>Job List</strong></a></li>
          <li><a href="addJob.html"><strong>Add Job</strong></a></li>
          <li><a href="searchJob.php"><strong>Search Job</strong></a></li>
				</ul>
			</nav>
		</header>


    <h3>Add a Job</h3>

    <form method="post" id="response" style="padding-left:50px">
        <div class="name">
            <span style="font:status-bar; font-size:20px; margin-left:42px">Company Name *</span>
            <span style="margin-left:50px">
                <input type="text" name="jobName" placeholder="Enter Company Name">
            </span><br><br>

            <span style="font:status-bar; font-size:20px; margin-left:122px">Job ID *</span>
            <span style="margin-left:53px">
                <input type="text" name="jobID" placeholder="Enter Job ID">
            </span><br><br>

            <span style="font:status-bar; font-size:20px; margin-left:102px">Location *</span>
            <span style="margin-left:54px">
                <input type="text" name="location" placeholder="Enter Your Location">
            </span><br><br>

            <span style="font:status-bar; font-size:20px; padding-left:127px">Salary *</span>
            <span style="margin-left:50px">
                <input type="text" name="salary" placeholder="Enter Salary">
            </span><br><br>

            <span style="font:status-bar; font-size:20px; padding-left:144px">Link</span>
            <span style="margin-left:65px">
                <input type="text" name="link" placeholder="Enter Website Link">
            </span><br><br>


            <br>
            <button type="submit" name="add" value="add" style="margin-left:385px; width:100px">
                <span style="font:status-bar; font-size:20px">Add</span>
            </button> 
        </div>
      </form> 

      <?php
        if (isset($_POST["add"])) {
            if ( ($_POST["jobName"] != "") && ($_POST["jobID"] != "") && ($_POST["location"] != "") 
                  && ($_POST["salary"] != "") ) {

                $jobName = filter_input(INPUT_POST, 'jobName', FILTER_SANITIZE_STRING);
               // $jobID = filter_input(INPUT_POST, 'jobID', FILTER_VALIDATE_INT);
                $jobID = $_POST["jobID"];
                $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
                $salary = filter_input(INPUT_POST, 'salary', FILTER_VALIDATE_INT);
                if (!is_string($jobName) || !preg_match("/[0-9]*/", $jobID) || strlen($jobID) > 6 || !is_string($location) || !is_numeric($salary)) {
                    print("<p>Invalid input!</p>");
                    exit;
                }

                $newJob = array($jobName, $jobID, $location, $salary);
                if ($_POST["link"] != "") {
                    $link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_STRING);
                    if (stripos($link, "www.") === false)
                        $link = "www.".$link;
                    if (stripos($link, "http://") === false)
                        $link = "http://".$link;
                    array_push($newJob, $link);
                }

                $file_pointer = openFile("data.txt", "a+");       
                if (isJobExisted($file_pointer, $newJob)) {
                    print("<p>Job has already existed.</p>");
                    exit;
                }
                $file_pointer = openFile("data.txt", "a+");
                $newJob[1] = str_pad($newJob[1], 6, '0', STR_PAD_LEFT);
                $line = implode("\t", $newJob);
                $line = "\n".$line;
                writeFileAtEnd($file_pointer, $line);
                print("<p>Update saved.</p>");
            }
            else {
                print("<p>Invalid input!</p>");
                exit;
            }
        }

      ?>


	</body>



</html>


