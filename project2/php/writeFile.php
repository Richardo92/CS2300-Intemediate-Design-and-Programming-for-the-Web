<?php
	/* write file into one specified file, begin writting at the end of this file */
	function writeFileAtEnd($file_pointer, $line) {
		if ( ! $file_pointer ) {  
			print( 'Empty file pointer' );  
			exit;
		}
		fputs($file_pointer, $line);
		$closed = fclose($file_pointer);
        if ($closed) {
            // print("<p>Register successfully</p>");
        }
        else {
            print("<p>Failed to close file</p>");
            exit;
        }
	}

	function writeFileFromBegin($file_pointer, $line) {
		if ( ! $file_pointer ) {  
			print( 'Empty file pointer' );  
			exit;
		}
		fputs($file_pointer, $line);
		$closed = fclose($file_pointer);
        if ($closed) {
            // print("<p>Register successfully</p>");
        }
        else {
            print("<p>Failed to close file</p>");
            exit;
        }
	}

?>