<?php
	/* read file from pointer. divide them according to "\t" into arrays*/
	function readFileFromData($file_pointer) {
		if ( ! $file_pointer ) {  
			print( 'Empty file pointer' );  
			exit;
		}
		$lines = array();
		while( ! feof( $file_pointer ) ) {
			//Read the string value of the row
			$line = fgets( $file_pointer );
			if (empty($line) || $line === "" || $line === "\n")
				continue;
			//Separate the row into separate array elements dividing at the tab
			$lineArr = explode( "\t", $line ); 
			
			//Add this lineArr to the array of rides
			if( !empty ($lineArr) ) {
				//Strip the "\n" off the end of the value
				$lineArr[3] = intval( $lineArr[3] );
				
				//Add this lineArr to the array of rides
				$lines[] = $lineArr;
			}
		}
		//Clean up
		unset( $lineArr );
		unset ( $line );
		fclose( $file_pointer );

		//Exit if the file load didn't produce an array
		if ( ! is_array( $lines ) ) {
			print("<p>There was an error reading the file data.txt</p>");
			exit;
		}
		//Exit if the file load didn't produce an array
		if ( ! is_array( $lines ) ) {
			print("<p>There was an error reading the file data.txt</p>");
			exit;
		}
		return $lines;
	}
?>