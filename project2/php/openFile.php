<?php
	/* open the file with specified root. return the file pointer */
	function openFile($filename, $root) {
		//Make sure the file is there
		if( ! file_exists( "$filename" ) ) {
			print("<p>Can't find the file $filename</p>");
			exit;
		}
		
		//Read the file into an array of arrays
		//$lines = file("rollercoaster.txt");
		$file_pointer = fopen( "$filename", "$root" );
		if ( ! $file_pointer ) {  
			print( 'Failt to open file' );  
			exit;
		}
		return $file_pointer;
	}

?>