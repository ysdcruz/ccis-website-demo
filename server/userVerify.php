<?php
	include 'dbconn.php';
	session_start();

	if(isset($_SESSION['user']) || isset($_SESSION['user']))
		header('location:../sign-in.php');
	
	if(count($_POST) > 0) {
		$email = $_POST['email'];
		$password = $_POST['password'];

		$sql = 'SELECT `user`.*, `user_activation`.`Activated`
			FROM `user`
			LEFT JOIN `user_activation` ON `user`.`User_ID` = `user_activation`.`User_ID`
			WHERE BINARY `user`.`Email` = BINARY "'.$email.'"';

		if($result = mysqli_query($conn, $sql)) {
			$row = mysqli_fetch_assoc($result);

			if(mysqli_num_rows($result) > 0) {
				if(password_verify($password, $row['Pass'])) {
					if($row['Activated']) {
						if($row['Role'] > 0)
							$_SESSION['admin'] = $row['User_ID'];
						else
							$_SESSION['user'] = $row['User_ID'];
						
						$fname = strtolower(substr(preg_replace('/\s+/', '', $row['FName']), 0, 1));
						$lname = strtolower(preg_replace('/\s+/', '', $row['LName']));
						$_SESSION['username'] = $fname.$lname;

						echo json_encode(array(true));
					} else
						echo json_encode(array(true, true, $row['User_ID']));
				} else
					echo json_encode(array(true, false));
			}
		} else
			echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
	}

	mysqli_close($conn);
?>