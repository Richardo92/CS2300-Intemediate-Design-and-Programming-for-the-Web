<?php
	/* draw table depending on the data read from data.txt */
	/* with add submit form */
	function drawTableWithAdd($jobs) {
		if ( ! is_array( $jobs ) ) {
			print("<p>There was an error on input array</p>");
			exit;
		}
		foreach ($jobs as $jobIndex => $job) {
			if (empty($job)) {
				continue;
			}
			print("<tr class='company'>");
			//$row = explode("\t",$job);
			//write the row elements
			foreach ($job as $elementIndex => $element) {
				$safe_element = htmlentities( $element );
				if ($elementIndex == 1) {
					$class = "class='id'";
				}
				else if ( $elementIndex == 3 ) {
					$class = "class='salary'";
				} else {
					$class = '';
				}
				if ($elementIndex == 4)
					continue;
				if ($elementIndex == 0 && count($job) == 5) {
					print("<td $class><a href='$job[4]'>$safe_element</a></td>");
				}
				else if ($elementIndex == 3) {
					print("<td $class>\$$safe_element k</td>");
				}
				else {
					print("<td $class>$safe_element</td>");
				}
			}
			print("<td class='un'><input type='submit' class='addToCart' name='job$jobIndex' value='Add' \></td>");
			print("</tr>");
		}
	}

	/* draw table depending on the data read from data.txt */
	/* WITHOUT add submit form */
	function drawTableWithoutAdd($jobs) {
		if ( ! is_array( $jobs ) ) {
			print("<p>There was an error on input array</p>");
			exit;
		}
		foreach ($jobs as $jobIndex => $job) {
			if (empty($job)) {
				continue;
			}
			print("<tr class='company'>");
			//$row = explode("\t",$job);
			//write the row elements
			foreach ($job as $elementIndex => $element) {
				$safe_element = htmlentities( $element );
				if (empty($safe_element) || $safe_element === "") {
					continue;
				}
				if ($elementIndex == 1) {
					$class = "class='id'";
				}
				else if ( $elementIndex == 3 ) {
					$class = "class='salary'";
				} else {
					$class = '';
				}
				if ($elementIndex == 4)
					continue;
				if ($elementIndex == 0 && count($job) == 5) {
					print("<td $class><a href='$job[4]'>$safe_element</a></td>");
				}
				else if ($elementIndex == 3) {
					print("<td $class>\$$safe_element k</td>");
				}
				else {
					print("<td $class>$safe_element</td>");
				}
			}
			print("</tr>");
		}
	}
?>