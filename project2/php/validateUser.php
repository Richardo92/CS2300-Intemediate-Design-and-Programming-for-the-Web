<?php
 	/* validate user by reading data from usr.txt */
	function validateUser($file_pointer, $username, $password) {
		if ( ! $file_pointer ) {  
			print( 'Empty file pointer whild validating user' );  
			exit;
		}
		if ($username === "" || $password === "") {
			print("Valid username or password");
			exit;
		}
		$isValid = false;
		$username = trim($username);
		$password = trim($password);
		while( ! feof( $file_pointer ) ) {
			//Read the string value of the row
			$line = fgets( $file_pointer );
			if (empty($line) || $line === "" || $line === "\n")
				continue;
			//Separate the row into separate array elements dividing at the tab
			$user = explode( "\t", $line ); 
			//validate user, if valid, read data from database and print it out
			if( !empty ($user) ) {
				// valid user, read his data from database
				$us = trim($user[0]);
				$ps = trim($user[1]);
				if ($us === $username && $ps === $password) {
					$isValid = true;
					break;
				}
			}
		}
		//Clean up
		unset( $user );
		unset ( $line );
		fclose( $file_pointer );
		return $isValid;
	}

	function isUserExisted($file_pointer, $username) {
		if ( ! $file_pointer ) {  
			print( 'Empty file pointer' );  
			exit;
		}
		if ($username === "") {
			print("Valid username");
			exit;
		}
		$isExisted = false;
		$username = trim($username);
		while( ! feof( $file_pointer ) ) {
			//Read the string value of the row
			$line = fgets( $file_pointer );
			if (empty($line) || $line === "" || $line === "\n")
				continue;
			//Separate the row into separate array elements dividing at the tab
			$user = explode( "\t", $line ); 
			//validate user, if valid, read data from database and print it out
			if( !empty ($user) ) {
				// valid user, read his data from database
				$us = trim($user[0]);
				if ($us === $username) {
					$isExisted = true;
					break;
				}
			}
		}
		//Clean up
		unset( $user );
		unset ( $line );
		fclose( $file_pointer );
		return $isExisted;
	}

	function isJobExisted($file_pointer, $job) {
		if ( ! $file_pointer ) {  
			print( 'Empty file pointer' );  
			exit;
		}
		if ($job === "") {
			print("Valid job");
			exit;
		}
		$isExisted = false;
		$jobName = trim($job[0]);
		$jobID = trim($job[1]);
		$jobID = ltrim($jobID, '0');
		while( ! feof( $file_pointer ) ) {
			//Read the string value of the row
			$line = fgets( $file_pointer );
			if (empty($line) || $line === "" || $line === "\n")
				continue;
			//Separate the row into separate array elements dividing at the tab
			$user = explode( "\t", $line ); 
			//validate user, if valid, read data from database and print it out
			if( !empty ($user) ) {
				// valid user, read his data from database
				$us = trim($user[0]);
				if (strcasecmp($us, $jobName) === 0) {
					$isExisted = true;
					break;
				}

				$us = trim($user[1]);
				$us = ltrim($us, '0');
				if ($us === $jobID) {
					$isExisted = true;
					break;
				}
			}
		}
		//Clean up
		unset( $user );
		unset ( $line );
		fclose( $file_pointer );
		return $isExisted;
	}
?>