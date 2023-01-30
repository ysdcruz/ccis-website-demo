<?php
	include 'dbconn.php';
	session_start();

	if(count($_POST) > 0) {
		switch($_POST['type']) {
			case 1: // create post
				$userID = $_POST['userID'];
				$postTitle = mysqli_real_escape_string($conn, $_POST['postTitle']);
				$postCover = mysqli_real_escape_string($conn, $_POST['postCover']);
				$postCoverCred = (!isset($_POST['postCoverCred']) || empty($_POST['postCoverCred'])) ? null : mysqli_real_escape_string($conn, $_POST['postCoverCred']);
				$postCoverLink = (!isset($_POST['postCoverLink']) || empty($_POST['postCoverLink'])) ? null : mysqli_real_escape_string($conn, $_POST['postCoverLink']);
				$postCoverDesc = (!isset($_POST['postCoverDesc']) || empty($_POST['postCoverDesc'])) ? null : mysqli_real_escape_string($conn, $_POST['postCoverDesc']);
				$postContent = mysqli_real_escape_string($conn, $_POST['postContent']);
				$postType = $_POST['postType'];
				$img = json_decode($_POST['imgSrc'], true);

				$insertID;

				mysqli_begin_transaction($conn);

				try {
					$dateStmt = mysqli_prepare($conn, 'SELECT NOW() AS "datenow"');
					mysqli_stmt_execute($dateStmt);
					$result = mysqli_stmt_get_result($dateStmt);
					$row = mysqli_fetch_array($result);
					$postDate = $row['datenow'];

					$postStmt = mysqli_prepare($conn, 'INSERT INTO `post` (`post_writer_ID`, `post_create`, `post_update`, `post_title`, `post_content`, `post_type`) VALUES (?, ?, ?, ?, ?, ?)');
					mysqli_stmt_bind_param($postStmt, 'isssss', $userID, $postDate, $postDate, $postTitle, $postContent, $postType);
					mysqli_stmt_execute($postStmt);
					$insertID = mysqli_stmt_insert_id($postStmt);

					if(isset($postCover) && !empty($postCover)) {
						$uploadLoc = '../images/content/posts/'.($postType == 'A' ? 'announcements/' : 'news/').'cover/'.$insertID;
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						if(substr($postCover, 0, 4) === 'http') {
							$type = pathinfo(explode('?', $postCover)[0], PATHINFO_EXTENSION);
							$postCover = file_get_contents($postCover);
							$postCover = 'data:image/' . $type . ';base64,' . base64_encode($postCover);
						}

						if(preg_match('/^data:image\/(\w+);base64,/', $postCover, $type)) {
							$postCover = substr($postCover, strpos($postCover, ',') + 1);
							$type = strtolower($type[1]); // jpg, png, gif
							
							if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
								echo json_encode(array(false, 'Invalid image type'));
								exit;
							}
					
							$postCover = str_replace( ' ', '+', $postCover );
							$postCover = base64_decode($postCover);
							
							if($postCover === false) {
								echo json_encode(array(false, 'Error: base64_decode failed'));
								exit;
							}
						} else {
							echo json_encode(array(false, 'Error: Did not match data URI with image data'));
							exit;
						}

						$coverFile = $uploadLoc.'/cover.'.$type;
						
						if(file_exists($coverFile))
							unlink($coverFile);

						file_put_contents($coverFile, $postCover);
						
						$coverSrc = substr($coverFile, 3);
					} else {
						$coverSrc = 'images/content/posts/'.($postType == 'A' ? 'announcements/' : 'news/').'default.png';
						$postCoverCred = null;
						$postCoverLink = null;
						$postCoverDesc = null;
					}

					$coverStmt = mysqli_prepare($conn, 'INSERT INTO `post_cover` (`post_ID`, `cover_img`, `cover_credits`, `cover_link`, `cover_desc`) VALUES (?, ?, ?, ?, ?)');
					mysqli_stmt_bind_param($coverStmt, 'issss', $insertID, $coverSrc, $postCoverCred, $postCoverLink, $postCoverDesc);
					mysqli_stmt_execute($coverStmt);

					if(!empty($img)) {
						$uploadLoc = '../images/content/posts/'.($postType == 'A' ? 'announcements/' : 'news/').$insertID;
						$imgarray = array();
	
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
	
						$files = glob($uploadLoc.'/*');
							foreach($files as $file) {
								if(is_file($file)) {
									unlink($file);
								}
							}
							
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
						
						$imgSql = 'INSERT INTO `post_img` (`post_ID`, `img_path`) VALUES ';

						foreach($imgarray as $imgSrc) {
							$imgSrc = substr($imgSrc, 3);
							$imgSql .= '('.$insertID.', "'.$imgSrc.'"),';
						}
						
						$imgSql = substr($imgSql, 0, -1);

						$imgStmt = mysqli_prepare($conn, $imgSql);
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
			case 2: // retrieve path of images in a post
				$postID = $_POST['postID'];

				$sql = 'SELECT `img_path` FROM `post_img` WHERE `post_ID` = '.$postID.' ORDER BY `img_ID`';
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
			case 3: // update post
				$postID = $_POST['postID'];
				$postTitle = mysqli_real_escape_string($conn, $_POST['postTitle']);
				$postCover = mysqli_real_escape_string($conn, $_POST['postCover']);
				$postCoverCred = (!isset($_POST['postCoverCred']) || empty($_POST['postCoverCred'])) ? null : mysqli_real_escape_string($conn, $_POST['postCoverCred']);
				$postCoverLink = (!isset($_POST['postCoverLink']) || empty($_POST['postCoverLink'])) ? null : mysqli_real_escape_string($conn, $_POST['postCoverLink']);
				$postCoverDesc = (!isset($_POST['postCoverDesc']) || empty($_POST['postCoverDesc'])) ? null : mysqli_real_escape_string($conn, $_POST['postCoverDesc']);
				$postContent = mysqli_real_escape_string($conn, $_POST['postContent']);
				$postType = $_POST['postType'];
				$img = json_decode($_POST['imgSrc'], true);
				$hasContentChanged = $_POST['hasContentChanged'];
				$hasCoverChanged = $_POST['hasCoverChanged'];
				$isCoverRemoved = $_POST['isCoverRemoved'];

				mysqli_begin_transaction($conn);

				try {
					$dateStmt = mysqli_prepare($conn, 'SELECT NOW() AS "datenow"');
					mysqli_stmt_execute($dateStmt);
					$result = mysqli_stmt_get_result($dateStmt);
					$row = mysqli_fetch_array($result);
					$postDate = $row['datenow'];

					$updateStmt = mysqli_prepare($conn, 'UPDATE `post` SET `post_update` = ?, `post_title` = ?, `post_content` = ? WHERE `post_ID` = '.$postID);
					mysqli_stmt_bind_param($updateStmt, 'sss', $postDate, $postTitle, $postContent);
					mysqli_stmt_execute($updateStmt);

					if($hasCoverChanged) {
						if(isset($postCover) && !empty($postCover) && $isCoverRemoved != 'true') {
							$uploadLoc = '../images/content/posts/'.($postType == 'A' ? 'announcements/' : 'news/').'cover/'.$postID;
							
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
							
							if(substr($postCover, 0, 4) === 'http') {
								$type = pathinfo(explode('?', $postCover)[0], PATHINFO_EXTENSION);
								$postCover = file_get_contents($postCover);
								$postCover = 'data:image/' . $type . ';base64,' . base64_encode($postCover);
							}

							if(preg_match('/^data:image\/(\w+);base64,/', $postCover, $type)) {
								$postCover = substr($postCover, strpos($postCover, ',') + 1);
								$type = strtolower($type[1]); // jpg, png, gif
								
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
						
								$postCover = str_replace( ' ', '+', $postCover );
								$postCover = base64_decode($postCover);
								
								if($postCover === false) {
									echo json_encode(array(false, 'Error: base64_decode failed'));
									exit;
								}
							} else {
								echo json_encode(array(false, 'Error: Did not match data URI with image data'));
								exit;
							}
	
							$coverFile = $uploadLoc.'/cover.'.$type;
							
							if(file_exists($coverFile))
								unlink($coverFile);
	
							file_put_contents($coverFile, $postCover);
							
							$coverSrc = substr($coverFile, 3);
	
							$coverStmt = mysqli_prepare($conn, 'UPDATE `post_cover` SET `cover_img` = ?, `cover_credits` = ?, `cover_link` = ?, `cover_desc` = ? WHERE `post_ID` = '.$postID);
							mysqli_stmt_bind_param($coverStmt, 'ssss', $coverSrc, $postCoverCred, $postCoverLink, $postCoverDesc);
						} else if($isCoverRemoved == 'true') { 
							$coverSrc = 'images/content/posts/'.($postType == 'A' ? 'announcements/' : 'news/').'default.png';
							$postCoverCred = null;
							$postCoverLink = null;
							$postCoverDesc = null;
	
							$coverStmt = mysqli_prepare($conn, 'UPDATE `post_cover` SET `cover_img` = ?, `cover_credits` = ?, `cover_link` = ?, `cover_desc` = ? WHERE `post_ID` = '.$postID);
							mysqli_stmt_bind_param($coverStmt, 'ssss', $coverSrc, $postCoverCred, $postCoverLink, $postCoverDesc);
						} else {
							$coverStmt = mysqli_prepare($conn, 'UPDATE `post_cover` SET `cover_credits` = ?, `cover_link` = ?, `cover_desc` = ? WHERE `post_ID` = '.$postID);
							mysqli_stmt_bind_param($coverStmt, 'sss', $postCoverCred, $postCoverLink, $postCoverDesc);
						}

						mysqli_stmt_execute($coverStmt);
					}

					if($hasContentChanged) {
						$delStmt = mysqli_prepare($conn, 'DELETE FROM `post_img` WHERE `post_ID` = '.$postID);
						mysqli_stmt_execute($delStmt);

						if(!empty($img)) {
							$uploadLoc = '../images/content/posts/'.($postType == 'A' ? 'announcements/' : 'news/').$postID;
							$imgarray = array();
		
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
		
							$files = glob($uploadLoc.'/*');
								foreach($files as $file) {
									if(is_file($file)) {
										unlink($file);
									}
								}
								
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
							
							$imgSql = 'INSERT INTO `post_img` (`post_ID`, `img_path`) VALUES ';
	
							foreach($imgarray as $imgSrc) {
								$imgSrc = substr($imgSrc, 3);
								$imgSql .= '('.$postID.', "'.$imgSrc.'"),';
							}
							
							$imgSql = substr($imgSql, 0, -1);
	
							$imgStmt = mysqli_prepare($conn, $imgSql);
							mysqli_stmt_execute($imgStmt);
						}
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 4: // delete post
				$postID = $_POST['postID'];

				mysqli_begin_transaction($conn);

				try {
					$backPostStmt = mysqli_prepare($conn, 'INSERT INTO `post_backup` (`post_ID`, `post_writer_ID`, `post_create`, `post_update`, `post_title`, `post_content`, `post_type`)
						SELECT `post_ID`, `post_writer_ID`, `post_create`, `post_update`, `post_title`, `post_content`, `post_type` 
						FROM `post` 
						WHERE `post_ID` IN ('.$postID.')');
					mysqli_stmt_execute($backPostStmt);

					$backPostCoverStmt = mysqli_prepare($conn, 'INSERT INTO `post_cover_backup` (`post_ID`, `cover_img`, `cover_credits`, `cover_link`, `cover_desc`)
						SELECT `post_ID`, `cover_img`, `cover_credits`, `cover_link`, `cover_desc`
						FROM `post_cover` 
						WHERE `post_ID` IN ('.$postID.')');
					mysqli_stmt_execute($backPostCoverStmt);

					$postImgCtrStmt = mysqli_prepare($conn, 'SELECT COUNT(*) AS "count" FROM `post_img` WHERE `post_ID` IN ('.$postID.')');
					mysqli_stmt_execute($postImgCtrStmt);
					$postImgResult = mysqli_stmt_get_result($postImgCtrStmt);
					$postImgRow = mysqli_fetch_array($postImgResult);
					$postImgCtr = (int)$postImgRow['count'];

					if($postImgCtr > 0) {
						$backPostImgStmt = mysqli_prepare($conn, 'INSERT INTO `post_img_backup` (`img_ID`, `post_ID`, `img_path`)
							SELECT `img_ID`, `post_ID`, `img_path`
							FROM `post_img` IN ('.$postID.')');
						mysqli_stmt_execute($backPostImgStmt);
					}

					$delPostStmt = mysqli_prepare($conn, 'DELETE FROM `post` WHERE `post_ID` IN ('.$postID.')');
					mysqli_stmt_execute($delPostStmt);

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
        }
	}
	mysqli_close($conn);
?>