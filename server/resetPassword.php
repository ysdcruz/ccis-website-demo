<?php
    include 'dbconn.php';
	
	if(count($_POST) > 0) {
		$email = $_POST['email'];

		$selector = bin2hex(openssl_random_pseudo_bytes(8));
		$token = openssl_random_pseudo_bytes(32);

		$link = 'http://ccis. host/forgot-password.php?selector='.$selector.'&validator='.bin2hex($token);

		$expires = date('U') + 900;
		
		mysqli_begin_transaction($conn);

		try {
			$deleteStmt = mysqli_prepare($conn, 'DELETE FROM `pass_reset` WHERE `reset_email` = ?');
			mysqli_stmt_bind_param($deleteStmt, 's', $email);
			mysqli_stmt_execute($deleteStmt);

			$hashedToken = password_hash($token, PASSWORD_DEFAULT);
			$newStmt = mysqli_prepare($conn, 'INSERT INTO `pass_reset` (`reset_email`, `reset_selector`, `reset_token`, `reset_exp`) VALUES (?, ?, ?, ?)');
			mysqli_stmt_bind_param($newStmt, 'ssss', $email, $selector, $hashedToken, $expires);
			mysqli_stmt_execute($newStmt);

			mysqli_commit($conn);

            ini_set( 'display_errors', 1 );
            error_reporting( E_ALL );
			$subject = 'Reset your password | College of Computer and Information Sciences';
			
			$message = '<h1>CCIS Account Password Reset</h1>'; 
			$message .= '<p>We received a password reset request. This request expires in <strong>15 minutes</strong>.</p>'; 
			$message .= '<p>Copy and go to the link to reset your password: '.$link.'</p>'; 
			$message .= '<p><strong>PLEASE REMOVE SPACES FROM THE LINK.</strong> This was added due to sending problems with the webhost.</p>'; 
			$message .= '<p><br/><br/>If you did not make this request, please ignore this email.</p>'; 

			$headers = "From: noreply.ccis.pup@gmail.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			$mailSent = mail($email, $subject, $message, $headers);
			if($mailSent) { 
				echo json_encode(array(true, $email)); 
			} else { 
				echo json_encode(array(false, 'Message could not be sent.')); 
			}
		} catch(mysqli_sql_exception $exception) {
			mysqli_rollback($mysqli);
			throw $exception;
			echo json_encode(array(false, $exception));
		}
	}
?>