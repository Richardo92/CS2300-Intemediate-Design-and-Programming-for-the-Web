<?php
    if (isset($_POST["submit"])) {
    	/** when user doesn't leave his email address */ 
 		$firstname = $_POST["firstname"];
 		$lastname = $_POST["lastname"];
 		$email = $_POST["email"];
 		$phone =$_POST["phone"];
 		$array["firstname"] =  $firstname;
 		$array["lastname"] =  $lastname;
 		$array["email"] =  $email;
 		$array["phone"] =  $phone;
 		/** invalid email address */
 		if (preg_match('/@/', $email) == 0) {
    		echo "<h2>Thanks a lot for your interest. I have aready received your information.<h2>\n";
    		echo "But you didn't leave your e-mail address so I may not contact with you.\n";
    		return;
    	}

 		$msg = "Thanks a lot for your interest. I have already received your information and will contact with you soon.\n";
 		$msg .= "The following is your contact information.\n\n";
 		$msg = formMes($msg, $array);
 		// foreach ($array as $key => $value) {
 		// 	$msg .= $key." is ".$value."\n\n";
 		// }

 		if (isset($_POST["approve"])) {
 			$flag = $_POST["approve"];
 			if ($flag == 1) {
 				$msg .= "Response to whether I can contact you: YES.\n\n";
 			}
 		}
 		else {
 			$msg .= "Response to whether I can contact you: NO.\n\n";
 		}

 		if (isset($_POST["option"])) {
 			$num = $_POST["option"];
 			if ($num == 1) {
 				$msg .= "Contact media is: Telephone.\n\n";
 			}
 			else if ($num == 2) {
 				$msg .= "Contact media is: Email.\n\n";
 			}
 		}
 		else {
 			$msg .= "Contact media is: None.\n\n";
 		}

 		if (isset($_POST["comment"])) {
 			$msg .= "I have already received your comment. I appreciate it very much and will keep it as secret.\n\n";
 		}
 		else {
 			$msg .= "It will be better if you can give me where I attract you. But I still appreciate it a lot for your interest.\n\n";
 		}

 		$msg .= "\n\n\n\n\nBest Regards,\nDanni Li\n";
		// use wordwrap() if lines are longer than 70 characters
		$msg = wordwrap($msg,70);

		// send email
		mail($email,"Thanks for your interest.",$msg);

		echo "Submit successfully. One e-mail will be sent to your e-mail address.";
    }
    else {
        echo "Submit unsuccessfully. Please try again.";
    }

    /** user defined function. Used to form message depending on info which user inputs and send this msg to user through email.
     *  $msg: message formed depending on info user inputs
     *  $array info that user inputs
     */
    function formMes($msg, $array) {
    	foreach ($array as $key => $value) {
 			$msg .= $key." is ".$value."\n\n";
 		}
 		return $msg;
    }
?>