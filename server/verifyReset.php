<?php
    include 'dbconn.php';
	
	if(count($_POST) > 0) {
		$password = $_POST['password'];
		$selector = $_POST['selector'];
		$validator = $_POST['validator'];
		$currentDate = date('U');

		$reqStmt = mysqli_prepare($conn, 'SELECT * FROM `pass_reset` WHERE `reset_selector` = ? AND `reset_exp` >= ?');
		mysqli_stmt_bind_param($reqStmt, 'ss', $selector, $currentDate);
		mysqli_stmt_execute($reqStmt);
		$reqResult = mysqli_stmt_get_result($reqStmt);

		if(mysqli_num_rows($reqResult) > 0) {
			$reqRow = mysqli_fetch_array($reqResult);

			$tokenBin = hex2bin($validator);
			$tokenCheck = password_verify($tokenBin, $reqRow['reset_token']);

			if($tokenCheck === true) {
				$tokenEmail = $reqRow['reset_email'];

				$userStmt = mysqli_prepare($conn, 'SELECT `User_ID` FROM `user` WHERE BINARY `Email` = BINARY ?');
				mysqli_stmt_bind_param($userStmt, 's', $tokenEmail);
				mysqli_stmt_execute($userStmt);
				$userResult = mysqli_stmt_get_result($userStmt);

				if(mysqli_num_rows($userResult) > 0) {
					$userRow = mysqli_fetch_array($userResult);

					mysqli_begin_transaction($conn);
					try {
						$password = password_hash($password, PASSWORD_DEFAULT);

						$updateStmt = mysqli_prepare($conn, 'UPDATE `user` SET `PASS` = ? WHERE `User_ID` = ?');
						mysqli_stmt_bind_param($updateStmt, 'si', $password, $userRow['User_ID']);
						mysqli_stmt_execute($updateStmt);
								
						$deleteStmt = mysqli_prepare($conn, 'DELETE FROM `pass_reset` WHERE `reset_email` = ?');
						mysqli_stmt_bind_param($deleteStmt, 's', $tokenEmail);
						mysqli_stmt_execute($deleteStmt);
								
						mysqli_commit($conn);
						echo json_encode(array(true, true));
					} catch(mysqli_sql_exception $exception) {
						mysqli_rollback($mysqli);
						throw $exception;
						echo json_encode(array(false, $exception));
					}
				} else
					echo json_encode(array(true, false));
			} else
				echo json_encode(array(true, false));
		} else
			echo json_encode(array(true, false));
	}

	mysqli_close($conn);
?>