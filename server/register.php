<?php
	include 'dbconn.php';
	session_start();

	if(isset($_SESSION['admin'])){
		header('location: admin/index.php');
	}

	if(isset($_SESSION['user'])){
		$sql = 'SELECT * FROM `user` WHERE `User_ID` = "'.$_SESSION['user'].'"';
		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_row($result);
	}
	
	if(isset($_POST['signUp'])){
		$userType = $_POST['account-type'];
		$userNo = $_POST['user-no'];
		$fName = $_POST['first-name'];
		$lName = $_POST['last-name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
				
		$sql = 'SELECT * FROM `user` WHERE `Personal_ID` = BINARY "'.$userNo.'"';
		$checkNo = mysqli_num_rows(mysqli_query($conn, $sql));
		$sql = 'SELECT * FROM `user` WHERE `Email` = BINARY "'.$email.'"';
		$checkEmail = mysqli_num_rows(mysqli_query($conn, $sql));
						
		if($checkNo > 0) {
			$_SESSION['error1'] = 'User ID Taken!';
			header('location: ../sign-in.php#sign-up');
			die();
		}
		if($checkEmail > 0) {
			$_SESSION['error1'] = 'Email Taken!';
			header('location: ../sign-in.php#sign-up');
			die();
		}

		$password = password_hash($password, PASSWORD_DEFAULT);
		$sql = 'INSERT INTO `user`(`Personal_ID`, `FName`, `LName`, `Type`,  `Email`, `Pass`) VALUES ("'.$userNo.'", "'.$fName.'", "'.$lName.'", "'.$userType.'", "'.$email.'", "'.$password.'");';
		$sql .= "SELECT last_insert_id()";

		if(mysqli_multi_query($conn, $sql)) {
			do {
				if($result = mysqli_store_result($conn)) {
					$row = mysqli_fetch_row($result);
					$insertID = $row[0];
				}
			} while(mysqli_next_result($conn));
		} else {
			$_SESSION['error1'] = 'Error: ' . $sql . '\n' . mysqli_error($conn);
			header('location: ../sign-in.php#sign-up');
			die();
		}

		$sql = 'INSERT INTO `user_activation` (`User_ID`, `Deactivation_Reason`) VALUES ("'.$insertID.'", "Account verification")';
		if(mysqli_query($conn, $sql)) {
			$_SESSION['success1'] = '';

			if ($userType == 1 || $userType == 3 ) {
				$sql = 'INSERT INTO `student_background` (`Personal_ID`) VALUES ("'.$userNo.'")';
				if(mysqli_query($conn, $sql)){
					$_SESSION['success1'] = '';
				} else {
					$_SESSION['error1'] = 'Error: ' . $sql . '\n' . mysqli_error($conn);
					header('location: ../sign-in.php#sign-up');
					die();
				}
			} 

		} else {
			$_SESSION['error1'] = 'Error: ' . $sql . '\n' . mysqli_error($conn);
			header('location: ../sign-in.php#sign-up');
			die();
		}

		$sql = 'INSERT INTO `registration`(`Personal_ID`, `Type`, `FName`, `LName`, `Email`, `Password`) VALUES ("'.$userNo.'", "'.$userType.'", "'.$fName.'",  "'.$lName.'", "'.$email.'", "'.$password.'")';

		if(mysqli_query($conn, $sql)){
			$_SESSION['success1'] = 'You have successfully registered!';
			header('location: ../sign-in.php#sign-up');
			die();
		} else {
			$_SESSION['error1'] = 'Error: ' . $sql . '\n' . mysqli_error($conn);
			header('location: ../sign-in.php#sign-up');
			die();
		}
	}

	mysqli_close($conn);
	header('location: ../sign-in.php#sign-up');

?>