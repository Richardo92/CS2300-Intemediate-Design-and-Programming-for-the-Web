<?php
	//Adds a JavaScript file or Stylesheet with a version based on the file modification time
	function add_versioned_file( $file, $type = 'JavaScript' ) {
		$mod_time = filemtime( $file );
		$url = "{$file}?ver=$mod_time";
		if( 'JavaScript' == $type ) {
			print( "<script src='$url'></script>" );
		} elseif( 'Style' == $type ) {
			print( "<link rel='stylesheet' href='$url'>" );
		}
	}
?>