<?php
	include 'dbconn.php';
	session_start();

	if(count($_POST) > 0) {
		switch($_POST['type']) {
			case 1: // create report
				$userID = $_POST['userID'];
				$threadID = $_POST['threadID'];
				$replyID = $_POST['replyID'];
				$postVer = $_POST['postVer'];
				$reportReason = mysqli_real_escape_string($conn, $_POST['reportReason']);
				$reportDesc = mysqli_real_escape_string($conn, $_POST['reportDesc']);

				if(!isset($_POST['replyID']) || empty($_POST['replyID']))
					$replyID = 'NULL';

				if(!isset($_POST['reportDesc']) || empty($_POST['reportDesc']))
					$reportDesc = 'NULL';
				else
					$reportDesc = '"'.$reportDesc.'"';

				$sql = 'INSERT INTO `reports` (`Report_Date`, `Report_By`, `Thread_ID`, `Reply_ID`, `Post_Ver`, `Report_Reason`, `Report_Desc`) VALUES (NOW(), '.$userID.', '.$threadID.', '.$replyID.', '.$postVer.', "'.$reportReason.'", '.$reportDesc.')';
					
				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 2: // select report
				$threadID = $_POST['threadID'];
				$replyID = $_POST['replyID'];

				$sql = 'SELECT `reports`.*, DATE_FORMAT(`Report_Date`, "%M %e, %Y") AS "Report", `user`.`Img`, CONCAT(`user`.`FName`, " ", `user`.`LName`) AS "report_author"
					FROM `reports`
					LEFT JOIN `user` ON `reports`.`Report_By` = `user`.`User_ID` 
					WHERE `Thread_ID` = '.$threadID;

				if($replyID != '0')
					$sql .= ' AND `Reply_ID` = '.$replyID;
				else
					$sql .= ' AND `Reply_ID` IS NULL';
					
				if($result = mysqli_query($conn, $sql)) {
					$reportarray = array();
					while($row = mysqli_fetch_assoc($result)) {
						// assign fetched row to array
						$reportarray[] = $row;
					}
					
					echo json_encode(array(true, $reportarray));
				} else
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
				
				break;
			case 3: // delete report & thread/reply
				$threadID = $_POST['threadID'];
				$replyID = $_POST['replyID'];
				$postVer = $_POST['postVer'];
				$reportReason = mysqli_real_escape_string($conn, $_POST['reportReason']);
				$userID = $_SESSION['admin'];

				mysqli_begin_transaction($conn);

				try {
					if($replyID == '0') {
						$delReportStmt = mysqli_prepare($conn, 'DELETE FROM `reports` WHERE `Thread_ID` = '.$threadID);
						mysqli_stmt_execute($delReportStmt);

						$backThreadStmt = mysqli_prepare($conn, 'INSERT INTO `thread_backup` (`thread_ID`, `action_user_ID`, `cat_ID`, `thread_author_ID`, `thread_create`, `thread_update`, `thread_title`, `thread_content`, `thread_type`, `thread_to`, `thread_open`, `thread_upvotes`, `delete_reason`, `delete_desc`)
							SELECT `thread`.`thread_ID`, '.$userID.', `cat_ID`, `thread_author_ID`, `thread_create`, `event_date`, `thread_title`, `thread_content`, `thread_type`, `thread_to`, `thread_open`, `thread_upvotes`, "'.$reportReason.'" AS "delete_reason", NULL
							FROM `thread`
							JOIN (
								SELECT `thread_history`.`thread_ID`, `event_date`, `thread_title`, `thread_content`
								FROM `thread_history`
								WHERE `thread_history`.`thread_ver` = '.$postVer.'
							) history ON `thread`.`thread_ID` = history.`thread_ID` 
							WHERE `thread`.`thread_ID` = '.$threadID);
						mysqli_stmt_execute($backThreadStmt);
	
						$replyCtrStmt = mysqli_prepare($conn, 'SELECT COUNT(*) AS "count" FROM `reply` WHERE `thread_ID` = '.$threadID);
						mysqli_stmt_execute($replyCtrStmt);
						$result = mysqli_stmt_get_result($replyCtrStmt);
						$row = mysqli_fetch_array($result);
						$replyCtr = (int)$row['count'];
	
						if($replyCtr > 0) {
							$backReplyStmt = mysqli_prepare($conn, 'INSERT INTO `reply_backup` (`reply_ID`, `thread_ID`, `action_user_ID`, `reply_author_ID`, `reply_create`, `reply_update`, `reply_content`, `reply_upvotes`, `is_answer`, `delete_reason`, `delete_desc`)
								SELECT `reply`.`reply_ID`, `thread_ID`, '.$userID.', `reply_author_ID`, `reply_create`, `event_date`, `reply_content`, `reply_upvotes`, `is_answer`, "thread reported and deleted" AS "delete_reason", NULL
								FROM `reply`
								JOIN (
									SELECT content.`reply_ID`, `event_date`, `reply_content` 
									FROM `reply_history` content
									INNER JOIN (
										SELECT `reply_ID`, MAX(`reply_ver`) AS "latest_ver"
										FROM `reply_history`
										GROUP BY `reply_ID`
									) ver ON content.`reply_ID` = ver.`reply_ID` AND content.`reply_ver` = ver.`latest_ver`
								) history ON `reply`.`reply_ID` = history.`reply_ID` 
								WHERE `reply`.`thread_ID` = '.$threadID);
							mysqli_stmt_execute($backReplyStmt);
						}
	
						$delThreadStmt = mysqli_prepare($conn, 'DELETE FROM `thread` WHERE `thread_ID` = '.$threadID);
						mysqli_stmt_execute($delThreadStmt);
					} else {
						$delReportStmt = mysqli_prepare($conn, 'DELETE FROM `reports` WHERE `Thread_ID` = '.$threadID.' AND `Reply_ID` = '.$replyID);
						mysqli_stmt_execute($delReportStmt);

						$backReplyStmt = mysqli_prepare($conn, 'INSERT INTO `reply_backup` (`reply_ID`, `thread_ID`, `action_user_ID`, `reply_author_ID`, `reply_create`, `reply_update`, `reply_content`, `reply_upvotes`, `is_answer`, `delete_reason`, `delete_desc`)
							SELECT `reply`.`reply_ID`, `thread_ID`, '.$userID.', `reply_author_ID`, `reply_create`, `event_date`, `reply_content`, `reply_upvotes`, `is_answer`, "'.$reportReason.'" AS "delete_reason", NULL
							FROM `reply`
							JOIN (
								SELECT `reply_ID`, `reply_ver`, `event_date`, `reply_content` 
								FROM `reply_history`
							) history ON `reply`.`reply_ID` = history.`reply_ID` AND history.`reply_ver` = '.$postVer.'
							WHERE `reply`.`reply_ID` = '.$replyID);
						mysqli_stmt_execute($backReplyStmt);
	
						$delReplyStmt = mysqli_prepare($conn, 'DELETE FROM `reply` WHERE `reply_ID` = '.$replyID);
						mysqli_stmt_execute($delReplyStmt);
					}
					
					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 4: // delete reports of post
				$threadID = $_POST['threadID'];
				$replyID = $_POST['replyID'];

				$sql = 'DELETE FROM `reports` WHERE `Thread_ID` = '.$threadID.' AND `Reply_ID` '.($replyID == '0' ? 'IS NULL' : ' = '.$replyID);

				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
		}
	}
	mysqli_close($conn);
?>