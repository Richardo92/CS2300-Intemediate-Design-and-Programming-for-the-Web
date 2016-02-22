<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Roller coasters</title>
		<style type="text/css">
			.ride-count { text-align: center; }
		</style>
	</head>

  <body>

	<h1>Rollercoasters</h1>

	<?php
		//Make sure the file is there
		if( ! file_exists( 'rollercoaster.txt' ) ) {
			print("<p>Can't find the file rollercoaster.txt</p>");
			exit;
		}
		
		//Read the file into an array of arrays
		//$lines = file("rollercoaster.txt");
		$file_pointer = fopen( 'rollercoaster.txt', 'r' );
		if ( ! $file_pointer ) {  
			print( 'error' );  
			exit;
		}
		$rides = array();
		while( ! feof( $file_pointer ) ) {
			//Read the string value of the row
			$line = fgets( $file_pointer );
			//Separate the row into separate array elements dividing at the tab
			$ride = explode( "\t", $line ); 
			
			//Add this ride to the array of rides
			if( !empty ($ride) ) {
				//Strip the "\n" off the end of the value
				$ride[3] = intval( $ride[3] );
				
				//Add this ride to the array of rides
				$rides[] = $ride;
			}
		}
		//Clean up
		unset( $ride );
		unset ( $line );
		fclose( $file_pointer );
		
		//Exit if the file load didn't produce an array
		if ( ! is_array( $rides ) ) {
			print("<p>There was an error reading the file rollercoaster.txt</p>");
			exit;
		}

		//Keep track of whether the file needs to be updated
		$update = false;
		
		//Loop through the rows of the text file which are in the $rides array
		for ($i = 0; $i < count($rides); $i++) {
			//Check to see if the increment button was clicked for this ride
			if (isset($_POST["ride$i"])) {
				//Get the current ride, which is an array, from the array of rides
				$ride = $rides[$i];
				
				//Get the current number of rides for this roller coaster
				$count = trim($ride[3]);
				
				//Increment the number
				$count++;
				
				//Update the rides array for this ride, given by $i 
					//and the count in the in the fourth position, given by 3
				$rides[$i][3] = $count;

				//The array will need to be written back to the file
				$update = true;
			}
		}

		//Check to see if the "Add new" submit button was clicked
		if (isset($_POST["newride"])) {
			//Check to see if all the fields have values
			if (($_POST["coaster"]!= "") && ($_POST["type"] != "") && ($_POST["park"] != "") && ($_POST["ride_count"] != "")) {
				//Add the new ride to the $rides array
				$new_ride = array( $_POST['coaster'], $_POST['type'], $_POST['park'], $_POST['ride_count'] );
				$rides[] = $new_ride;
				$update = true;
			}
		}

		//If the file needs updating, erase it and write the content
		if ($update) {
			$file_pointer = fopen("rollercoaster.txt","w");
			if (!$file_pointer) {
				print( "<p>Can't open rollercoaster.txt for write.</p>");
				exit;
			}
			
			$lines = array();
			foreach ($rides as $ride) {
				//Convert this line to a tab-delimited string
				$line = implode( "\t", $ride );
				//Add this line to the array of lines to be written
				$lines[] = $line;
			}
			
			//Convert the contents to a string without a trailing \n which would cause an extra row
			$contents = implode( "\n", $lines );
			
			//Write the contents
			fputs($file_pointer, $contents );
			
			//Close and show a status message
			$closed = fclose( $file_pointer );
			if( $closed ) {
				print '<p>Saved the update</p>';
			} else {
				print '<p>Update failed</p>';
			}
		}
		//Debugging - show the array of rides and / or post data
		//echo '<pre>' . print_r($rides, true) . '</pre>';
		//echo '<pre>' . print_r($_POST, true) . '</pre>';
	?>

		<form method="post">
			<table border="1">
				<thead>
					<th>Roller coaster</th>
					<th>Type</th>
					<th>Park</th>
					<th># of rides</th>
					<th>Increment</th>
				</thead>

				<?php
					foreach ($rides as $rideindex => $ride) {
						print("<tr>");
						//$row = explode("\t",$ride);
						//write the row elements
						foreach ($ride as $elementIndex => $element) {
							$safe_element = htmlentities( $element );
							//The fourth column gets a special class
							if ( $elementIndex == 3 ) {
								$class = "class='ride-count'";
							} else {
								$class = '';
							}
							print("<td $class>$safe_element</td>");
						}
						print("<td><input type='submit' name='ride$rideindex' value='Increment' \></td>");
						print("</tr>");
					}
				?>

				<tr>
					<td><input type="text" name="coaster" /></td>
					<td>
						<select name="type">
							<option value="Wood">Wood</option>
							<option value="Steel">Steel</option>
						</select>
					</td>
					<td><input type="text" name="park" /></td>
					<td><input type="text" name="ride_count" /></td>
					<td><input type="submit" name="newride" value="Add new"/></td>
				</tr>
			</table>
		</form>      
	</body>
</html>
