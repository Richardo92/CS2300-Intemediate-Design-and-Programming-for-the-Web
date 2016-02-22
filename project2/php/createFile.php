<?php
	/* create file at specified path */
	function createFileForUser($fileName) {
		if ($fileName === "") {
			print("<p>Invalid filename while creating database for user.</p>");
			exit;
		}
		$file_create = fopen("$fileName", 'w');
        if (!$file_create) {
        	print("<p>fail to create db</p>");
        	exit;
        }
        else {
        	echo "<script> alert('Register successfully'); </script>";
        }
	}

?>