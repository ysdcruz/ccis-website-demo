<?php
	include 'dbconn.php';

	if(count($_POST) > 0) {
		switch($_POST['type']) {
			case 1: // create reply
				$threadID = $_POST['threadID'];
				$userID = $_POST['userID'];
				$replyContent = mysqli_real_escape_string($conn, $_POST['replyContent']);
				$img = json_decode($_POST['imgSrc'], true);
				
				mysqli_begin_transaction($conn);

				try {
					$dateStmt = mysqli_prepare($conn, 'SELECT NOW() AS "datenow"');
					mysqli_stmt_execute($dateStmt);
					$result = mysqli_stmt_get_result($dateStmt);
					$row = mysqli_fetch_array($result);
					$postDate = $row['datenow'];

					$replyStmt = mysqli_prepare($conn, 'INSERT INTO `reply` (`thread_ID`, `reply_author_ID`, `reply_create`, `reply_upvotes`, `is_answer`) VALUES (?, ?, ?, 0, 0)');
					mysqli_stmt_bind_param($replyStmt, 'iis', $threadID, $userID, $postDate);
					mysqli_stmt_execute($replyStmt);
					$insertID = mysqli_stmt_insert_id($replyStmt);

					$contentStmt = mysqli_prepare($conn, 'INSERT INTO `reply_history` (`reply_ID`, `reply_ver`, `event_date`, `reply_content`) VALUES ('.$insertID.', 1, ?, ?)');
					mysqli_stmt_bind_param($contentStmt, 'ss', $postDate, $replyContent);
					mysqli_stmt_execute($contentStmt);

					if(!empty($img)) {
						$uploadLoc = '../images/reply/'.$insertID;
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
						
						$imgSql = 'INSERT INTO `reply_img` (`reply_ID`, `reply_ver`, `img_path`) VALUES ';

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
			case 2: // update reply
				$replyID = $_POST['replyID'];
				$replyContent = mysqli_real_escape_string($conn, $_POST['replyContent']);
				$img = json_decode($_POST['imgSrc'], true);

				mysqli_begin_transaction($conn);

				try {
					$dateStmt = mysqli_prepare($conn, 'SELECT NOW() AS "datenow"');
					mysqli_stmt_execute($dateStmt);
					$result = mysqli_stmt_get_result($dateStmt);
					$row = mysqli_fetch_array($result);
					$postDate = $row['datenow'];

					$verStmt = mysqli_prepare($conn, 'SELECT MAX(`reply_ver`) AS "latest_ver" FROM `reply_history` WHERE `reply_ID` = '.$replyID);
					mysqli_stmt_execute($verStmt);
					$result = mysqli_stmt_get_result($verStmt);
					$row = mysqli_fetch_array($result);
					$latestVer = (int)$row['latest_ver'] + 1;

					$contentStmt = mysqli_prepare($conn, 'INSERT INTO `reply_history` (`reply_ID`, `reply_ver`, `event_date`, `reply_content`) VALUES ('.$replyID.', ?, ?, ?)');
					mysqli_stmt_bind_param($contentStmt, 'iss', $latestVer, $postDate, $replyContent);
					mysqli_stmt_execute($contentStmt);

					if(!empty($img)) {
						$uploadLoc = '../images/reply/'.$replyID;
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
						
						$imgSql = 'INSERT INTO `reply_img` (`reply_ID`, `reply_ver`, `img_path`) VALUES ';

						foreach($imgarray as $imgSrc) {
							$imgSrc = substr($imgSrc, 3);
							$imgSql .= '('.$replyID.', '.$latestVer.', "'.$imgSrc.'"),';
						}
						
						$imgSql = substr($imgSql, 0, -1);

						$imgStmt = mysqli_prepare($conn,  $imgSql);
						mysqli_stmt_execute($imgStmt);
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 3: // select reply
				$threadID = $_POST['threadID'];
				
				$sql = 'SELECT `reply`.*, `user`.`Img`, `user`.`FName`, `user`.`LName`, CONCAT(`user`.`FName`, " ", `user`.`LName`) AS "reply_author", DATE_FORMAT(`reply_create`, "%M %e, %Y") AS "create", DATE_FORMAT(`reply_create`, "%Y") AS "create_yr", DATE_FORMAT(`reply_create`, "%h:%i %p") AS "create_time", history.`reply_ver`, history.`event_date`, DATE_FORMAT(history.`event_date`, "%M %e, %Y") AS "update", DATE_FORMAT(history.`event_date`, "%Y") AS "update_yr", DATE_FORMAT(history.`event_date`, "%h:%i %p") AS "update_time", history.`reply_content`, NOW() as "date_now", YEAR(NOW()) AS "year_now"
					FROM `reply`
					JOIN `user` ON `reply`.`reply_author_ID` = `user`.`User_ID`
					JOIN (
						SELECT content.`reply_ID`, content.`reply_ver`, `event_date`, `reply_content` 
						FROM `reply_history` content
						INNER JOIN (
							SELECT `reply_ID`, MAX(`reply_ver`) AS "latest_ver"
							FROM `reply_history`
							GROUP BY `reply_ID`
						) ver ON content.`reply_ID` = ver.`reply_ID` AND content.`reply_ver` = ver.`latest_ver`
					) history ON `reply`.`reply_ID` = history.`reply_ID`
					WHERE `thread_ID` = '.$threadID;

				$result = mysqli_query($conn, $sql);
				if($result) {
					$postarray = array();
					while($row = mysqli_fetch_assoc($result)) {
						$info = array();
						$info['Img'] = $row['Img'];
						
						$replyFname = strtolower(substr(preg_replace('/\s+/', '', $row['FName']), 0, 1));
						$replyLname = strtolower(preg_replace('/\s+/', '', $row['LName']));
						$replyAuthorLink = '../../profile.php?ID='.$row['reply_author_ID'].'&'.$replyFname.$replyLname.'#/about';

						$info['reply_author_link'] = $replyAuthorLink;
						$info['reply_author'] = $row['reply_author'];

						$isExact = false;

						$createDatetime = $row['reply_create'];
						$createDate = $row['create'];
						$createTime = $row['create_time'];

						$updateDatetime = $row['event_date'];
						$updateDate = $row['update'];
						$updateTime = $row['update_time'];

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

						if($createDatetime != $updateDatetime) {
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
							
							$finalUpdate = $time.$unit.($isExact ? '' : ' ago');
						} else
							$finalUpdate = '';

						$info['reply_create'] = $finalCreate;
						$info['event_date'] = $finalUpdate;
						$replyContent = stripcslashes($row['reply_content']);

						$imgSql = 'SELECT `img_path` FROM `reply_img` WHERE `reply_ID` = '.$row['reply_ID'].' AND `reply_ver` = '.$row['reply_ver'];
                                        
						$imgResult = mysqli_query($conn, $imgSql);
						if(mysqli_num_rows($imgResult) > 0) {
							while($imgRow = mysqli_fetch_array($imgResult)) {
								$replace = '<img src="../../'.$imgRow['img_path'].'">';

								$replyContent = implode($replace, explode('<img src="path_to_thread_img">', $replyContent, 2));
							}
						}

						$info['reply_content'] = $replyContent;

						$postarray[] = $info;
					}
					echo json_encode(array(true, $postarray));
				} else {
					echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
				}
				
				break;
			case 4: // set is_answer
				$replyID = $_POST['replyID'];
				$isAnswer = $_POST['isAnswer'];
				
				$sql = 'UPDATE `reply`
					SET `is_answer` = '.$isAnswer.'
					WHERE `reply_ID` = '.$replyID;

				if(mysqli_query($conn, $sql)) {
					echo json_encode(array(true));
				} else {
					echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
				}
				
				break;
			case 5: // delete reply
				$replyID = $_POST['replyID'];

				mysqli_begin_transaction($conn);

				try {
					$backReplyStmt = mysqli_prepare($conn, 'INSERT INTO `reply_backup` (`reply_ID`, `thread_ID`, `action_user_ID`, `reply_author_ID`, `reply_create`, `reply_update`, `reply_content`, `reply_upvotes`, `is_answer`, `delete_reason`, `delete_desc`)
						SELECT `reply`.`reply_ID`, `thread_ID`, `reply_author_ID`, `reply_author_ID`, `reply_create`, `event_date`, `reply_content`, `reply_upvotes`, `is_answer`, "reply deleted" AS "delete_reason", NULL
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
						WHERE `reply`.`reply_ID` = '.$replyID);
					mysqli_stmt_execute($backReplyStmt);

					$replyVerResult = mysqli_query($conn, 'SELECT MAX(`reply_ver`) AS "reply_ver"
						FROM `reply_history`
						WHERE `reply_ID` = '.$replyID);
					$replyVerRow = mysqli_fetch_array($replyVerResult);

					$replyImgResult = mysqli_query($conn, 'SELECT COUNT(*) AS "count" FROM `reply_img` WHERE `reply_ID` = '.$replyID.' AND `reply_ver` = '.$replyVerRow['reply_ver']);
					$replyImgRow = mysqli_fetch_array($replyImgResult);
					$replyImgCtr = (int)$replyImgRow['count'];
					
					if($replyImgCtr > 0) {
						$backReplyImgStmt = mysqli_prepare($conn, 'INSERT INTO `reply_img_backup` (`img_ID`, `reply_ID`, `img_path`)
							SELECT `img_ID`, `reply_ID`, `img_path` 
								FROM `reply_img`
								WHERE `reply_ID` = '.$replyID.' AND `reply_ver` = '.$replyVerRow['reply_ver']);
						mysqli_stmt_execute($backReplyImgStmt);
					}

					$delReplyStmt = mysqli_prepare($conn, 'DELETE FROM `reply` WHERE `reply_ID` = '.$replyID);
					mysqli_stmt_execute($delReplyStmt);

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 6: // admin delete reply
				$replyID = $_POST['replyID'];
				$userID = $_POST['userID'];
				$deleteReason = mysqli_real_escape_string($conn, $_POST['deleteReason']);
				$deleteDesc = mysqli_real_escape_string($conn, $_POST['deleteDesc']);
				if(!isset($_POST['deleteDesc']) || empty($_POST['deleteDesc']))
					$deleteDesc = 'NULL';

				mysqli_begin_transaction($conn);

				try {
					$backReplyStmt = mysqli_prepare($conn, 'INSERT INTO `reply_backup` (`reply_ID`, `thread_ID`, `action_user_ID`, `reply_author_ID`, `reply_create`, `reply_update`, `reply_content`, `reply_upvotes`, `is_answer`, `delete_reason`, `delete_desc`)
						SELECT `reply`.`reply_ID`, `thread_ID`, '.$userID.', `reply_author_ID`, `reply_create`, `event_date`, `reply_content`, `reply_upvotes`, `is_answer`, "'.$deleteReason.'" AS "delete_reason", '.$deleteDesc.' 
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
						WHERE `reply`.`reply_ID` = '.$replyID);
					mysqli_stmt_execute($backReplyStmt);

					$replyVerResult = mysqli_query($conn, 'SELECT MAX(`reply_ver`) AS "reply_ver"
						FROM `reply_history`
						WHERE `reply_ID` = '.$replyID);
					$replyVerRow = mysqli_fetch_array($replyVerResult);

					$replyImgResult = mysqli_query($conn, 'SELECT COUNT(*) AS "count" FROM `reply_img` WHERE `reply_ID` = '.$replyID.' AND `reply_ver` = '.$replyVerRow['reply_ver']);
					$replyImgRow = mysqli_fetch_array($replyImgResult);
					$replyImgCtr = (int)$replyImgRow['count'];
					
					if($replyImgCtr > 0) {
						$backReplyImgStmt = mysqli_prepare($conn, 'INSERT INTO `reply_img_backup` (`img_ID`, `reply_ID`, `img_path`)
							SELECT `img_ID`, `reply_ID`, `img_path` 
								FROM `reply_img`
								WHERE `reply_ID` = '.$replyID.' AND `reply_ver` = '.$replyVerRow['reply_ver']);
						mysqli_stmt_execute($backReplyImgStmt);
					}
					
					$delReplyStmt = mysqli_prepare($conn, 'DELETE FROM `reply` WHERE `reply_ID` = '.$replyID);
					mysqli_stmt_execute($delReplyStmt);
	
					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
					
				break;
			case 7: // select specific reply
				$replyID = $_POST['ID'];
				
				$sql = 'SELECT `reply`.*, `user`.`Img`, `user`.`FName`, `user`.`LName`, DATE_FORMAT(`reply_create`, "%M %e, %Y") AS "create", DATE_FORMAT(`reply_create`, "%Y") AS "create_yr", DATE_FORMAT(`reply_create`, "%h:%i %p") AS "create_time", history.`reply_ver`, history.`event_date`, DATE_FORMAT(history.`event_date`, "%M %e, %Y") AS "update", DATE_FORMAT(history.`event_date`, "%Y") AS "update_yr", DATE_FORMAT(history.`event_date`, "%h:%i %p") AS "update_time", history.`reply_content`
					FROM `reply`
					JOIN `user` ON `reply`.`reply_author_ID` = `user`.`User_ID`
					JOIN (
						SELECT content.`reply_ID`, content.`reply_ver`, `event_date`, `reply_content` 
						FROM `reply_history` content
						INNER JOIN (
							SELECT `reply_ID`, MAX(`reply_ver`) AS "latest_ver"
							FROM `reply_history`
							GROUP BY `reply_ID`
						) ver ON content.`reply_ID` = ver.`reply_ID` AND content.`reply_ver` = ver.`latest_ver`
					) history ON `reply`.`reply_ID` = history.`reply_ID`
					WHERE `reply_ID` = '.$replyID;

				$result = mysqli_query($conn, $sql);
				if($result) {
					$replyarray = array();
					while($row = mysqli_fetch_assoc($result)) {
						// assign fetched row to array
						$replyarray[] = $row;
					}
					echo json_encode(array(true, $replyarray));
				} else {
					echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
				}

				break;
			case 8: // select all versions of specific reply
				$replyID = $_POST['ID'];
				
				$sql = 'SELECT `reply_history`.*, DATE_FORMAT(`event_date`, "%M %e, %Y") AS "update", DATE_FORMAT(`event_date`, "%Y") AS "update_yr", DATE_FORMAT(`event_date`, "%h:%i %p") AS "update_time", NOW() as "date_now", YEAR(NOW()) AS "year_now", `user`.`Img`, CONCAT(`user`.`FName`, " ", `user`.`LName`) AS "User_Full", NOW() as "date_now", YEAR(NOW()) AS "year_now"
				FROM `reply_history`
				JOIN `reply` ON `reply_history`.`reply_ID` = `reply`.`reply_ID`
				JOIN `user` ON `reply`.`reply_author_ID` = `user`.`User_ID`
				WHERE `reply_history`.`reply_ID` = '.$replyID.'
				ORDER BY `reply_ver` DESC';

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
						$info['Thread_Title'] = '';
						$replyContent = stripcslashes($row['reply_content']);

						$imgSql = 'SELECT `img_path` FROM `reply_img` WHERE `reply_ID` = '.$row['reply_ID'].' AND `reply_ver` = '.$row['reply_ver'];
                                        
						$imgResult = mysqli_query($conn, $imgSql);
						if(mysqli_num_rows($imgResult) > 0) {
							while($imgRow = mysqli_fetch_array($imgResult)) {
								$replace = '<img src="../'.$imgRow['img_path'].'">';

								$replyContent = implode($replace, explode('<img src="path_to_thread_img">', $replyContent, 2));
							}
						}

						$info['Post_Content'] = $replyContent;

						$postarray[] = $info;
					}
					echo json_encode(array(true, $postarray));
				} else {
					echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
				}

				break;
			case 9: // retrieve path of images in a post
				$replyID = $_POST['ID'];
				$replyVer = $_POST['postVer'];

				$sql = 'SELECT `img_path` FROM `reply_img` WHERE `reply_ID` = '.$replyID.' AND `reply_ver` = '.$replyVer.' ORDER BY `img_ID`';
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
			case 10: // retrieve replies of user
				$userID = $_POST['userID'];
				
				$sql = 'SELECT `reply`.*, `thread`.`thread_ID`, `thread`.`thread_create`, DATE_FORMAT(`thread`.`thread_create`, "%m%d%y") AS "create_link", DATE_FORMAT(`reply_create`, "%M %e, %Y") AS "create", DATE_FORMAT(`reply_create`, "%Y") AS "create_yr", DATE_FORMAT(`reply_create`, "%h:%i %p") AS "create_time", history.`thread_title`
					FROM `reply`
					JOIN `thread` ON `reply`.`thread_ID` = `thread`.`thread_ID`
					JOIN (
						SELECT content.`thread_ID`, `thread_title`
						FROM `thread_history` content
						INNER JOIN (
							SELECT `thread_ID`, MAX(`thread_ver`) AS "latest_ver"
							FROM `thread_history`
							GROUP BY `thread_ID`
						) ver ON content.`thread_ID` = ver.`thread_ID` AND content.`thread_ver` = ver.`latest_ver`
					) history ON `thread`.`thread_ID` = history.`thread_ID` 
					WHERE `reply_author_ID` = '.$userID.'
					ORDER BY `thread_create` DESC';
					
				$result = mysqli_query($conn, $sql);
				if($result) {
					$replyarray = array();
					while($row = mysqli_fetch_array($result)) {
						$info = array();

						$threadName = preg_replace('/[^a-zA-Z0-9 ]/', '', strtolower($row['thread_title']));
						$threadName = str_replace(' ', '-', $threadName);

						$replyLink = 'forum/thread.php?ID='.$row['thread_ID'].'&reply='.$row['reply_ID'].'/'.$row['create_link'].'/'.$threadName;

						$info['reply_link'] = $replyLink;
						$info['thread_title'] = $row['thread_title'];
						$info['create'] = $row['create'];
						$info['reply_upvotes'] = $row['reply_upvotes'];
						$info['is_answer'] = $row['is_answer'];

						$replyarray[] = $info;
					}
					echo json_encode(array(true, $replyarray));
				} else {
					echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
				}

				break;
        }
	}
	mysqli_close($conn);
?>