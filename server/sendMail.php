<?php
	if(count($_POST) > 0) {
		$email = json_decode($_POST['email'], true);
		$subject = "Request Accepted | College of Computer and Information Sciences";
		
		$message = "<h1>Welcome to College of Computer and Information Sciences</h1>"; 
		$message .= "<p>Your registration has been accepted. You are now a registered user of the College of Computer and Information Sciences (CCIS) Website.</p>"; 
		$message .= "<p>You can now log in to the <a href = \"http://localhost/CCIS_Website/sign-in.php#log-in\">website</a> using your registered email.</p>"; 

		$headers = "From: noreply.ccis.pup@gmail.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$mailSent = mail($email, $subject, $message, $headers);
		if($mailSent) { 
			echo json_encode(array(true)); 
		} else { 
			echo json_encode(array(false, 'Message could not be sent.')); 
		}
	}
?>