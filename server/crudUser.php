<?php
	include 'dbconn.php';

	if(count($_POST) > 0) {
		$response = "";
		switch($_POST['type']) {
			case 1: // Check if email exists
				$email = mysqli_real_escape_string($conn, $_POST['email']);

				$sql = 'SELECT COUNT(*) AS "count"
					FROM `user`
					WHERE BINARY `Email` = BINARY "'.$email.'"';
				
				if($result = mysqli_query($conn, $sql)) {
					$row = mysqli_fetch_assoc($result);

					if((int)$row['count'] > 0)
						echo json_encode(array(true, true));
					else
						echo json_encode(array(true, false));
				} else
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 2: // Check if personal ID exists
				$ID = $_POST['ID'];
				$userType = $_POST['userType'];

				$sql = 'SELECT COUNT(*) AS "count"
					FROM `user`
					WHERE `Personal_ID` = "'.$ID.'" AND `Type` = '.$userType;
				
				if($result = mysqli_query($conn, $sql)) {
					$row = mysqli_fetch_assoc($result);

					if((int)$row['count'] > 0)
						echo json_encode(array(true, true));
					else
						echo json_encode(array(true, false));
				} else
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 3: // Check if email is pending
				$email = mysqli_real_escape_string($conn, $_POST['email']);

				$sql = 'SELECT COUNT(*) AS "count"
					FROM `registration`
					WHERE BINARY `Email` = BINARY "'.$email.'"';
				
				if($result = mysqli_query($conn, $sql)) {
					$row = mysqli_fetch_assoc($result);

					if((int)$row['count'] > 0)
						echo json_encode(array(true, true));
					else
						echo json_encode(array(true, false));
				} else
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 4: // New registration
				$ID = $_POST['ID'];
				$userType = $_POST['userType'];
				$fname = mysqli_real_escape_string($conn, $_POST['fname']);
				$lname = mysqli_real_escape_string($conn, $_POST['lname']);
				$email = mysqli_real_escape_string($conn, $_POST['email']);
				$password = $_POST['password'];
				$password = password_hash($password, PASSWORD_DEFAULT);

				$sql = 'INSERT INTO `registration` (`Personal_ID`, `Type`, `FName`, `LName`, `Email`, `Password`) VALUES ("'.$ID.'", '.$userType.', "'.$fname.'", "'.$lname.'", "'.$email.'", "'.$password.'")';
				
				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 5: // New user
				$regID = json_decode($_POST['regID'], true);
				$insertID = '';

				mysqli_begin_transaction($conn);

				try {
					foreach($regID as $insertUser) {
						$newStmt = mysqli_prepare($conn, 'INSERT INTO `user` (`Personal_ID`, `FName`, `MName`, `LName`, `Type`, `Phone`, `Role`, `Email`, `Pass`, `Img`) 
							SELECT `Personal_ID`, `FName`, NULL, `LName`, `Type`, NULL,
							CASE
								WHEN `Type` = 2 THEN 3
								ELSE NULL
							END AS `Role`, 
							`Email`, `Password`, "images/user/default.jpg" AS "Img"
							FROM `registration`
							WHERE `Reg_ID` = ?');
						mysqli_stmt_bind_param($newStmt, 'i', $insertUser);
						mysqli_stmt_execute($newStmt);
						$insertID .= '('.mysqli_stmt_insert_id($newStmt).'),';
					}
					
					$insertID = substr($insertID, 0, -1);

					$userActStmt = mysqli_prepare($conn, 'INSERT INTO `user_activation` (`User_ID`) VALUES '.$insertID);
					mysqli_stmt_execute($userActStmt);

					$userID = implode(',', $regID);
					$delStmt = mysqli_prepare($conn, 'DELETE FROM `registration` WHERE `Reg_ID` IN ('.$userID.')');
					mysqli_stmt_execute($delStmt);

					$email = mysqli_real_escape_string($conn, $_POST['email']);
					$subject = "Request Accepted | College of Computer and Information Sciences";
					
					$message = "<h1>Welcome to College of Computer and Information Sciences</h1>"; 
					$message .= "<p>Your registration has been accepted. You are now a registered user of the College of Computer and Information Sciences (CCIS) Website.</p>"; 
					$message .= "<p>You can now log in using your registered email: http://ccis. host/sign-in.php#log-in </p>"; 
			        $message .= '<p><strong>PLEASE REMOVE SPACES FROM THE LINK.</strong> This was added due to sending problems with the webhost.</p>'; 
			
					$headers = "From: noreply.ccis.pup@gmail.com\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
					$mailSent = mail($email, $subject, $message, $headers);
					if(!$mailSent) { 
						echo json_encode(array(false, 'Message could not be sent.'));
						exit();
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
			case 6: // Reject member request
				$regID = $_POST['regID'];

				mysqli_begin_transaction($conn);

				try {
					$delStmt = mysqli_prepare($conn, 'DELETE FROM `registration` WHERE `Reg_ID` IN ('.$regID.')');
					mysqli_stmt_execute($delStmt);

					$email = mysqli_real_escape_string($conn, $_POST['email']);
					$subject = "Request Rejected | College of Computer and Information Sciences";
					
					$message = "<h1>Your membership request has been rejected</h1>"; 
					$message .= "<p>We are sorry to inform you that your membership request for College of Computer and Information Sciences has been rejected.</p>"; 
			
					$headers = "From: noreply.ccis.pup@gmail.com\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
					$mailSent = mail($email, $subject, $message, $headers);
					if(!$mailSent) { 
						echo json_encode(array(false, 'Message could not be sent.'));
						exit;
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				break;
			case 7: // Change user role
				$userID = $_POST['userID'];
				$userRole = $_POST['userRole'];
				$personalID = $_POST['personalID'];
				$isExecute = false;

				if($userRole == '0')
					$userRole = 'NULL';

				mysqli_begin_transaction($conn);

				try {
					$updateStmt = mysqli_prepare($conn, 'UPDATE `user` SET `Role` = ? WHERE `User_ID` = ?');
					mysqli_stmt_bind_param($updateStmt, 'ii', $userRole, $userID);
					mysqli_stmt_execute($updateStmt);

					$delStmt = mysqli_prepare($conn, 'DELETE FROM `student_org` WHERE `Personal_ID` = ?');
					mysqli_stmt_bind_param($delStmt, 's', $personalID);
					mysqli_stmt_execute($delStmt);
					
					if($userRole == '5') {
						$org = $_POST['org'];

						$orgStmt = mysqli_prepare($conn, 'INSERT INTO `student_org` (`Personal_ID`, `stud_org`) VALUES (?, ?)');
						mysqli_stmt_bind_param($orgStmt, 'si', $personalID, $org);
						mysqli_stmt_execute($orgStmt);
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
			case 8: // Remove admin
				$userID = $_POST['userID'];
				$personalID = $_POST['personalID'];

				mysqli_begin_transaction($conn);

				try {
					$updateStmt = mysqli_prepare($conn, 'UPDATE `user` SET `Role` = NULL WHERE `User_ID` IN ('.$userID.')');
					mysqli_stmt_execute($updateStmt);

					$delStmt = mysqli_prepare($conn, 'DELETE FROM `student_org` WHERE `Personal_ID` IN ('.$personalID.')');
					mysqli_stmt_execute($delStmt);

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
			case 9: // Select users not admin
				$userType = $_POST['userType'];
				$search = $_POST['search'];
				$page = (int)$_POST['page'];
				$rows = (int)$_POST['rows'];
				$offset = ($page - 1) * $rows;

				$sql = 'SELECT `user`.`User_ID`, `user`.`Personal_ID`, `user`.`Img`, `user`.`Type`, CONCAT(`user`.`LName`, ", ", `user`.`FName`) AS "User_Full", `user_type`.`Type_Desc`
					FROM `user`
					JOIN `user_activation` ON `user`.`User_ID` = `user_activation`.`User_ID`
					JOIN `user_type` ON `user`.`Type` = `user_type`.`Type_ID`
					WHERE `user_activation`.`Activated` = 1 AND `user`.`Role` IS NULL ';

				if($userType != '0')
					$sql .= 'AND `user`.`Type` IN ('.$userType.') ';

				if(!empty($search))
					$sql .= 'AND (`user`.`Personal_ID` LIKE "%'.$search.'%" OR CONCAT(`FName`, " ", `LName`) LIKE "%'.$search.'%" OR CONCAT(`LName`, ", ", `FName`) LIKE "%'.$search.'%") ';

				$sql .= 'ORDER BY `user`.`LName`
					LIMIT '.$offset.', '.$rows;
				
				if($result = mysqli_query($conn, $sql)) {
					$userarray = array();
					while($row = mysqli_fetch_assoc($result)) {
						// assign fetched row to array
						$userarray[] = $row;
					}

					echo json_encode(array(true, $userarray));
				} else
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 10: // Select count of users not admin
				$userType = $_POST['userType'];
				$search = $_POST['search'];

				$sql = 'SELECT COUNT(*) AS "count"
					FROM `user`
					JOIN `user_activation` ON `user`.`User_ID` = `user_activation`.`User_ID`
					JOIN `user_type` ON `user`.`Type` = `user_type`.`Type_ID`
					WHERE `user_activation`.`Activated` = 1 AND `user`.`Role` IS NULL ';

				if($userType != '0')
					$sql .= 'AND `user`.`Type` IN ('.$userType.') ';
				
				if(!empty($search))
					$sql .= 'AND (`user`.`Personal_ID` LIKE "%'.$search.'%" OR CONCAT(`FName`, " ", `LName`) LIKE "%'.$search.'%" OR CONCAT(`LName`, ", ", `FName`) LIKE "%'.$search.'%") ';

				if($result = mysqli_query($conn, $sql)) {
					$row = mysqli_fetch_assoc($result);
					echo json_encode(array(true, $row['count']));
				} else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 11: // Update role of multiple users
				$userList = json_decode($_POST['userList'], true);
				$isExecute = false;

				mysqli_begin_transaction($conn);

				try {
					$updateSql = 'UPDATE `user`
						SET `Role` = (
							CASE ';
						
					for($i = 0; $i < count($userList); $i++)
						$updateSql .= 'WHEN `User_ID` = '.$userList[$i]['userID'].' THEN '.$userList[$i]['userRole'].' ';

					$updateSql .=	'END
						)
						WHERE `User_ID` IN (';
					
					for($i = 0; $i < count($userList); $i++)
						$updateSql .= $userList[$i]['userID'].',';
					
					$updateSql = substr($updateSql, 0, -1).')';
					
					$updateStmt = mysqli_prepare($conn, $updateSql);
					mysqli_stmt_execute($updateStmt);

					$delSql = 'DELETE FROM `student_org` WHERE `Personal_ID` IN (';
					
					for($i = 0; $i < count($userList); $i++)
						$delSql .= '"'.$userList[$i]['personalID'].'",';
					
					$delSql = substr($delSql, 0, -1).')';

					$delStmt = mysqli_prepare($conn, $delSql);
					mysqli_stmt_execute($delStmt);

					$hasOrg = false;

					foreach($userList as $item) {
						if(isset($item['userRole']) && $item['userRole'] == '5') {
							$hasOrg = true;
							break;
						}
					}

					if($hasOrg) {
						$orgSql = 'INSERT INTO `student_org` (`Personal_ID`, `stud_org`) VALUES ';
							
						for($i = 0; $i < count($userList); $i++) {
							if($userList[$i]['userRole'] == '5') {
								$orgSql .= '("'.$userList[$i]['personalID'].'", '.$userList[$i]['org'].'),';
							}
						}
		
						$orgSql = substr($orgSql, 0, -1);

						$orgStmt = mysqli_prepare($conn, $orgSql);
						mysqli_stmt_execute($orgStmt);
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
			case 12: // Deactivate user
				$userID = $_POST['userID'];
				$deactReason = mysqli_real_escape_string($conn, $_POST['deactReason']);
				$deactDetail = mysqli_real_escape_string($conn, $_POST['deactDetail']);
				$deactDetail = preg_replace('/\s+/', ' ', $deactDetail) == '' ? null : $deactDetail;

				mysqli_begin_transaction($conn);

				try {
					$updateStmt = mysqli_prepare($conn, 'UPDATE `user_activation`
						SET `Activated` = 0, `Deactivation_Date` = NOW(), `Deactivation_Reason` = ?, `Deactivation_Detail` = ?
						WHERE `User_ID` IN ('.$userID.')');
					mysqli_stmt_bind_param($updateStmt, 'ss', $deactReason, $deactDetail);
					mysqli_stmt_execute($updateStmt);

					$email = mysqli_real_escape_string($conn, $_POST['userEmail']);
					$subject = "Account Deactivated | College of Computer and Information Sciences";
					
					$message = "<h1>Your account has been deactivated</h1>"; 
					$message .= "<p>The deactivation was due to the following reason: <strong>".$deactReason."</strong></p>";
					
					if(!empty($deactDetail))
						$message .= "<p>Detail: ".$deactDetail."</p>";

					$message .= "<p><br/><br/>To request for the reactivation of your account, log in to the website using your email address and password: http://ccis. host/sign-in.php#log-in </p>"; 
			        $message .= '<p><strong>PLEASE REMOVE SPACES FROM THE LINK.</strong> This was added due to sending problems with the webhost.</p>'; 

					$headers = "From: noreply.ccis.pup@gmail.com\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
					$mailSent = mail($email, $subject, $message, $headers);
					if(!$mailSent) { 
						echo json_encode(array(false, 'Message could not be sent.'));
						exit;
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
			case 13: // Reactivate user
				$userID = $_POST['userID'];

				mysqli_begin_transaction($conn);

				try {
					$updateStmt = mysqli_prepare($conn, 'UPDATE `user_activation`
						SET `Activated` = 1, `Deactivation_Date` = NULL, `Deactivation_Reason` = NULL, `Deactivation_Detail` = NULL
						WHERE `User_ID` IN ('.$userID.')');
					mysqli_stmt_execute($updateStmt);

					$delStmt = mysqli_prepare($conn, 'DELETE FROM `reactivate_req` WHERE `user_ID` IN ('.$userID.')');
					mysqli_stmt_execute($delStmt);

					$email = mysqli_real_escape_string($conn, $_POST['userEmail']);
					$subject = "Account Reactivated | College of Computer and Information Sciences";
					
					$message = "<h1>Your account has been reactivated</h1>"; 
					$message .= "<p>Welcome back! Your reactivation request has been accepted.</p>"; 
					$message .= "<p>You can now log in using your registered email: http://ccis. host/sign-in.php#log-in </p>"; 
			        $message .= '<p><strong>PLEASE REMOVE SPACES FROM THE LINK.</strong> This was added due to sending problems with the webhost.</p>'; 

					$headers = "From: noreply.ccis.pup@gmail.com\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
					$mailSent = mail($email, $subject, $message, $headers);
					if(!$mailSent) { 
						echo json_encode(array(false, 'Message could not be sent.'));
						exit;
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
			case 14: // Create reactivation request
				$userID = $_POST['userID'];

				$sql = 'REPLACE INTO `reactivate_req` (`user_ID`, `req_date`) VALUES ('.$userID.', NOW())';

				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 15: // Delete reactivation request
				$userID = $_POST['userID'];

				mysqli_begin_transaction($conn);

				try {
					$delStmt = mysqli_prepare($conn, 'DELETE FROM `reactivate_req` WHERE `user_ID` IN ('.$userID.')');
					mysqli_stmt_execute($delStmt);

					$email = mysqli_real_escape_string($conn, $_POST['userEmail']);
					$subject = "Reactivation Rejected | College of Computer and Information Sciences";
					
					$message = "<h1>Your reactivation request has been rejected</h1>"; 
					$message .= "<p>We are sorry to inform you that your reactivation request for your account in College of Computer and Information Sciences has been rejected.</p>"; 

					$headers = "From: noreply.ccis.pup@gmail.com\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
					$mailSent = mail($email, $subject, $message, $headers);
					if(!$mailSent) { 
						echo json_encode(array(false, 'Message could not be sent.'));
						exit;
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
			case 16: // Update user information
				$userID = $_POST['userID'];
				$personalID = mysqli_real_escape_string($conn, $_POST['personalID']);

				if(!isset($_POST['mname']) || empty($_POST['mname']))
					$mname = null;
				else
					$mname = mysqli_real_escape_string($conn, $_POST['mname']);

				$sex = mysqli_real_escape_string($conn, $_POST['sex']);
				$bday = mysqli_real_escape_string($conn, $_POST['bday']);
				$bdayShow = $_POST['bdayShow'];
				$email = mysqli_real_escape_string($conn, $_POST['email']);
				$emailShow = $_POST['emailShow'];
				$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
				$mobileShow = $_POST['mobileShow'];

				if(!isset($_POST['phone']) || empty($_POST['phone']))
					$phone = null;
				else
					$phone = mysqli_real_escape_string($conn, $_POST['phone']);

				$phoneShow = $_POST['phoneShow'];

				mysqli_begin_transaction($conn);

				try {
					$updateStmt = mysqli_prepare($conn, 'UPDATE `user` SET `MName` = ?, `Sex` = ?, `Bday` = ?, `is_bday_show` = ?, `Mobile` = ?,`is_mobile_show` = ?, `Phone` = ?, `is_phone_show` = ?, `Email` = ?, `is_email_show` = ? WHERE `User_ID` = '.$userID);
					mysqli_stmt_bind_param($updateStmt, 'sssisisisi', $mname, $sex, $bday, $bdayShow, $mobile, $mobileShow, $phone, $phoneShow, $email, $emailShow);
					mysqli_stmt_execute($updateStmt);

					if(isset($_POST['add']) && !empty($_POST['add'])) {
						$userType = $_POST['userType'];
						$add = mysqli_real_escape_string($conn, $_POST['add']);
						$addShow = $_POST['addShow'];

						if($userType == '1') {
							$admitYr = '';
							$gradYr = substr($personalID, 5, 4);
						} else {
							$admitYr = substr($personalID, 0, 4);
							$gradYr = null;
						}
						
						$addStmt = mysqli_prepare($conn, 'INSERT INTO `student_background` (`Personal_ID`, `Address`, `is_address_show`, `Admit_Yr`, `Grad_Yr`) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `Address` = ?, `is_address_show` = ?');
						mysqli_stmt_bind_param($addStmt, 'ssisssi', $personalID, $add, $addShow, $admitYr, $gradYr, $add, $addShow);
						mysqli_stmt_execute($addStmt);
					}
					
					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 17: // Update student background
				$personalID = mysqli_real_escape_string($conn, $_POST['personalID']);
				$admitStatus = mysqli_real_escape_string($conn, $_POST['admitStatus']);
				$admitAs = mysqli_real_escape_string($conn, $_POST['admitAs']);
				$course = mysqli_real_escape_string($conn, $_POST['course']);

				if(!isset($_POST['college']) || empty($_POST['college'])) {
					$college = 'NULL';
					$collegeYr = 'NULL';
					$collegeCourse = 'NULL';
				} else {
					$college = '"'.mysqli_real_escape_string($conn, $_POST['college']).'"';
					$collegeYr = '"'.mysqli_real_escape_string($conn, $_POST['collegeYr']).'"';
					$collegeCourse = '"'.mysqli_real_escape_string($conn, $_POST['collegeCourse']).'"';
				}

				$hs = mysqli_real_escape_string($conn, $_POST['hs']);
				$hsYr = mysqli_real_escape_string($conn, $_POST['hsYr']);
				$elem = mysqli_real_escape_string($conn, $_POST['elem']);
				$elemYr = mysqli_real_escape_string($conn, $_POST['elemYr']);

				if(!isset($_POST['admitYr']) || empty($_POST['admitYr'])) {
					$userType = $_POST['userType'];
					$admitYr = substr($personalID, 0, 4);

					$sql = 'INSERT INTO `student_background` (`Personal_ID`, `Admit_Status`, `Admit_Yr`, `Admit_As`, `Grad_Yr`, `Course`, `College`, `College_Yr`, `College_Course`, `HS`, `HS_Yr`, `Elem`, `Elem_Yr`) VALUES ("'.$personalID.'", "'.$admitStatus.'", "'.$admitYr.'", "'.$admitAs.'", NULL, "'.$course.'", '.$college.', '.$collegeYr.', '.$collegeCourse.', "'.$hs.'", "'.$hsYr.'", "'.$elem.'", "'.$elemYr.'")
						ON DUPLICATE KEY UPDATE 
							`Admit_Status` = "'.$admitStatus.'", `Admit_Yr` = "'.$admitYr.'", `Admit_As` = "'.$admitAs.'", `Grad_Yr` = NULL, `Course` = "'.$course.'", `College` = '.$college.', `College_Yr` = '.$collegeYr.', `College_Course` = '.$collegeCourse.', `HS` = "'.$hs.'", `HS_Yr` = "'.$hsYr.'", `Elem` = "'.$elem.'", `Elem_Yr` = '.$elemYr;
				} else {
					$admitYr = mysqli_real_escape_string($conn, $_POST['admitYr']);
					$gradYr = substr($personalID, 5, 4);

					$sql = 'INSERT INTO `student_background` (`Personal_ID`, `Admit_Status`, `Admit_Yr`, `Admit_As`, `Grad_Yr`, `Course`, `College`, `College_Yr`, `College_Course`, `HS`, `HS_Yr`, `Elem`, `Elem_Yr`) VALUES ("'.$personalID.'", "'.$admitStatus.'", "'.$admitYr.'", "'.$admitAs.'", "'.$gradYr.'", "'.$course.'", '.$college.', '.$collegeYr.', '.$collegeCourse.', "'.$hs.'", "'.$hsYr.'", "'.$elem.'", "'.$elemYr.'")
						ON DUPLICATE KEY UPDATE 
							`Admit_Status` = "'.$admitStatus.'", `Admit_Yr` = "'.$admitYr.'", `Admit_As` = "'.$admitAs.'", `Grad_Yr` = "'.$gradYr.'", `Course` = "'.$course.'", `College` = '.$college.', `College_Yr` = '.$collegeYr.', `College_Course` = '.$collegeCourse.', `HS` = "'.$hs.'", `HS_Yr` = "'.$hsYr.'", `Elem` = "'.$elem.'", `Elem_Yr` = '.$elemYr;
				}

				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 18: // Change user image 
				$userID = $_POST['userID'];
				$userImg = mysqli_real_escape_string($conn, $_POST['userImg']);

				$uploadLoc = '../images/user/'.$userID;
				
				if(!file_exists($uploadLoc))
					mkdir($uploadLoc, 0777, true);
				
				if(preg_match('/^data:image\/(\w+);base64,/', $userImg, $type)) {
					$userImg = substr($userImg, strpos($userImg, ',') + 1);
					$type = strtolower($type[1]); // jpg, png, gif
					
					if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
						echo json_encode(array(false, 'Invalid image type'));
						exit;
					}
			
					$userImg = str_replace( ' ', '+', $userImg );
					$userImg = base64_decode($userImg);
					
					if($userImg === false) {
						echo json_encode(array(false, 'Error: base64_decode failed'));
						exit;
					}
				} else {
					echo json_encode(array(false, 'Error: Did not match data URI with image data'));
					exit;
				}

				$imgFile = $uploadLoc.'/'.$userID.'.'.$type;
				
				if(file_exists($imgFile))
					unlink($imgFile);

				file_put_contents($imgFile, $userImg);

				$sql = 'UPDATE `user` SET `Img` = "'.substr($imgFile, 3).'" WHERE `User_ID` = '.$userID;
				
				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 19: // Change password
				$userID = $_POST['userID'];
				$curPass = $_POST['curPass'];
				$newPass = $_POST['newPass'];

				$sql = 'SELECT `Pass` FROM `user` WHERE `User_ID` = '.$userID;

				if($result = mysqli_query($conn, $sql)) {
					$row = mysqli_fetch_assoc($result);
		
					if(password_verify($curPass, $row['Pass'])) {
						$password = password_hash($newPass, PASSWORD_DEFAULT);

						if($curPass == $newPass) {
							echo json_encode(array(false, true, 'match'));
						} else {
							$changeSql = 'UPDATE `user` SET `PASS` = "'.$password.'" WHERE `User_ID` = '.$userID;
							
							if(mysqli_query($conn, $changeSql))
								echo json_encode(array(true));
							else 
								echo json_encode(array(false, false, 'Error: ' . $changeSql . '\n' . mysqli_error($conn)));
						}
					} else
						echo json_encode(array(false, true, 'incorrect'));
				} else
					echo json_encode(array(false, false,'Error: ' . $sql . '\n' . mysqli_error($conn)));
				
				break;
			case 20: // Deactivate own account
				$userID = $_POST['userID'];
				$pass = $_POST['pass'];

				$sql = 'SELECT `Pass` FROM `user` WHERE `User_ID` = '.$userID;
				if($result = mysqli_query($conn, $sql)) {
					$row = mysqli_fetch_assoc($result);
		
					if(password_verify($pass, $row['Pass'])) {
						$deactSql = 'UPDATE `user_activation`
							SET `Activated` = 0, `Deactivation_Date` = NOW(), `Deactivation_Reason` = "User Deactivated", `Deactivation_Detail` = NULL 
								WHERE `User_ID` = '.$userID;

						if(mysqli_query($conn, $deactSql))
							echo json_encode(array(true));
						else 
							echo json_encode(array(false, false, 'Error: ' . $deactSql . '\n' . mysqli_error($conn)));
					} else
						echo json_encode(array(false, true));
				} else
					echo json_encode(array(false, false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
				
				break;
		}
	}

	mysqli_close($conn);
?>