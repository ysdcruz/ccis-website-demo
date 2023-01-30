<?php
	include 'dbconn.php';
	session_start();

	if(count($_POST) > 0) {
		switch($_POST['type']) {
			case 1: // create thread
				$userID = $_POST['userID'];
				$threadCategory = $_POST['catID'];
				$threadTitle = mysqli_real_escape_string($conn, $_POST['threadTitle']);
				$threadContent = mysqli_real_escape_string($conn, $_POST['threadContent']);
				$threadType = $_POST['threadType'];
				$threadTo = $_POST['threadTo'];
				$threadTags = json_decode($_POST['threadTags'], true);
				$img = json_decode($_POST['imgSrc'], true);

				$insertID;
				$cleanTag = [];
				$tags = '';
				$newTags = '';
				$hasTag = true;

				if(empty($threadTags))
					$hasTag = false;
				else {
					foreach($threadTags AS $value)
						$cleanTag[] = mysqli_real_escape_string($conn, $value);

					$tags = '"'.implode('","', $threadTags).'"';
					$newTags = '("'.implode('"),("', $threadTags).'")';
				}
				
				mysqli_begin_transaction($conn);

				try {
					$dateStmt = mysqli_prepare($conn, 'SELECT NOW() AS "datenow"');
					mysqli_stmt_execute($dateStmt);
					$result = mysqli_stmt_get_result($dateStmt);
					$row = mysqli_fetch_array($result);
					$postDate = $row['datenow'];

					$threadStmt = mysqli_prepare($conn, 'INSERT INTO `thread` (`thread_author_ID`, `cat_ID`, `thread_create`, `thread_type`, `thread_to`, `thread_open`, `thread_upvotes`) VALUES (?, ?, ?, ?, ?, 1, 0)');
					mysqli_stmt_bind_param($threadStmt, 'iisss', $userID, $threadCategory, $postDate, $threadType, $threadTo);
					mysqli_stmt_execute($threadStmt);
					$insertID = mysqli_stmt_insert_id($threadStmt);

					$contentStmt = mysqli_prepare($conn, 'INSERT INTO `thread_history` (`thread_ID`, `thread_ver`, `event_date`, `thread_title`, `thread_content`) VALUES ('.$insertID.', 1, ?, ?, ?)');
					mysqli_stmt_bind_param($contentStmt, 'sss', $postDate, $threadTitle, $threadContent);
					mysqli_stmt_execute($contentStmt);

					if($hasTag) {
						$newTagStmt = mysqli_prepare($conn, 'INSERT INTO `tags` (`tag_Name`) VALUES '.$newTags.' ON DUPLICATE KEY UPDATE `tag_Name` = `tag_Name`');
						mysqli_stmt_execute($newTagStmt);

						$tagStmt = mysqli_prepare($conn,  'INSERT INTO `thread_tags`(`thread_ID`, `tag_ID`)
							SELECT '.$insertID.', `tags`.`tag_ID`
							FROM `tags`
							WHERE `tag_Name` IN ('.$tags.')');
						mysqli_stmt_execute($tagStmt);
					}

					if(!empty($img)) {
						$uploadLoc = '../images/thread/'.$insertID;
						$imgarray = array();
	
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
	
						foreach($img as $data) {
						    $imgFile;
						    
							if(substr($data, 0, 4) === 'http') {
								$type = pathinfo(explode('?', $data)[0], PATHINFO_EXTENSION);
								$data = file_get_contents($data);
								$data = 'data:image/' . $type . ';base64,' . base64_encode($data);
							}

							if(preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
								$data = substr($data, strpos($data, ',') + 1);
								$type = strtolower($type[1]); // jpg, png, gif
							
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
					
								$data = str_replace( ' ', '+', $data );
								$data = base64_decode($data);
							
								if($data === false) {
									echo json_encode(array(false, 'Error: base64_decode failed'));
									exit;
								}
							} else {
								echo json_encode(array(false, 'Error: Did not match data URI with image data'));
								exit;
							}
					
							while(true) {
								$imgFile = $uploadLoc.'/'.uniqid(date('Ymd').'-', true).'.'.$type;
								
								if(!file_exists($imgFile)) 
									break;
							}
							$imgarray[] = $imgFile;
					
							file_put_contents($imgFile, $data);
						}
						
						$imgSql = 'INSERT INTO `thread_img` (`thread_ID`, `thread_ver`, `img_path`) VALUES ';

						foreach($imgarray as $imgSrc) {
							$imgSrc = substr($imgSrc, 3);
							$imgSql .= '('.$insertID.', 1, "'.$imgSrc.'"),';
						}
						
						$imgSql = substr($imgSql, 0, -1);

						$imgStmt = mysqli_prepare($conn,  $imgSql);
						mysqli_stmt_execute($imgStmt);
					}

					mysqli_commit($conn);
					echo json_encode(array(true, $insertID));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 2: // update thread
				$threadID = $_POST['threadID'];
				$threadCategory = $_POST['catID'];
				$threadTitle = mysqli_real_escape_string($conn, $_POST['threadTitle']);
				$threadContent = mysqli_real_escape_string($conn, $_POST['threadContent']);
				$threadType = $_POST['threadType'];
				$threadTo = $_POST['threadTo'];
				$threadTags = json_decode($_POST['threadTags'], true);
				$hasContentChanged = $_POST['hasContentChanged'];
				$img = json_decode($_POST['imgSrc'], true);

				$cleanTag = [];
				$tags = '';
				$newTags = '';
				$hasTag = true;

				if(empty($threadTags))
					$hasTag = false;
				else {
					foreach($threadTags AS $value)
						$cleanTag[] = mysqli_real_escape_string($conn, $value);

					$tags = '"'.implode('","', $threadTags).'"';
					$newTags = '("'.implode('"),("', $threadTags).'")';
				}

				mysqli_begin_transaction($conn);

				try {
					if($hasContentChanged == 'true') {
						$dateStmt = mysqli_prepare($conn, 'SELECT NOW() AS "datenow"');
						mysqli_stmt_execute($dateStmt);
						$result = mysqli_stmt_get_result($dateStmt);
						$row = mysqli_fetch_array($result);
						$postDate = $row['datenow'];

						$verStmt = mysqli_prepare($conn, 'SELECT MAX(`thread_ver`) AS "latest_ver" FROM `thread_history` WHERE `thread_ID` = '.$threadID);
						mysqli_stmt_execute($verStmt);
						$result = mysqli_stmt_get_result($verStmt);
						$row = mysqli_fetch_array($result);
						$latestVer = (int)$row['latest_ver'] + 1;

						$contentStmt = mysqli_prepare($conn, 'INSERT INTO `thread_history` (`thread_ID`, `thread_ver`, `event_date`, `thread_title`, `thread_content`) VALUES ('.$threadID.', ?, ?, ?, ?)');
						mysqli_stmt_bind_param($contentStmt, 'isss', $latestVer, $postDate, $threadTitle, $threadContent);
						mysqli_stmt_execute($contentStmt);

						if(!empty($img)) {
							$uploadLoc = '../images/thread/'.$threadID;
							$imgarray = array();
		
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
		
							foreach($img as $data) {
    						    $imgFile;
    						    
								if(substr($data, 0, 4) === 'http') {
									$type = pathinfo(explode('?', $data)[0], PATHINFO_EXTENSION);
									$data = file_get_contents($data);
									$data = 'data:image/' . $type . ';base64,' . base64_encode($data);
								}
	
								if(preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
									$data = substr($data, strpos($data, ',') + 1);
									$type = strtolower($type[1]); // jpg, png, gif
								
									if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
										echo json_encode(array(false, 'Invalid image type'));
										exit;
									}
						
									$data = str_replace( ' ', '+', $data );
									$data = base64_decode($data);
								
									if($data === false) {
										echo json_encode(array(false, 'Error: base64_decode failed'));
										exit;
									}
								} else {
									echo json_encode(array(false, 'Error: Did not match data URI with image data'));
									exit;
								}
						
								while(true) {
									$imgFile = $uploadLoc.'/'.uniqid(date('Ymd').'-' , true).'.'.$type;
									
									if(!file_exists($imgFile)) 
										break;
								}
								$imgarray[] = $imgFile;
						
								file_put_contents($imgFile, $data);
							}
							
							$imgSql = 'INSERT INTO `thread_img` (`thread_ID`, `thread_ver`, `img_path`) VALUES ';
	
							foreach($imgarray as $imgSrc) {
								$imgSrc = substr($imgSrc, 3);
								$imgSql .= '('.$threadID.', '.$latestVer.', "'.$imgSrc.'"),';
							}
							
							$imgSql = substr($imgSql, 0, -1);
	
							$imgStmt = mysqli_prepare($conn,  $imgSql);
							mysqli_stmt_execute($imgStmt);
						}
					}

					$threadStmt = mysqli_prepare($conn, 'UPDATE `thread` SET `cat_ID` = ?, `thread_type` = ?, `thread_to` = ? WHERE `thread_ID` = '.$threadID);
					mysqli_stmt_bind_param($threadStmt, 'iss', $threadCategory, $threadType, $threadTo);
					mysqli_stmt_execute($threadStmt);

					if($hasTag) {
						$delTagStmt = mysqli_prepare($conn, 'DELETE FROM `thread_tags` WHERE `thread_ID` = '.$threadID);
						mysqli_stmt_execute($delTagStmt);
						
						$newTagStmt = mysqli_prepare($conn, 'INSERT INTO `tags` (`tag_Name`) VALUES '.$newTags.' ON DUPLICATE KEY UPDATE `tag_Name` = `tag_Name`');
						mysqli_stmt_execute($newTagStmt);

						$tagStmt = mysqli_prepare($conn,  'INSERT INTO `thread_tags`(`thread_ID`, `tag_ID`)
						SELECT '.$threadID.', `tags`.`tag_ID`
						FROM `tags`
						WHERE `tag_Name` IN ('.$tags.')');
						mysqli_stmt_execute($tagStmt);
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
			case 3: // delete thread
				$threadID = $_POST['threadID'];
				$userID = $_POST['userID'];

				mysqli_begin_transaction($conn);

				try {
					$backThreadStmt = mysqli_prepare($conn, 'INSERT INTO `thread_backup` (`thread_ID`, `action_user_ID`, `cat_ID`, `thread_author_ID`, `thread_create`, `thread_update`, `thread_title`, `thread_content`, `thread_type`, `thread_to`, `thread_open`, `thread_upvotes`, `delete_reason`, `delete_desc`)
						SELECT `thread`.`thread_ID`, `thread_author_ID`, `cat_ID`, `thread_author_ID`, `thread_create`, `event_date`, `thread_title`, `thread_content`, `thread_type`, `thread_to`, `thread_open`, `thread_upvotes`, "author deleted" AS "delete_reason", NULL
						FROM `thread`
						JOIN (
							SELECT content.`thread_ID`, `event_date`, `thread_title`, `thread_content`
							FROM `thread_history` content
							INNER JOIN (
								SELECT `thread_ID`, MAX(`thread_ver`) AS "latest_ver"
								FROM `thread_history`
								GROUP BY `thread_ID`
							) ver ON content.`thread_ID` = ver.`thread_ID` AND content.`thread_ver` = ver.`latest_ver`
						) history ON `thread`.`thread_ID` = history.`thread_ID` 
						WHERE `thread`.`thread_ID` = '.$threadID);
					mysqli_stmt_execute($backThreadStmt);

					$threadVerStmt = mysqli_prepare($conn, 'SELECT MAX(`thread_ver`) AS "latest_ver" FROM `thread_history` WHERE `thread_ID` = '.$threadID);
					mysqli_stmt_execute($threadVerStmt);
					$threadVerResult = mysqli_stmt_get_result($threadVerStmt);
					$threadVerRow = mysqli_fetch_array($threadVerResult);
					$threadVer = (int)$threadVerRow['latest_ver'];

					$threadImgCtrStmt = mysqli_prepare($conn, 'SELECT COUNT(*) AS "count" FROM `thread_img` WHERE `thread_ID` = '.$threadID.' AND `thread_ver` = '.$threadVer);
					mysqli_stmt_execute($threadImgCtrStmt);
					$threadImgResult = mysqli_stmt_get_result($threadImgCtrStmt);
					$threadImgRow = mysqli_fetch_array($threadImgResult);
					$threadImgCtr = (int)$threadImgRow['count'];

					if($threadImgCtr > 0) {
						$backThreadImgStmt = mysqli_prepare($conn, 'INSERT INTO `thread_img_backup` (`img_ID`, `thread_ID`, `img_path`)
						SELECT `img_ID`, `thread_ID`, `img_path` 
							FROM `thread_img`
							WHERE `thread_ID` = '.$threadID.' AND `thread_ver` = '.$threadVer);
						mysqli_stmt_execute($backThreadImgStmt);
					}

					$replyCtrStmt = mysqli_prepare($conn, 'SELECT COUNT(*) AS "count" FROM `reply` WHERE `thread_ID` = '.$threadID);
					mysqli_stmt_execute($replyCtrStmt);
					$replyResult = mysqli_stmt_get_result($replyCtrStmt);
					$replyRow = mysqli_fetch_array($replyResult);
					$replyCtr = (int)$replyRow['count'];

					if($replyCtr > 0) {
						$backReplyStmt = mysqli_prepare($conn, 'INSERT INTO `reply_backup` (`reply_ID`, `thread_ID`, `action_user_ID`, `reply_author_ID`, `reply_create`, `reply_update`, `reply_content`, `reply_upvotes`, `is_answer`, `delete_reason`, `delete_desc`)
							SELECT `reply`.`reply_ID`, `thread_ID`, '.$userID.', `reply_author_ID`, `reply_create`, `event_date`, `reply_content`, `reply_upvotes`, `is_answer`, "thread deleted" AS "delete_reason", NULL
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

						$replyVerResult = mysqli_query($conn, 'SELECT `reply`.`reply_ID`, `thread_ID`, history.`reply_ver`
							FROM `reply`
							JOIN (
								SELECT content.`reply_ID`, content.`reply_ver`
								FROM `reply_history` content
								INNER JOIN (
									SELECT `reply_ID`, MAX(`reply_ver`) AS "latest_ver"
									FROM `reply_history`
									GROUP BY `reply_ID`
								) ver ON content.`reply_ID` = ver.`reply_ID` AND content.`reply_ver` = ver.`latest_ver`
							) history ON `reply`.`reply_ID` = history.`reply_ID`  
							WHERE `reply`.`thread_ID` = '.$threadID);

						if(mysqli_num_rows($replyVerResult) > 0) {
							while($replyVerRow = mysqli_fetch_array($replyVerResult)) {
								$replyImgResult = mysqli_query($conn, 'SELECT COUNT(*) AS "count" FROM `reply_img` WHERE `reply_ID` = '.$replyVerRow['reply_ID'].' AND `reply_ver` = '.$replyVerRow['reply_ver']);
								$replyImgRow = mysqli_fetch_array($replyImgResult);
								$replyImgCtr = (int)$replyImgRow['count'];
								
								if($replyImgCtr > 0) {
									$backReplyImgStmt = mysqli_prepare($conn, 'INSERT INTO `reply_img_backup` (`img_ID`, `reply_ID`, `img_path`)
									SELECT `img_ID`, `reply_ID`, `img_path` 
										FROM `reply_img`
										WHERE `reply_ID` = '.$replyVerRow['reply_ID'].' AND `reply_ver` = '.$replyVerRow['reply_ver']);
									mysqli_stmt_execute($backReplyImgStmt);
								}
							}
						}
					}

					$delThreadStmt = mysqli_prepare($conn, 'DELETE FROM `thread` WHERE `thread_ID` = '.$threadID);
					mysqli_stmt_execute($delThreadStmt);

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
			case 4: // change thread_open
				$threadID = $_POST['threadID'];
				$threadOpen = $_POST['threadOpen'];

				$closeSql = 'SELECT COUNT(*) AS "count" FROM `thread_close` WHERE `thread_ID` = '.$threadID;

				$result = mysqli_query($conn, $closeSql);
				if($result) {
					$row = mysqli_fetch_assoc($result);
					
					if($row['count'] == 0) {
						$sql = 'UPDATE `thread`
							SET `thread_open` = '.$threadOpen.'
							WHERE `thread_ID` = '.$threadID;
		
						if(mysqli_query($conn, $sql))
							echo json_encode(array(true));
						else 
							echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
					} else
						echo json_encode(array(true));
				} else
					echo json_encode(array(false, 'Error: '. $closeSql . '\n'. mysqli_error($conn), $sql));

				break;
			case 5: // admin delete thread
				$threadID = $_POST['threadID'];
				$userID = $_POST['userID'];
				$deleteReason = mysqli_real_escape_string($conn, $_POST['deleteReason']);
				$deleteDesc = mysqli_real_escape_string($conn, $_POST['deleteDesc']);
				if(!isset($_POST['deleteDesc']) || empty($_POST['deleteDesc']))
					$deleteDesc = 'NULL';

				mysqli_begin_transaction($conn);

				try {
					$backThreadStmt = mysqli_prepare($conn, 'INSERT INTO `thread_backup` (`thread_ID`, `action_user_ID`, `cat_ID`, `thread_author_ID`, `thread_create`, `thread_update`, `thread_title`, `thread_content`, `thread_type`, `thread_to`, `thread_open`, `thread_upvotes`, `delete_reason`, `delete_desc`)
						SELECT `thread`.`thread_ID`, '.$userID.', `cat_ID`, `thread_author_ID`, `thread_create`, `event_date`, `thread_title`, `thread_content`, `thread_type`, `thread_to`, `thread_open`, `thread_upvotes`, "'.$deleteReason.'" AS "delete_reason", '.$deleteDesc.' 
						FROM `thread`
						JOIN (
							SELECT content.`thread_ID`, `event_date`, `thread_title`, `thread_content`
							FROM `thread_history` content
							INNER JOIN (
								SELECT `thread_ID`, MAX(`thread_ver`) AS "latest_ver"
								FROM `thread_history`
								GROUP BY `thread_ID`
							) ver ON content.`thread_ID` = ver.`thread_ID` AND content.`thread_ver` = ver.`latest_ver`
						) history ON `thread`.`thread_ID` = history.`thread_ID` 
						WHERE `thread`.`thread_ID` = '.$threadID);
					mysqli_stmt_execute($backThreadStmt);

					$threadVerStmt = mysqli_prepare($conn, 'SELECT MAX(`thread_ver`) AS "latest_ver" FROM `thread_history` WHERE `thread_ID` = '.$threadID);
					mysqli_stmt_execute($threadVerStmt);
					$threadVerResult = mysqli_stmt_get_result($threadVerStmt);
					$threadVerRow = mysqli_fetch_array($threadVerResult);
					$threadVer = (int)$threadVerRow['latest_ver'];

					$threadImgCtrStmt = mysqli_prepare($conn, 'SELECT COUNT(*) AS "count" FROM `thread_img` WHERE `thread_ID` = '.$threadID.' AND `thread_ver` = '.$threadVer);
					mysqli_stmt_execute($threadImgCtrStmt);
					$threadImgResult = mysqli_stmt_get_result($threadImgCtrStmt);
					$threadImgRow = mysqli_fetch_array($threadImgResult);
					$threadImgCtr = (int)$threadImgRow['count'];

					if($threadImgCtr > 0) {
						$backThreadImgStmt = mysqli_prepare($conn, 'INSERT INTO `thread_img_backup` (`img_ID`, `thread_ID`, `img_path`)
						SELECT `img_ID`, `thread_ID`, `img_path` 
							FROM `thread_img`
							WHERE `thread_ID` = '.$threadID.' AND `thread_ver` = '.$threadVer);
						mysqli_stmt_execute($backThreadImgStmt);
					}

					$replyCtrStmt = mysqli_prepare($conn, 'SELECT COUNT(*) AS "count" FROM `reply` WHERE `thread_ID` = '.$threadID);
					mysqli_stmt_execute($replyCtrStmt);
					$replyResult = mysqli_stmt_get_result($replyCtrStmt);
					$replyRow = mysqli_fetch_array($replyResult);
					$replyCtr = (int)$replyRow['count'];

					if($replyCtr > 0) {
						$backReplyStmt = mysqli_prepare($conn, 'INSERT INTO `reply_backup` (`reply_ID`, `thread_ID`, `action_user_ID`, `reply_author_ID`, `reply_create`, `reply_update`, `reply_content`, `reply_upvotes`, `is_answer`, `delete_reason`, `delete_desc`)
							SELECT `reply`.`reply_ID`, `thread_ID`, '.$userID.', `reply_author_ID`, `reply_create`, `event_date`, `reply_content`, `reply_upvotes`, `is_answer`, "thread deleted" AS "delete_reason", NULL
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
						
						$replyVerResult = mysqli_query($conn, 'SELECT `reply`.`reply_ID`, `thread_ID`, history.`reply_ver`
							FROM `reply`
							JOIN (
								SELECT content.`reply_ID`, content.`reply_ver`
								FROM `reply_history` content
								INNER JOIN (
									SELECT `reply_ID`, MAX(`reply_ver`) AS "latest_ver"
									FROM `reply_history`
									GROUP BY `reply_ID`
								) ver ON content.`reply_ID` = ver.`reply_ID` AND content.`reply_ver` = ver.`latest_ver`
							) history ON `reply`.`reply_ID` = history.`reply_ID`  
							WHERE `reply`.`thread_ID` = '.$threadID);

						if(mysqli_num_rows($replyVerResult) > 0) {
							while($replyVerRow = mysqli_fetch_array($replyVerResult)) {
								$replyImgResult = mysqli_query($conn, 'SELECT COUNT(*) AS "count" FROM `reply_img` WHERE `reply_ID` = '.$replyVerRow['reply_ID'].' AND `reply_ver` = '.$replyVerRow['reply_ver']);
								$replyImgRow = mysqli_fetch_array($replyImgResult);
								$replyImgCtr = (int)$replyImgRow['count'];
								
								if($replyImgCtr > 0) {
									$backReplyImgStmt = mysqli_prepare($conn, 'INSERT INTO `reply_img_backup` (`img_ID`, `reply_ID`, `img_path`)
									SELECT `img_ID`, `reply_ID`, `img_path` 
										FROM `reply_img`
										WHERE `reply_ID` = '.$replyVerRow['reply_ID'].' AND `reply_ver` = '.$replyVerRow['reply_ver']);
									mysqli_stmt_execute($backReplyImgStmt);
								}
							}
						}
					}

					$delThreadStmt = mysqli_prepare($conn, 'DELETE FROM `thread` WHERE `thread_ID` = '.$threadID);
					mysqli_stmt_execute($delThreadStmt);

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 6: // admin close thread
				$threadID = $_POST['threadID'];
				$userID = $_POST['userID'];
				$closeLink = mysqli_real_escape_string($conn, $_POST['closeLink']);
				$deleteReport = false;

				if($userID == 'admin') {
					$userID = $_SESSION['admin'];
					$deleteReport = true;
				}

				mysqli_begin_transaction($conn);

				try {
					$closeThreadStmt = mysqli_prepare($conn, 'UPDATE `thread` SET `thread_open` = 0 WHERE `thread_ID` = '.$threadID);
					mysqli_stmt_execute($closeThreadStmt);

					$adminCloseStmt = mysqli_prepare($conn, 'INSERT INTO `thread_close` (`thread_ID`, `close_author`, `close_date`, `close_link`) VALUES (?, ?, NOW(), ?)');
					mysqli_stmt_bind_param($adminCloseStmt, 'iis', $threadID, $userID, $closeLink);
					mysqli_stmt_execute($adminCloseStmt);

					if($deleteReport) {
						$deleteStmt = mysqli_prepare($conn, 'DELETE FROM `reports` WHERE `Thread_ID` = '.$threadID.' AND `Report_Reason` = "Redundant Post"');
						mysqli_stmt_execute($deleteStmt);
					}
					
					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 7: // select specific thread
				$threadID = $_POST['ID'];
				$threadarray = array();
				
				$sql = 'SELECT `thread`.*, `category`.`cat_name`, `user`.`Img`, `user`.`FName`, `user`.`LName`, CONCAT(`user`.`FName`, " ", `user`.`LName`) AS "thread_author", DATE_FORMAT(`thread_create`, "%M %e, %Y") AS "create", DATE_FORMAT(`thread_create`, "%Y") AS "create_yr", DATE_FORMAT(`thread_create`, "%h:%i %p") AS "create_time", DATE_FORMAT(`thread_create`, "%m%d%y") AS "create_link", history.`thread_ver`, history.`event_date`, DATE_FORMAT(history.`event_date`, "%M %e, %Y") AS "update", DATE_FORMAT(history.`event_date`, "%Y") AS "update_yr", DATE_FORMAT(history.`event_date`, "%h:%i %p") AS "update_time", history.`thread_title`, history.`thread_content`, NOW() as "date_now", YEAR(NOW()) AS "year_now"
				FROM `thread`
				JOIN `category` ON `thread`.`cat_ID` = `category`.`cat_ID`
				JOIN `user` ON `thread`.`thread_author_ID` = `user`.`User_ID` 
				JOIN (
					SELECT content.`thread_ID`, content.`thread_ver`, `event_date`, `thread_title`, `thread_content`
					FROM `thread_history` content
					INNER JOIN (
						SELECT `thread_ID`, MAX(`thread_ver`) AS "latest_ver"
						FROM `thread_history`
						GROUP BY `thread_ID`
					) ver ON content.`thread_ID` = ver.`thread_ID` AND content.`thread_ver` = ver.`latest_ver`
				) history ON `thread`.`thread_ID` = history.`thread_ID`
				WHERE `thread`.`thread_ID` = '.$threadID;

				$result = mysqli_query($conn, $sql);
				if($result) {
					while($row = mysqli_fetch_assoc($result)) {
						$info = array();
						$info['Img'] = $row['Img'];

						$threadFname = strtolower(substr(preg_replace('/\s+/', '', $row['FName']), 0, 1));
						$threadLname = strtolower(preg_replace('/\s+/', '', $row['LName']));
						$threadAuthorLink = '../../profile.php?ID='.$row['thread_author_ID'].'&'.$threadFname.$threadLname.'#/about';

						$info['thread_author_link'] = $threadAuthorLink;
						$info['thread_author'] = $row['thread_author'];
						$info['cat_name'] = $row['cat_name'];

						$isExact = false;

						$createDatetime = $row['thread_create'];
						$createDate = $row['create'];
						$createTime = $row['create_time'];

						$updateDatetime = $row['event_date'];
						$updateDate = $row['update'];
						$updateTime = $row['update_time'];

						if($createDatetime != $updateDatetime) {
							if($row['year_now'] == $row['create_yr'])
								$time1 = explode(',', $createDate)[0];
							else
								$time1 =  $createDate;
								
							$seconds = strtotime($row['date_now']) - strtotime($updateDatetime);
							if(floor($seconds) >= 60) {
								$mins = $seconds / 60;

								if(floor($mins) >= 60) {
									$hrs = $mins / 60;

									if(floor($hrs) >= 24) {
										$days = $hrs / 24;

										if(floor($days) >= 7) {
											if($row['year_now'] == $row['update_yr'])
												$time2 = explode(',', $updateDate)[0].' at '.$updateTime;
											else
												$time2 = $updateDate;

											$isExact = true;
											$unit = '';
										} else {
											$time2 = floor($days);
											$unit = $time2 == 1 ? ' day' : ' days';
										}
									} else {
										$time2 = floor($hrs);
										$unit = $time2 == 1 ? ' hour' : ' hours';
									}
								} else {
									$time2 = floor($mins);
									$unit = $time2 == 1 ? ' minute' : ' minutes';
								}
							} else {
								$time2 = '';
								$unit = ' less than a minute';
							}

							$finalCreate = $time1;
							$finalUpdate = $time2.$unit.($isExact ? '' : ' ago');
						} else {
							$seconds = strtotime($row['date_now']) - strtotime($createDatetime);
							if(floor($seconds) >= 60) {
								$mins = $seconds / 60;

								if(floor($mins) >= 60) {
									$hrs = $mins / 60;

									if(floor($hrs) >= 24) {
										$days = $hrs / 24;

										if(floor($days) >= 7) {
											if($row['year_now'] == $row['create_yr'])
												$time = explode(',', $createDate)[0].' at '.$createTime;
											else
												$time = $createDate;

											$isExact = true;
											$unit = '';
										} else {
											$time = floor($days);
											$unit = $time == 1 ? ' day' : ' days';
										}
									} else {
										$time = floor($hrs);
										$unit = $time == 1 ? ' hour' : ' hours';
									}
								} else {
									$time = floor($mins);
									$unit = $time == 1 ? ' minute' : ' minutes';
								}
							} else {
								$time = '';
								$unit = ' less than a minute';
							}

							$finalCreate = $time.$unit.($isExact ? '' : ' ago');
							$finalUpdate = '';
						}

						$info['create'] = $finalCreate;
						$info['update'] = $finalUpdate;
						$info['thread_type'] = $row['thread_type'];
						$info['thread_title'] = $row['thread_title'];
						$threadContent = stripcslashes($row['thread_content']);
						
						$imgSql = 'SELECT `img_path` FROM `thread_img` WHERE `thread_ID` = '.$threadID.' AND `thread_ver` = '.$row['thread_ver'];
                                        
						$imgResult = mysqli_query($conn, $imgSql);
						if(mysqli_num_rows($imgResult) > 0) {
							while($imgRow = mysqli_fetch_array($imgResult)) {
								$replace = '<img src="../../'.$imgRow['img_path'].'">';

								$threadContent = implode($replace, explode('<img src="path_to_thread_img">', $threadContent, 2));
							}
						}

						$info['thread_content'] = $threadContent;

						$threadarray[] = $info;
					}
					echo json_encode(array(true, $threadarray));
				} else {
					echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
				}

				break;
			case 8: // select all versions of specific thread
				$threadID = $_POST['ID'];
				
				$sql = 'SELECT `thread_history`.*, DATE_FORMAT(`event_date`, "%M %e, %Y") AS "update", DATE_FORMAT(`event_date`, "%Y") AS "update_yr", DATE_FORMAT(`event_date`, "%h:%i %p") AS "update_time", NOW() as "date_now", YEAR(NOW()) AS "year_now", `user`.`Img`, CONCAT(`user`.`FName`, " ", `user`.`LName`) AS "User_Full", NOW() as "date_now", YEAR(NOW()) AS "year_now"
				FROM `thread_history`
				JOIN `thread` ON `thread_history`.`thread_ID` = `thread`.`thread_ID`
				JOIN `user` ON `thread`.`thread_author_ID` = `user`.`User_ID`
				WHERE `thread_history`.`thread_ID` = '.$threadID.'
				ORDER BY `thread_ver` DESC';

				$result = mysqli_query($conn, $sql);
				if($result) {
					$postarray = array();
					while($row = mysqli_fetch_assoc($result)) {
						$info = array();
						$info['Img'] = $row['Img'];
						$info['User_Full'] = $row['User_Full'];

						$isExact = false;

						$updateDatetime = $row['event_date'];
						$updateDate = $row['update'];
						$updateTime = $row['update_time'];

						$seconds = strtotime($row['date_now']) - strtotime($updateDatetime);
						if(floor($seconds) >= 60) {
							$mins = $seconds / 60;

							if(floor($mins) >= 60) {
								$hrs = $mins / 60;

								if(floor($hrs) >= 24) {
									$days = $hrs / 24;

									if(floor($days) >= 7) {
										if($row['year_now'] == $row['update_yr'])
											$time = explode(',', $updateDate)[0].' at '.$updateTime;
										else
											$time = $updateDate;

										$isExact = true;
										$unit = '';
									} else {
										$time = floor($days);
										$unit = $time == 1 ? ' day' : ' days';
									}
								} else {
									$time = floor($hrs);
									$unit = $time == 1 ? ' hour' : ' hours';
								}
							} else {
								$time = floor($mins);
								$unit = $time == 1 ? ' minute' : ' minutes';
							}
						} else {
							$time = '';
							$unit = ' less than a minute';
						}

						$info['Post_Date'] = $time.$unit.($isExact ? '' : ' ago');
						$info['Thread_Title'] = $row['thread_title'];
						$threadContent = stripcslashes($row['thread_content']);
						
						$imgSql = 'SELECT `img_path` FROM `thread_img` WHERE `thread_ID` = '.$threadID.' AND `thread_ver` = '.$row['thread_ver'];
                                        
						$imgResult = mysqli_query($conn, $imgSql);
						if(mysqli_num_rows($imgResult) > 0) {
							while($imgRow = mysqli_fetch_array($imgResult)) {
								$replace = '<img src="../'.$imgRow['img_path'].'">';

								$threadContent = implode($replace, explode('<img src="path_to_thread_img">', $threadContent, 2));
							}
						}

						$info['Post_Content'] = $threadContent;

						$postarray[] = $info;
					}
					echo json_encode(array(true, $postarray));
				} else {
					echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
				}

				break;
			case 9: // retrieve path of images in a post
				$threadID = $_POST['ID'];
				$threadVer = $_POST['postVer'];

				$sql = 'SELECT `img_path` FROM `thread_img` WHERE `thread_ID` = '.$threadID.' AND `thread_ver` = '.$threadVer.' ORDER BY `img_ID`';
				$result = mysqli_query($conn, $sql);
				if($result) {
					$imgarray = array();
					while($row = mysqli_fetch_assoc($result)) {
						// assign fetched row to array
						$imgarray[] = $row;
					}
					echo json_encode(array(true, $imgarray));
				} else {
					echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
				}

				break;
			case 10: // retrieve threads of user
				$userID = $_POST['userID'];

				$sql = 'SELECT `thread`.*, DATE_FORMAT(`thread_create`, "%M %e, %Y") AS "create", DATE_FORMAT(`thread_create`, "%Y") AS "create_yr", DATE_FORMAT(`thread_create`, "%m%d%y") AS "create_link", history.`thread_title`, NOW() as "date_now", YEAR(NOW()) AS "year_now"
					FROM `thread`
					JOIN (
						SELECT content.`thread_ID`, `thread_title`
						FROM `thread_history` content
						INNER JOIN (
							SELECT `thread_ID`, MAX(`thread_ver`) AS "latest_ver"
							FROM `thread_history`
							GROUP BY `thread_ID`
						) ver ON content.`thread_ID` = ver.`thread_ID` AND content.`thread_ver` = ver.`latest_ver`
					) history ON `thread`.`thread_ID` = history.`thread_ID` 
					WHERE `thread_author_ID` = '.$userID.'
					ORDER BY `thread_create` DESC';
					
				$result = mysqli_query($conn, $sql);
				if($result) {
					$threadarray = array();
					while($row = mysqli_fetch_array($result)) {
						$info = array();

						$threadName = preg_replace('/[^a-zA-Z0-9 ]/', '', strtolower($row['thread_title']));
						$threadName = str_replace(' ', '-', $threadName);

						$threadLink = 'forum/thread.php?ID='.$row['thread_ID'].'/'.$row['create_link'].'/'.$threadName;

						$info['thread_link'] = $threadLink;
						$info['thread_title'] = $row['thread_title'];
						$info['create'] = $row['create'];
						$info['thread_upvotes'] = $row['thread_upvotes'];

						$sql = 'SELECT COUNT(*) AS "answerRow" 
							FROM `reply` 
							WHERE `thread_ID` = '.$row['thread_ID'].' AND `is_answer` = 1';
							
						$answerResult = mysqli_query($conn, $sql);
						$answerRow = mysqli_fetch_array($answerResult);

						$info['answer_count'] = $answerRow['answerRow'];
						$threadarray[] = $info;
					}
					echo json_encode(array(true, $threadarray));
				} else {
					echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
				}

				break;
			case 11: // check if thread was closed by admin
				$threadID = $_POST['threadID'];

				$closeSql = 'SELECT `thread_close`.*, `user`.`FName`, `user`.`LName`, `user`.`Img`, DATE_FORMAT(`close_date`, "%M %e, %Y") AS "close", DATE_FORMAT(`close_date`, "%Y") AS "close_yr", DATE_FORMAT(`close_date`, "%h:%i %p") AS "close_time", `thread`.`thread_type`, NOW() as "date_now", YEAR(NOW()) AS "year_now"
				FROM `thread_close`
				JOIN `user` ON `thread_close`.`close_author` = `user`.`User_ID`
				JOIN `thread` ON `thread_close`.`thread_ID` = `thread`.`thread_ID`
				WHERE `thread_close`.`thread_ID` = '.$threadID;
		
				$closeResult = mysqli_query($conn, $closeSql);
				if($closeResult) {
					$closearray = array();
					if(mysqli_num_rows($closeResult) > 0) {
						$closeRow = mysqli_fetch_array($closeResult);
						$closeLink = explode('forum/', $closeRow['close_link'], 2);
						$similarIDLink = explode('?ID=', $closeRow['close_link'], 2);
						$similarID = explode('/', $similarIDLink[1], 2);
						
						$similarSql = 'SELECT content.`thread_ID`, `event_date`, `thread_title`
						FROM `thread_history` content
						INNER JOIN (
							SELECT `thread_ID`, MAX(`thread_ver`) AS "latest_ver"
							FROM `thread_history`
							GROUP BY `thread_ID`
						) ver ON content.`thread_ID` = ver.`thread_ID` AND content.`thread_ver` = ver.`latest_ver`
						WHERE content.`thread_ID` = '.$similarID[0];
					
						$similarResult = mysqli_query($conn, $similarSql);
						if(mysqli_num_rows($similarResult) > 0) {
							$info = array();
							$similarRow = mysqli_fetch_array($similarResult);
							
							$info['Img'] = $closeRow['Img'];

							$closeFname = strtolower(substr(preg_replace('/\s+/', '', $closeRow['FName']), 0, 1));
							$closeLname = strtolower(preg_replace('/\s+/', '', $closeRow['LName']));
							$closeAuthorLink = '../../profile.php?ID='.$closeRow['close_author'].'&'.$closeFname.$closeLname.'#/about';

							$info['reply_author_link'] = $closeAuthorLink;
							$info['reply_author'] = $closeRow['FName'].' '.$closeRow['LName'];
							
							$isExact = false;
							
							$createDatetime = $closeRow['close_date'];
							$createDate = $closeRow['close'];
							$createTime = $closeRow['close_time'];

							$seconds = strtotime($closeRow['date_now']) - strtotime($createDatetime);
							if(floor($seconds) >= 60) {
								$mins = $seconds / 60;

								if(floor($mins) >= 60) {
									$hrs = $mins / 60;

									if(floor($hrs) >= 24) {
										$days = $hrs / 24;

										if(floor($days) >= 7) {
											if($row['year_now'] == $row['close_yr'])
												$time = explode(',', $createDate)[0].' at '.$createTime;
											else
												$time = $createDate;

											$isExact = true;
											$unit = '';
										} else {
											$time = floor($days);
											$unit = $time == 1 ? ' day' : ' days';
										}
									} else {
										$time = floor($hrs);
										$unit = $time == 1 ? ' hour' : ' hours';
									}
								} else {
									$time = floor($mins);
									$unit = $time == 1 ? ' minute' : ' minutes';
								}
							} else {
								$time = '';
								$unit = ' less than a minute';
							}

							$finalCreate = $time.$unit.($isExact ? '' : ' ago');

							$info['reply_create'] = $finalCreate;
							$info['event_date'] = '';
							
							$info['reply_content'] = '<div id = "similar-header">'.($closeRow['thread_type'] == 'D' ? 'This thread has been closed as a similar discussion forum has been posted before:' : 'This thread has been closed as this question has been answered here:').'</div><a href = "../../forum/'.$closeLink[1].'" target = "_blank">'.$similarRow['thread_title'].'</a>';
						
							$closearray[] = $info;
						}
					}
					echo json_encode(array(true, $closearray));
				} else {
					echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
				}
				break;
        }
	}
	mysqli_close($conn);
?>