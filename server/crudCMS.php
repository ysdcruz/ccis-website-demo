<?php
	include 'dbconn.php';
	require ('class-php-ico.php');
	session_start();

	if(count($_POST) > 0) {
		switch($_POST['type']) {
			case 1: // update general
				$hasGenChanged = $_POST['hasGenChanged'];
				$webName = mysqli_real_escape_string($conn, $_POST['webName']);
				$webInit = mysqli_real_escape_string($conn, $_POST['webInit']);
				$webLogo = mysqli_real_escape_string($conn, $_POST['webLogo']);
				$univLogo = mysqli_real_escape_string($conn, $_POST['univLogo']);
				$webCover = mysqli_real_escape_string($conn, $_POST['webCover']);
				$webLinks = json_decode($_POST['webLinks'], true);

				mysqli_begin_transaction($conn);

				try {
					if($hasGenChanged == 'true') {
						$isNewLogo = preg_match('/^data:image\/(\w+);base64,/', $webLogo, $type);
						$isNewUniv = preg_match('/^data:image\/(\w+);base64,/', $univLogo, $type);
						$isNewCover = preg_match('/^data:image\/(\w+);base64,/', $webCover, $type);

						$logoSrc = '';
						$iconSrc = '';
						$univSrc = '';
						$coverSrc = '';

						if($isNewLogo) {
							$uploadLoc = '../images/content/general';
						
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
							
							if(preg_match('/^data:image\/(\w+);base64,/', $webLogo, $type)) {
								$webLogo = substr($webLogo, strpos($webLogo, ',') + 1);
								$type = strtolower($type[1]); // jpg, png, gif
								
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
						
								$webLogo = str_replace(' ', '+', $webLogo);
								$webLogo = base64_decode($webLogo);
								
								if($webLogo === false) {
									echo json_encode(array(false, 'Error: base64_decode failed'));
									exit;
								}
							} else {
								echo json_encode(array(false, 'Error: Did not match data URI with image data'));
								exit;
							}
	
							$logoFile = $uploadLoc.'/logo.'.$type;
							
							if(file_exists($logoFile))
								unlink($logoFile);
	
							file_put_contents($logoFile, $webLogo);
							
							$iconSrc = '../images/content/general/icon.ico';

							if(file_exists($iconSrc))
								unlink($iconSrc);

							$ico_lib = new PHP_ICO($logoFile, array(array(16,16), array(32,32)));
							$ico_lib->save_ico($iconSrc);

							$logoSrc = substr($logoFile, 3);
							$iconSrc = substr($iconSrc, 3);
						}

						if($isNewUniv) {
							$uploadLoc = '../images/content/general';
						
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
							
							if(preg_match('/^data:image\/(\w+);base64,/', $univLogo, $type)) {
								$univLogo = substr($univLogo, strpos($univLogo, ',') + 1);
								$type = strtolower($type[1]); // jpg, png, gif
								
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
						
								$univLogo = str_replace(' ', '+', $univLogo);
								$univLogo = base64_decode($univLogo);
								
								if($univLogo === false) {
									echo json_encode(array(false, 'Error: base64_decode failed'));
									exit;
								}
							} else {
								echo json_encode(array(false, 'Error: Did not match data URI with image data'));
								exit;
							}
	
							$univFile = $uploadLoc.'/univ.'.$type;
							
							if(file_exists($univFile))
								unlink($univFile);
	
							file_put_contents($univFile, $univLogo);
							
							$univSrc = substr($univFile, 3);
						}

						if($isNewCover) {
							$uploadLoc = '../images/content/general';
						
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
							
							if(preg_match('/^data:image\/(\w+);base64,/', $webCover, $type)) {
								$webCover = substr($webCover, strpos($webCover, ',') + 1);
								$type = strtolower($type[1]); // jpg, png, gif
								
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
						
								$webCover = str_replace(' ', '+', $webCover);
								$webCover = base64_decode($webCover);
								
								if($webCover === false) {
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
	
							file_put_contents($coverFile, $webCover);
							
							$coverSrc = substr($coverFile, 3);
						}

						$genSql = 'UPDATE `cms`
							SET `cms_content` = (
								CASE 
									WHEN `cms_desc` = "name" THEN "'.$webName.'"
									WHEN `cms_desc` = "initialism" THEN "'.$webInit.'" ';
						
						if($isNewLogo)
							$genSql .= 'WHEN `cms_desc` = "logo" THEN "'.$logoSrc.'" 
								WHEN `cms_desc` = "logo icon" THEN "'.$iconSrc.'" ';
								
						if($isNewUniv)
							$genSql .= 'WHEN `cms_desc` = "univ" THEN "'.$univSrc.'" ';
								
						if($isNewCover)
							$genSql .= 'WHEN `cms_desc` = "cover" THEN "'.$coverSrc.'" ';
							
						$genSql .= 'END
								)
							WHERE `cms_purpose` = 1 AND `cms_desc` IN ("name", "initialism"';
							
						if($isNewLogo)
							$genSql .= ', "logo", "logo icon"';

						if($isNewUniv)
							$genSql .= ', "univ"';

						if($isNewCover)
							$genSql .= ', "cover"';

						$genSql .= ')';
						
						$genStmt = mysqli_prepare($conn, $genSql);
						mysqli_stmt_execute($genStmt);
					}

					$delStmt = mysqli_prepare($conn, 'DELETE FROM `cms` WHERE `cms_purpose` = 2');
					mysqli_stmt_execute($delStmt);

					if(!empty($webLinks)) {
						$linkSql = 'INSERT INTO `cms` (`cms_purpose`, `cms_desc`, `cms_content`, `cms_link`) VALUES ';

						foreach($webLinks as $link)
							$linkSql .= '(2, "quick link", "'.$link['title'].'", "'.$link['link'].'"), ';

						$linkStmt = mysqli_prepare($conn, substr($linkSql, 0, -2));
						mysqli_stmt_execute($linkStmt);
					}

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 2: // update home
				$hasCoverChanged = $_POST['hasCoverChanged'];
				$homeCover = mysqli_real_escape_string($conn, $_POST['homeCover']);
				$homeTagline = (!isset($_POST['homeTagline']) || empty($_POST['homeTagline'])) ? null : mysqli_real_escape_string($conn, $_POST['homeTagline']);
				$homeTagAlign = mysqli_real_escape_string($conn, $_POST['homeTagAlign']);
				$homeOverview = (!isset($_POST['homeOverview']) || empty($_POST['homeOverview'])) ? null : mysqli_real_escape_string($conn, $_POST['homeOverview']);
				$homeContent = (!isset($_POST['homeContent']) || empty($_POST['homeContent'])) ? null : mysqli_real_escape_string($conn, $_POST['homeContent']);
				$hasPrevChanged = $_POST['hasPrevChanged'];
				$prevBanner = mysqli_real_escape_string($conn, $_POST['prevBanner']);
				$prevMed = (!isset($_POST['prevMed']) || empty($_POST['prevMed'])) ? null : mysqli_real_escape_string($conn, $_POST['prevMed']);
				$prevMedAlign = mysqli_real_escape_string($conn, $_POST['prevMedAlign']);
				$prevLarge = (!isset($_POST['prevLarge']) || empty($_POST['prevLarge'])) ? null : mysqli_real_escape_string($conn, $_POST['prevLarge']);
				$prevLargeAlign = mysqli_real_escape_string($conn, $_POST['prevLargeAlign']);
				$prevSmall = (!isset($_POST['prevSmall']) || empty($_POST['prevSmall'])) ? null : mysqli_real_escape_string($conn, $_POST['prevSmall']);
				$prevSmallAlign = mysqli_real_escape_string($conn, $_POST['prevSmallAlign']);
				$prevBtn = (!isset($_POST['prevBtn']) || empty($_POST['prevBtn'])) ? null : mysqli_real_escape_string($conn, $_POST['prevBtn']);
				$prevBtnAlign = mysqli_real_escape_string($conn, $_POST['prevBtnAlign']);
				$prevBtnLink = (!isset($_POST['prevBtnLink']) || empty($_POST['prevBtnLink'])) ? null : mysqli_real_escape_string($conn, $_POST['prevBtnLink']);

				mysqli_begin_transaction($conn);

				try {
					if($hasCoverChanged == 'true') {
						$uploadLoc = '../images/content/home';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						if(preg_match('/^data:image\/(\w+);base64,/', $homeCover, $type)) {
							$homeCover = substr($homeCover, strpos($homeCover, ',') + 1);
							$type = strtolower($type[1]); // jpg, png, gif
							
							if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
								echo json_encode(array(false, 'Invalid image type'));
								exit;
							}
					
							$homeCover = str_replace(' ', '+', $homeCover);
							$homeCover = base64_decode($homeCover);
							
							if($homeCover === false) {
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

						file_put_contents($coverFile, $homeCover);
						
						$coverSrc = substr($coverFile, 3);
						
						$coverStmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_purpose` = 3 AND `cms_desc` = "cover"');
						mysqli_stmt_bind_param($coverStmt, 's', $coverSrc);
						mysqli_stmt_execute($coverStmt);
					}

					if($hasPrevChanged == 'true') {
						$uploadLoc = '../images/content/home';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						if(preg_match('/^data:image\/(\w+);base64,/', $prevBanner, $type)) {
							$prevBanner = substr($prevBanner, strpos($prevBanner, ',') + 1);
							$type = strtolower($type[1]); // jpg, png, gif
							
							if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
								echo json_encode(array(false, 'Invalid image type'));
								exit;
							}
					
							$prevBanner = str_replace(' ', '+', $prevBanner);
							$prevBanner = base64_decode($prevBanner);
							
							if($prevBanner === false) {
								echo json_encode(array(false, 'Error: base64_decode failed'));
								exit;
							}
						} else {
							echo json_encode(array(false, 'Error: Did not match data URI with image data'));
							exit;
						}

						$prevFile = $uploadLoc.'/preview.'.$type;
						
						if(file_exists($prevFile))
							unlink($prevFile);

						file_put_contents($prevFile, $prevBanner);
						
						$prevSrc = substr($prevFile, 3);
						
						$prevStmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_purpose` = 3 AND `cms_desc` = "banner"');
						mysqli_stmt_bind_param($prevStmt, 's', $prevSrc);
						mysqli_stmt_execute($prevStmt);
					}

					$homeSql = 'UPDATE `cms`
						SET `cms_content` = (
							CASE 
								WHEN `cms_desc` = "tagline" THEN ?
								WHEN `cms_desc` = "overview" THEN ?
								WHEN `cms_desc` = "overview content" THEN ?
								WHEN `cms_desc` = "banner med" THEN ?
								WHEN `cms_desc` = "banner large" THEN ?
								WHEN `cms_desc` = "banner small" THEN ?
								WHEN `cms_desc` = "banner button" THEN ?
							END
							),
						`cms_align` = (
							CASE
								WHEN `cms_desc` = "tagline" THEN ?
								WHEN `cms_desc` = "banner med" THEN ?
								WHEN `cms_desc` = "banner large" THEN ?
								WHEN `cms_desc` = "banner small" THEN ?
								WHEN `cms_desc` = "banner button" THEN ?
								ELSE NULL
							END
							),
						`cms_link` = (
							CASE
								WHEN `cms_desc` = "banner button" THEN ?
								ELSE NULL
							END
							)
						WHERE `cms_purpose` = 3 AND `cms_desc` IN ("tagline", "overview", "overview content", "banner med", "banner large", "banner small", "banner button")';
					
					$homeStmt = mysqli_prepare($conn, $homeSql);
					mysqli_stmt_bind_param($homeStmt, 'sssssssssssss', $homeTagline, $homeOverview, $homeContent, $prevMed, $prevLarge, $prevSmall, $prevBtn, $homeTagAlign, $prevMedAlign, $prevLargeAlign, $prevSmallAlign, $prevBtnAlign, $prevBtnLink);
					mysqli_stmt_execute($homeStmt);

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 3: // update about overview
				$aboutOverview = (!isset($_POST['aboutOverview']) || empty($_POST['aboutOverview'])) ? null : mysqli_real_escape_string($conn, $_POST['aboutOverview']);
				$aboutContent = (!isset($_POST['aboutContent']) || empty($_POST['aboutContent'])) ? null : mysqli_real_escape_string($conn, $_POST['aboutContent']);
				$hasPrevChanged = $_POST['hasPrevChanged'];
				$prevBanner = mysqli_real_escape_string($conn, $_POST['prevBanner']);
				$prevMed = (!isset($_POST['prevMed']) || empty($_POST['prevMed'])) ? null : mysqli_real_escape_string($conn, $_POST['prevMed']);
				$prevMedAlign = mysqli_real_escape_string($conn, $_POST['prevMedAlign']);
				$prevLarge = (!isset($_POST['prevLarge']) || empty($_POST['prevLarge'])) ? null : mysqli_real_escape_string($conn, $_POST['prevLarge']);
				$prevLargeAlign = mysqli_real_escape_string($conn, $_POST['prevLargeAlign']);
				$prevSmall = (!isset($_POST['prevSmall']) || empty($_POST['prevSmall'])) ? null : mysqli_real_escape_string($conn, $_POST['prevSmall']);
				$prevSmallAlign = mysqli_real_escape_string($conn, $_POST['prevSmallAlign']);
				$prevBtn = (!isset($_POST['prevBtn']) || empty($_POST['prevBtn'])) ? null : mysqli_real_escape_string($conn, $_POST['prevBtn']);
				$prevBtnAlign = mysqli_real_escape_string($conn, $_POST['prevBtnAlign']);
				$prevBtnLink = (!isset($_POST['prevBtnLink']) || empty($_POST['prevBtnLink'])) ? null : mysqli_real_escape_string($conn, $_POST['prevBtnLink']);
				$hasPrev1Changed = $_POST['hasPrev1Changed'];
				$prev1Img = mysqli_real_escape_string($conn, $_POST['prev1Img']);
				$prev1 = (!isset($_POST['prev1']) || empty($_POST['prev1'])) ? null : mysqli_real_escape_string($conn, $_POST['prev1']);
				$prev1Link = (!isset($_POST['prev1Link']) || empty($_POST['prev1Link'])) ? null : mysqli_real_escape_string($conn, $_POST['prev1Link']);
				$hasPrev2Changed = $_POST['hasPrev2Changed'];
				$prev2Img = mysqli_real_escape_string($conn, $_POST['prev2Img']);
				$prev2 = (!isset($_POST['prev2']) || empty($_POST['prev2'])) ? null : mysqli_real_escape_string($conn, $_POST['prev2']);
				$prev2Link = (!isset($_POST['prev2Link']) || empty($_POST['prev2Link'])) ? null : mysqli_real_escape_string($conn, $_POST['prev2Link']);

				mysqli_begin_transaction($conn);

				try {
					if($hasPrevChanged == 'true') {
						$uploadLoc = '../images/content/about';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						if(preg_match('/^data:image\/(\w+);base64,/', $prevBanner, $type)) {
							$prevBanner = substr($prevBanner, strpos($prevBanner, ',') + 1);
							$type = strtolower($type[1]); // jpg, png, gif
							
							if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
								echo json_encode(array(false, 'Invalid image type'));
								exit;
							}
					
							$prevBanner = str_replace(' ', '+', $prevBanner);
							$prevBanner = base64_decode($prevBanner);
							
							if($prevBanner === false) {
								echo json_encode(array(false, 'Error: base64_decode failed'));
								exit;
							}
						} else {
							echo json_encode(array(false, 'Error: Did not match data URI with image data'));
							exit;
						}

						$prevFile = $uploadLoc.'/preview.'.$type;
						
						if(file_exists($prevFile))
							unlink($prevFile);

						file_put_contents($prevFile, $prevBanner);
						
						$prevSrc = substr($prevFile, 3);
						
						$prevStmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_purpose` = 4 AND `cms_desc` = "banner"');
						mysqli_stmt_bind_param($prevStmt, 's', $prevSrc);
						mysqli_stmt_execute($prevStmt);
					}

					if($hasPrev1Changed == 'true') {
						$uploadLoc = '../images/content/about';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						if(preg_match('/^data:image\/(\w+);base64,/', $prev1Img, $type)) {
							$prev1Img = substr($prev1Img, strpos($prev1Img, ',') + 1);
							$type = strtolower($type[1]); // jpg, png, gif
							
							if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
								echo json_encode(array(false, 'Invalid image type'));
								exit;
							}
					
							$prev1Img = str_replace(' ', '+', $prev1Img);
							$prev1Img = base64_decode($prev1Img);
							
							if($prev1Img === false) {
								echo json_encode(array(false, 'Error: base64_decode failed'));
								exit;
							}
						} else {
							echo json_encode(array(false, 'Error: Did not match data URI with image data'));
							exit;
						}

						$prev1File = $uploadLoc.'/preview-1.'.$type;
						
						if(file_exists($prev1File))
							unlink($prev1File);

						file_put_contents($prev1File, $prev1Img);
						
						$prev1Src = substr($prev1File, 3);
						
						$prev1Stmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_purpose` = 4 AND `cms_desc` = "preview image 1"');
						mysqli_stmt_bind_param($prev1Stmt, 's', $prev1Src);
						mysqli_stmt_execute($prev1Stmt);
					}

					if($hasPrev2Changed == 'true') {
						$uploadLoc = '../images/content/about';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						if(preg_match('/^data:image\/(\w+);base64,/', $prev2Img, $type)) {
							$prev2Img = substr($prev2Img, strpos($prev2Img, ',') + 1);
							$type = strtolower($type[1]); // jpg, png, gif
							
							if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
								echo json_encode(array(false, 'Invalid image type'));
								exit;
							}
					
							$prev2Img = str_replace(' ', '+', $prev2Img);
							$prev2Img = base64_decode($prev2Img);
							
							if($prev2Img === false) {
								echo json_encode(array(false, 'Error: base64_decode failed'));
								exit;
							}
						} else {
							echo json_encode(array(false, 'Error: Did not match data URI with image data'));
							exit;
						}

						$prev2File = $uploadLoc.'/preview-2.'.$type;
						
						if(file_exists($prev2File))
							unlink($prev2File);

						file_put_contents($prev2File, $prev2Img);
						
						$prev2Src = substr($prev2File, 3);
						
						$prev2Stmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_purpose` = 4 AND `cms_desc` = "preview image 2"');
						mysqli_stmt_bind_param($prev2Stmt, 's', $prev2Src);
						mysqli_stmt_execute($prev2Stmt);
					}

					$aboutSql = 'UPDATE `cms`
						SET `cms_content` = (
							CASE 
								WHEN `cms_desc` = "overview" THEN ?
								WHEN `cms_desc` = "overview content" THEN ?
								WHEN `cms_desc` = "banner med" THEN ?
								WHEN `cms_desc` = "banner large" THEN ?
								WHEN `cms_desc` = "banner small" THEN ?
								WHEN `cms_desc` = "banner button" THEN ?
								WHEN `cms_desc` = "preview 1" THEN ?
								WHEN `cms_desc` = "preview 2" THEN ?
							END
							),
						`cms_align` = (
							CASE
								WHEN `cms_desc` = "banner med" THEN ?
								WHEN `cms_desc` = "banner large" THEN ?
								WHEN `cms_desc` = "banner small" THEN ?
								WHEN `cms_desc` = "banner button" THEN ?
								ELSE NULL
							END
							),
						`cms_link` = (
							CASE
								WHEN `cms_desc` = "banner button" THEN ?
								WHEN `cms_desc` = "preview 1" THEN ?
								WHEN `cms_desc` = "preview 2" THEN ?
								ELSE NULL
							END
							)
						WHERE `cms_purpose` = 4 AND `cms_desc` IN ("overview", "overview content", "banner med", "banner large", "banner small", "banner button", "preview 1", "preview 2")';
					
					$aboutStmt = mysqli_prepare($conn, $aboutSql);
					mysqli_stmt_bind_param($aboutStmt, 'sssssssssssssss', $aboutOverview, $aboutContent, $prevMed, $prevLarge, $prevSmall, $prevBtn, $prev1, $prev2, $prevMedAlign, $prevLargeAlign, $prevSmallAlign, $prevBtnAlign, $prevBtnLink, $prev1Link, $prev2Link);
					mysqli_stmt_execute($aboutStmt);

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}
				
				break;
			case 4: // update about history
				$hasImgChanged = $_POST['hasImgChanged'];
				$contentImg = json_decode($_POST['contentImg'], true);
				$pageContent = (!isset($_POST['pageContent']) || empty($_POST['pageContent'])) ? null : mysqli_real_escape_string($conn, $_POST['pageContent']);
				$imgExist = array();

				try {
					if($hasImgChanged == 'true') {
						$uploadLoc = '../images/content/about/history';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						$delStmt = mysqli_prepare($conn, 'DELETE FROM `cms_history_img`');
						mysqli_stmt_execute($delStmt);

						$newSql = 'INSERT INTO `cms_history_img` (`img_ID`, `img_path`, `img_credit`, `img_link`, `img_desc`) VALUES ';

						for($i = 0; $i < count($contentImg); $i++) {
							$imgID = $contentImg[$i]['img_ID'];
							$img = $contentImg[$i]['img_path'];
							$credit = empty($contentImg[$i]['img_credit']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $contentImg[$i]['img_credit']).'"';
							$link = empty($contentImg[$i]['img_link']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $contentImg[$i]['img_link']).'"';
							$desc = empty($contentImg[$i]['img_desc']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $contentImg[$i]['img_desc']).'"';
							$imgSrc = '';

							if(preg_match('/^data:image\/(\w+);base64,/', $img, $type)) {
								$img = substr($img, strpos($img, ',') + 1);
								$type = strtolower($type[1]); // jpg, png, gif
								
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
						
								$img = str_replace(' ', '+', $img);
								$img = base64_decode($img);
								
								if($img === false) {
									echo json_encode(array(false, 'Error: base64_decode failed'));
									exit;
								}

								$imgFile = $uploadLoc.'/'.uniqid(date('Ymd').'-' , true).'.'.$type;
								
								if(file_exists($imgFile))
									unlink($imgFile);
		
								file_put_contents($imgFile, $img);
								$imgExist[] = $imgFile;
							} else if($imgID != '0') {
								$path = substr($img, 3);
								$path = explode('?', $path)[0];
								$type = pathinfo($path, PATHINFO_EXTENSION);

								$imgFile = $uploadLoc.'/'.uniqid(date('Ymd').'-' , true).'.'.$type;

								rename($path, $imgFile);
								$imgExist[] = $imgFile;
							} else {
								echo json_encode(array(false, 'Error: Did not match data URI with image data'));
								exit;
							}
							$imgSrc = substr($imgFile, 3);
	
							$newSql .= '('.($i + 1).', "'.$imgSrc.'", '.$credit.', '.$link.', '.$desc.'), ';
						}
						$newSql = substr($newSql, 0, -2);
						$newStmt = mysqli_prepare($conn, $newSql);
						mysqli_stmt_execute($newStmt);
					}
					
					$contentStmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_purpose` = 5 AND `cms_desc` = "content"');
					mysqli_stmt_bind_param($contentStmt, 's', $pageContent);
					mysqli_stmt_execute($contentStmt);

					mysqli_commit($conn);
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
					exit();
				}
				
				if(!empty($imgExist)) {
					$files = glob('../images/content/about/history/*');
					foreach($files as $file) {
						if(!in_array($file, $imgExist)) {
							unlink($file);
						}
					}
				}
				
				echo json_encode(array(true));

				break;
			case 5: // update about mission
				$pageContent = (!isset($_POST['pageContent']) || empty($_POST['pageContent'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['pageContent']).'"';

				$sql = 'UPDATE `cms` 
					SET `cms_content` = '.$pageContent.'
					WHERE `cms_purpose` = 6 AND `cms_desc` = "mission"';
					
				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 6: // update about contact
				$address = (!isset($_POST['address']) || empty($_POST['address'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['address']).'"';
				$email = (!isset($_POST['email']) || empty($_POST['email'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['email']).'"';
				$fbName = (!isset($_POST['fbName']) || empty($_POST['fbName'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['fbName']).'"';
				$fbPage = (!isset($_POST['fbPage']) || empty($_POST['fbPage'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['fbPage']).'"';
				$twtName = (!isset($_POST['twtName']) || empty($_POST['twtName'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['twtName']).'"';
				$twtPage = (!isset($_POST['twtPage']) || empty($_POST['twtPage'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['twtPage']).'"';
				$direct1Name = (!isset($_POST['direct1Name']) || empty($_POST['direct1Name'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['direct1Name']).'"';
				$direct1Num = (!isset($_POST['direct1Num']) || empty($_POST['direct1Num'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['direct1Num']).'"';
				$direct2Name = (!isset($_POST['direct2Name']) || empty($_POST['direct2Name'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['direct2Name']).'"';$direct2Num = (!isset($_POST['direct2Num']) || empty($_POST['direct2Num'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['direct2Num']).'"';
				$trunkLine = (!isset($_POST['trunkLine']) || empty($_POST['trunkLine'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['trunkLine']).'"';
				$local1Name = (!isset($_POST['local1Name']) || empty($_POST['local1Name'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['local1Name']).'"';
				$local1Num = (!isset($_POST['local1Num']) || empty($_POST['local1Num'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['local1Num']).'"';
				$local2Name = (!isset($_POST['local2Name']) || empty($_POST['local2Name'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['local2Name']).'"';
				$local2Num = (!isset($_POST['local2Num']) || empty($_POST['local2Num'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['local2Num']).'"';
				$local3Name = (!isset($_POST['local3Name']) || empty($_POST['local3Name'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['local3Name']).'"';
				$local3Num = (!isset($_POST['local3Num']) || empty($_POST['local3Num'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['local3Num']).'"';
					
				$sql = 'UPDATE `cms`
					SET `cms_content` = (
						CASE 
							WHEN `cms_desc` = "address" THEN '.$address.'
							WHEN `cms_desc` = "email" THEN '.$email.'
							WHEN `cms_desc` = "facebook" THEN '.$fbName.'
							WHEN `cms_desc` = "twitter" THEN '.$twtName.'
							WHEN `cms_desc` = "direct 1" THEN '.$direct1Name.'
							WHEN `cms_desc` = "direct 2" THEN '.$direct2Name.'
							WHEN `cms_desc` = "trunk" THEN '.$trunkLine.'
							WHEN `cms_desc` = "local 1" THEN '.$local1Name.'
							WHEN `cms_desc` = "local 2" THEN '.$local2Name.'
							WHEN `cms_desc` = "local 3" THEN '.$local3Name.'
						END
						),
					`cms_link` = (
						CASE
							WHEN `cms_desc` = "facebook" THEN '.$fbPage.'
							WHEN `cms_desc` = "twitter" THEN '.$twtPage.'
							WHEN `cms_desc` = "direct 1" THEN '.$direct1Num.'
							WHEN `cms_desc` = "direct 2" THEN '.$direct2Num.'
							WHEN `cms_desc` = "local 1" THEN '.$local1Num.'
							WHEN `cms_desc` = "local 2" THEN '.$local2Num.'
							WHEN `cms_desc` = "local 3" THEN '.$local3Num.'
						END
						)
					WHERE `cms_purpose` = 7 AND `cms_desc` IN ("address", "email", "facebook", "twitter", "direct 1", "direct 2", "trunk", "local 1", "local 2", "local 3")';
					
				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 7: // update student overview
				$studOverview = (!isset($_POST['studOverview']) || empty($_POST['studOverview'])) ? null : mysqli_real_escape_string($conn, $_POST['studOverview']);
				$studContent = (!isset($_POST['studContent']) || empty($_POST['studContent'])) ? null : mysqli_real_escape_string($conn, $_POST['studContent']);
				$hasPrevChanged = $_POST['hasPrevChanged'];
				$prevBanner = mysqli_real_escape_string($conn, $_POST['prevBanner']);
				$prevMed = (!isset($_POST['prevMed']) || empty($_POST['prevMed'])) ? null : mysqli_real_escape_string($conn, $_POST['prevMed']);
				$prevMedAlign = mysqli_real_escape_string($conn, $_POST['prevMedAlign']);
				$prevLarge = (!isset($_POST['prevLarge']) || empty($_POST['prevLarge'])) ? null : mysqli_real_escape_string($conn, $_POST['prevLarge']);
				$prevLargeAlign = mysqli_real_escape_string($conn, $_POST['prevLargeAlign']);
				$prevSmall = (!isset($_POST['prevSmall']) || empty($_POST['prevSmall'])) ? null : mysqli_real_escape_string($conn, $_POST['prevSmall']);
				$prevSmallAlign = mysqli_real_escape_string($conn, $_POST['prevSmallAlign']);
				$prevBtn = (!isset($_POST['prevBtn']) || empty($_POST['prevBtn'])) ? null : mysqli_real_escape_string($conn, $_POST['prevBtn']);
				$prevBtnAlign = mysqli_real_escape_string($conn, $_POST['prevBtnAlign']);
				$prevBtnLink = (!isset($_POST['prevBtnLink']) || empty($_POST['prevBtnLink'])) ? null : mysqli_real_escape_string($conn, $_POST['prevBtnLink']);
				$hasPrev1Changed = $_POST['hasPrev1Changed'];
				$prev1Img = mysqli_real_escape_string($conn, $_POST['prev1Img']);
				$prev1 = (!isset($_POST['prev1']) || empty($_POST['prev1'])) ? null : mysqli_real_escape_string($conn, $_POST['prev1']);
				$prev1Link = (!isset($_POST['prev1Link']) || empty($_POST['prev1Link'])) ? null : mysqli_real_escape_string($conn, $_POST['prev1Link']);
				$hasPrev2Changed = $_POST['hasPrev2Changed'];
				$prev2Img = mysqli_real_escape_string($conn, $_POST['prev2Img']);
				$prev2 = (!isset($_POST['prev2']) || empty($_POST['prev2'])) ? null : mysqli_real_escape_string($conn, $_POST['prev2']);
				$prev2Link = (!isset($_POST['prev2Link']) || empty($_POST['prev2Link'])) ? null : mysqli_real_escape_string($conn, $_POST['prev2Link']);
				$hasPrev3Changed = $_POST['hasPrev3Changed'];
				$prev3Img = mysqli_real_escape_string($conn, $_POST['prev3Img']);
				$prev3 = (!isset($_POST['prev3']) || empty($_POST['prev3'])) ? null : mysqli_real_escape_string($conn, $_POST['prev3']);
				$prev3Link = (!isset($_POST['prev3Link']) || empty($_POST['prev3Link'])) ? null : mysqli_real_escape_string($conn, $_POST['prev3Link']);

				mysqli_begin_transaction($conn);

				try {
					if($hasPrevChanged == 'true') {
						$uploadLoc = '../images/content/student';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						if(preg_match('/^data:image\/(\w+);base64,/', $prevBanner, $type)) {
							$prevBanner = substr($prevBanner, strpos($prevBanner, ',') + 1);
							$type = strtolower($type[1]); // jpg, png, gif
							
							if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
								echo json_encode(array(false, 'Invalid image type'));
								exit;
							}
					
							$prevBanner = str_replace(' ', '+', $prevBanner);
							$prevBanner = base64_decode($prevBanner);
							
							if($prevBanner === false) {
								echo json_encode(array(false, 'Error: base64_decode failed'));
								exit;
							}
						} else {
							echo json_encode(array(false, 'Error: Did not match data URI with image data'));
							exit;
						}

						$prevFile = $uploadLoc.'/preview.'.$type;
						
						if(file_exists($prevFile))
							unlink($prevFile);

						file_put_contents($prevFile, $prevBanner);
						
						$prevSrc = substr($prevFile, 3);
						
						$prevStmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_purpose` = 8 AND `cms_desc` = "banner"');
						mysqli_stmt_bind_param($prevStmt, 's', $prevSrc);
						mysqli_stmt_execute($prevStmt);
					}

					if($hasPrev1Changed == 'true') {
						$uploadLoc = '../images/content/student';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						if(preg_match('/^data:image\/(\w+);base64,/', $prev1Img, $type)) {
							$prev1Img = substr($prev1Img, strpos($prev1Img, ',') + 1);
							$type = strtolower($type[1]); // jpg, png, gif
							
							if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
								echo json_encode(array(false, 'Invalid image type'));
								exit;
							}
					
							$prev1Img = str_replace(' ', '+', $prev1Img);
							$prev1Img = base64_decode($prev1Img);
							
							if($prev1Img === false) {
								echo json_encode(array(false, 'Error: base64_decode failed'));
								exit;
							}
						} else {
							echo json_encode(array(false, 'Error: Did not match data URI with image data'));
							exit;
						}

						$prev1File = $uploadLoc.'/preview-1.'.$type;
						
						if(file_exists($prev1File))
							unlink($prev1File);

						file_put_contents($prev1File, $prev1Img);
						
						$prev1Src = substr($prev1File, 3);
						
						$prev1Stmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_purpose` = 8 AND `cms_desc` = "preview image 1"');
						mysqli_stmt_bind_param($prev1Stmt, 's', $prev1Src);
						mysqli_stmt_execute($prev1Stmt);
					}

					if($hasPrev2Changed == 'true') {
						$uploadLoc = '../images/content/student';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						if(preg_match('/^data:image\/(\w+);base64,/', $prev2Img, $type)) {
							$prev2Img = substr($prev2Img, strpos($prev2Img, ',') + 1);
							$type = strtolower($type[1]); // jpg, png, gif
							
							if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
								echo json_encode(array(false, 'Invalid image type'));
								exit;
							}
					
							$prev2Img = str_replace(' ', '+', $prev2Img);
							$prev2Img = base64_decode($prev2Img);
							
							if($prev2Img === false) {
								echo json_encode(array(false, 'Error: base64_decode failed'));
								exit;
							}
						} else {
							echo json_encode(array(false, 'Error: Did not match data URI with image data'));
							exit;
						}

						$prev2File = $uploadLoc.'/preview-2.'.$type;
						
						if(file_exists($prev2File))
							unlink($prev2File);

						file_put_contents($prev2File, $prev2Img);
						
						$prev2Src = substr($prev2File, 3);
						
						$prev2Stmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_purpose` = 8 AND `cms_desc` = "preview image 2"');
						mysqli_stmt_bind_param($prev2Stmt, 's', $prev2Src);
						mysqli_stmt_execute($prev2Stmt);
					}

					if($hasPrev3Changed == 'true') {
						$uploadLoc = '../images/content/student';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);
						
						if(preg_match('/^data:image\/(\w+);base64,/', $prev3Img, $type)) {
							$prev3Img = substr($prev3Img, strpos($prev3Img, ',') + 1);
							$type = strtolower($type[1]); // jpg, png, gif
							
							if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
								echo json_encode(array(false, 'Invalid image type'));
								exit;
							}
					
							$prev3Img = str_replace(' ', '+', $prev3Img);
							$prev3Img = base64_decode($prev3Img);
							
							if($prev3Img === false) {
								echo json_encode(array(false, 'Error: base64_decode failed'));
								exit;
							}
						} else {
							echo json_encode(array(false, 'Error: Did not match data URI with image data'));
							exit;
						}

						$prev3File = $uploadLoc.'/preview-3.'.$type;
						
						if(file_exists($prev3File))
							unlink($prev3File);

						file_put_contents($prev3File, $prev3Img);
						
						$prev3Src = substr($prev3File, 3);
						
						$prev3Stmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_purpose` = 8 AND `cms_desc` = "preview image 3"');
						mysqli_stmt_bind_param($prev3Stmt, 's', $prev3Src);
						mysqli_stmt_execute($prev3Stmt);
					}

					$studSql = 'UPDATE `cms`
						SET `cms_content` = (
							CASE 
								WHEN `cms_desc` = "overview" THEN ?
								WHEN `cms_desc` = "overview content" THEN ?
								WHEN `cms_desc` = "banner med" THEN ?
								WHEN `cms_desc` = "banner large" THEN ?
								WHEN `cms_desc` = "banner small" THEN ?
								WHEN `cms_desc` = "banner button" THEN ?
								WHEN `cms_desc` = "preview 1" THEN ?
								WHEN `cms_desc` = "preview 2" THEN ?
								WHEN `cms_desc` = "preview 3" THEN ?
							END
							),
						`cms_align` = (
							CASE
								WHEN `cms_desc` = "banner med" THEN ?
								WHEN `cms_desc` = "banner large" THEN ?
								WHEN `cms_desc` = "banner small" THEN ?
								WHEN `cms_desc` = "banner button" THEN ?
								ELSE NULL
							END
							),
						`cms_link` = (
							CASE
								WHEN `cms_desc` = "banner button" THEN ?
								WHEN `cms_desc` = "preview 1" THEN ?
								WHEN `cms_desc` = "preview 2" THEN ?
								WHEN `cms_desc` = "preview 3" THEN ?
								ELSE NULL
							END
							)
						WHERE `cms_purpose` = 8 AND `cms_desc` IN ("overview", "overview content", "banner med", "banner large", "banner small", "banner button", "preview 1", "preview 2", "preview 3")';
					
					$studStmt = mysqli_prepare($conn, $studSql);
					mysqli_stmt_bind_param($studStmt, 'sssssssssssssssss', $studOverview, $studContent, $prevMed, $prevLarge, $prevSmall, $prevBtn, $prev1, $prev2, $prev3, $prevMedAlign, $prevLargeAlign, $prevSmallAlign, $prevBtnAlign, $prevBtnLink, $prev1Link, $prev2Link, $prev3Link);
					mysqli_stmt_execute($studStmt);

					mysqli_commit($conn);
					echo json_encode(array(true));
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
				}

				break;
			case 8: // update student programs
				$progContent = (!isset($_POST['progContent']) || empty($_POST['progContent'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progContent']).'"';
				$progName1 = (!isset($_POST['progName1']) || empty($_POST['progName1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progName1']).'"';
				$progDesc1 = (!isset($_POST['progDesc1']) || empty($_POST['progDesc1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progDesc1']).'"';
				$progMission1 = (!isset($_POST['progMission1']) || empty($_POST['progMission1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progMission1']).'"';
				$progObjIntro1 = (!isset($_POST['progObjIntro1']) || empty($_POST['progObjIntro1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progObjIntro1']).'"';
				$progObj1 = (!isset($_POST['progObj1']) || empty($_POST['progObj1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progObj1']).'"';
				$progAdmIntro1 = (!isset($_POST['progAdmIntro1']) || empty($_POST['progAdmIntro1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progAdmIntro1']).'"';
				$progFresh1 = (!isset($_POST['progFresh1']) || empty($_POST['progFresh1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progFresh1']).'"';
				$progShift1 = (!isset($_POST['progShift1']) || empty($_POST['progShift1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progShift1']).'"';
				$progTrans1 = (!isset($_POST['progTrans1']) || empty($_POST['progTrans1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progTrans1']).'"';
				$progRet1 = (!isset($_POST['progRet1']) || empty($_POST['progRet1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progRet1']).'"';
				$progGrad1 = (!isset($_POST['progGrad1']) || empty($_POST['progGrad1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progGrad1']).'"';
				$progCareer1 = (!isset($_POST['progCareer1']) || empty($_POST['progCareer1'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progCareer1']).'"';
				
				$progName2 = (!isset($_POST['progName2']) || empty($_POST['progName2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progName2']).'"';
				$progDesc2 = (!isset($_POST['progDesc2']) || empty($_POST['progDesc2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progDesc2']).'"';
				$progMission2 = (!isset($_POST['progMission2']) || empty($_POST['progMission2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progMission2']).'"';
				$progObjIntro2 = (!isset($_POST['progObjIntro2']) || empty($_POST['progObjIntro2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progObjIntro2']).'"';
				$progObj2 = (!isset($_POST['progObj2']) || empty($_POST['progObj2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progObj2']).'"';
				$progAdmIntro2 = (!isset($_POST['progAdmIntro2']) || empty($_POST['progAdmIntro2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progAdmIntro2']).'"';
				$progFresh2 = (!isset($_POST['progFresh2']) || empty($_POST['progFresh2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progFresh2']).'"';
				$progShift2 = (!isset($_POST['progShift2']) || empty($_POST['progShift2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progShift2']).'"';
				$progTrans2 = (!isset($_POST['progTrans2']) || empty($_POST['progTrans2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progTrans2']).'"';
				$progRet2 = (!isset($_POST['progRet2']) || empty($_POST['progRet2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progRet2']).'"';
				$progGrad2 = (!isset($_POST['progGrad2']) || empty($_POST['progGrad2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progGrad2']).'"';
				$progCareer2 = (!isset($_POST['progCareer2']) || empty($_POST['progCareer2'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progCareer2']).'"';
				
				$progName3 = (!isset($_POST['progName3']) || empty($_POST['progName3'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progName3']).'"';
				$progDesc3 = (!isset($_POST['progDesc3']) || empty($_POST['progDesc3'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progDesc3']).'"';
				$progObjIntro3 = (!isset($_POST['progObjIntro3']) || empty($_POST['progObjIntro3'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progObjIntro3']).'"';
				$progObj3 = (!isset($_POST['progObj3']) || empty($_POST['progObj3'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progObj3']).'"';
				$progProv3 = (!isset($_POST['progProv3']) || empty($_POST['progProv3'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['progProv3']).'"';

				$sql = 'UPDATE `cms`
					SET `cms_content` = (
						CASE 
							WHEN `cms_desc` = "overview content" THEN '.$progContent.'
							WHEN `cms_desc` = "program 1" THEN '.$progName1.'
							WHEN `cms_desc` = "program 1 desc" THEN '.$progDesc1.'
							WHEN `cms_desc` = "program 1 mission" THEN '.$progMission1.'
							WHEN `cms_desc` = "program 1 obj intro" THEN '.$progObjIntro1.'
							WHEN `cms_desc` = "program 1 obj" THEN '.$progObj1.'
							WHEN `cms_desc` = "program 1 adm intro" THEN '.$progAdmIntro1.'
							WHEN `cms_desc` = "program 1 reqs freshmen" THEN '.$progFresh1.'
							WHEN `cms_desc` = "program 1 reqs shiftee" THEN '.$progShift1.'
							WHEN `cms_desc` = "program 1 reqs transferee" THEN '.$progTrans1.'
							WHEN `cms_desc` = "program 1 retention" THEN '.$progRet1.'
							WHEN `cms_desc` = "program 1 grad" THEN '.$progGrad1.'
							WHEN `cms_desc` = "program 1 career" THEN '.$progCareer1.'
							WHEN `cms_desc` = "program 2" THEN '.$progName2.'
							WHEN `cms_desc` = "program 2 desc" THEN '.$progDesc2.'
							WHEN `cms_desc` = "program 2 mission" THEN '.$progMission2.'
							WHEN `cms_desc` = "program 2 obj intro" THEN '.$progObjIntro2.'
							WHEN `cms_desc` = "program 2 obj" THEN '.$progObj2.'
							WHEN `cms_desc` = "program 2 adm intro" THEN '.$progAdmIntro2.'
							WHEN `cms_desc` = "program 2 reqs freshmen" THEN '.$progFresh2.'
							WHEN `cms_desc` = "program 2 reqs shiftee" THEN '.$progShift2.'
							WHEN `cms_desc` = "program 2 reqs transferee" THEN '.$progTrans2.'
							WHEN `cms_desc` = "program 2 retention" THEN '.$progRet2.'
							WHEN `cms_desc` = "program 2 grad" THEN '.$progGrad2.'
							WHEN `cms_desc` = "program 2 career" THEN '.$progCareer2.'
							WHEN `cms_desc` = "program 3" THEN '.$progName3.'
							WHEN `cms_desc` = "program 3 desc" THEN '.$progDesc3.'
							WHEN `cms_desc` = "program 3 obj intro" THEN '.$progObjIntro3.'
							WHEN `cms_desc` = "program 3 obj" THEN '.$progObj3.'
							WHEN `cms_desc` = "program 3 prov" THEN '.$progProv3.'
						END
						)
					WHERE `cms_purpose` = 9 AND `cms_desc` IN ("overview content", "program 1", "program 1 desc", "program 1 mission", "program 1 obj intro", "program 1 obj", "program 1 adm intro", "program 1 reqs freshmen", "program 1 reqs shiftee", "program 1 reqs transferee", "program 1 retention", "program 1 grad", "program 1 career", "program 2", "program 2 desc", "program 2 mission", "program 2 obj intro", "program 2 obj", "program 2 adm intro", "program 2 reqs freshmen", "program 2 reqs shiftee", "program 2 reqs transferee", "program 2 retention", "program 2 grad", "program 2 career", "program 3", "program 3 desc", "program 3 obj intro", "program 3 obj", "program 1 prov")';
					
				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 9: // update student organizations
				$allOrg = (!isset($_POST['allOrg']) || empty($_POST['allOrg'])) ? null : mysqli_real_escape_string($conn, $_POST['allOrg']);
				$existOrg = (!isset($_POST['existOrg']) || empty($_POST['existOrg'])) ? null : mysqli_real_escape_string($conn, $_POST['existOrg']);
				$orgCreate = json_decode($_POST['orgCreate'], true);
				$orgUpdate = json_decode($_POST['orgUpdate'], true);
				$delOrg = array();
				
				mysqli_begin_transaction($conn);

				try {
					if(!empty($allOrg) && !empty($existOrg)) {
						$old = explode(',', $allOrg);
						$current = explode(',', $existOrg);
						$delOrg = array_diff($old, $current);

						if(count($delOrg) > 0) {
							$delStmt = mysqli_prepare($conn, 'DELETE FROM `org` WHERE `org_ID` IN ('.implode(',', $delOrg).')');
							mysqli_stmt_execute($delStmt);
						}
					}

					if(!empty($orgCreate)) {
						for($i = 0; $i < count($orgCreate); $i++) {
							$orgImg = $orgCreate[$i]['orgImg'];
							$orgInit = empty($orgCreate[$i]['orgInit']) ? null : mysqli_real_escape_string($conn, $orgCreate[$i]['orgInit']);
							$orgName = empty($orgCreate[$i]['orgName']) ? null : mysqli_real_escape_string($conn, $orgCreate[$i]['orgName']);
							$orgDesc = empty($orgCreate[$i]['orgDesc']) ? null : mysqli_real_escape_string($conn, $orgCreate[$i]['orgDesc']);
							$orgFb = empty($orgCreate[$i]['orgFb']) ? null : mysqli_real_escape_string($conn, $orgCreate[$i]['orgFb']);
							$orgFbLink = empty($orgCreate[$i]['orgFbLink']) ? null : mysqli_real_escape_string($conn, $orgCreate[$i]['orgFbLink']);
							$orgTwt = empty($orgCreate[$i]['orgTwt']) ? null : mysqli_real_escape_string($conn, $orgCreate[$i]['orgTwt']);
							$orgTwtLink = empty($orgCreate[$i]['orgTwtLink']) ? null : mysqli_real_escape_string($conn, $orgCreate[$i]['orgTwtLink']);
							$orgEmail = empty($orgCreate[$i]['orgEmail']) ? null : mysqli_real_escape_string($conn, $orgCreate[$i]['orgEmail']);
							$orgHead = $orgCreate[$i]['orgID'] == '1';

							$newStmt = mysqli_prepare($conn, 'INSERT INTO `org` (`org_init`, `org_name`, `org_desc`, `org_fb`, `org_fb_link`, `org_twt`, `org_twt_link`, `org_email`, `is_head`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
							mysqli_stmt_bind_param($newStmt, 'ssssssssi', $orgInit, $orgName, $orgDesc, $orgFb, $orgFbLink, $orgTwt, $orgTwtLink, $orgEmail, $orgHead);
							mysqli_stmt_execute($newStmt);
							$insertID = mysqli_stmt_insert_id($newStmt);
							
							$uploadLoc = '../images/content/student/org';
						
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
							
							if(preg_match('/^data:image\/(\w+);base64,/', $orgImg, $type)) {
								$orgImg = substr($orgImg, strpos($orgImg, ',') + 1);
								$type = strtolower($type[1]); // jpg, png, gif
								
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
						
								$orgImg = str_replace(' ', '+', $orgImg);
								$orgImg = base64_decode($orgImg);
								
								if($orgImg === false) {
									echo json_encode(array(false, 'Error: base64_decode failed'));
									exit;
								}
	
								$logoFile = $uploadLoc.'/'.$insertID.'.'.$type;
								
								if(file_exists($logoFile))
									unlink($logoFile);
		
								file_put_contents($logoFile, $orgImg);
	
								$logoSrc = substr($logoFile, 3);

								$logoStmt = mysqli_prepare($conn, 'UPDATE `org` SET `org_img` = ? WHERE `org_ID` = ?');
								mysqli_stmt_bind_param($logoStmt, 'si', $logoSrc, $insertID);
								mysqli_stmt_execute($logoStmt);
							} else
								continue;
						}
					}
					
					if(!empty($orgUpdate)) {
						for($i = 0; $i < count($orgUpdate); $i++) {
							$orgID = $orgUpdate[$i]['orgID'];
							$orgImg = $orgUpdate[$i]['orgImg'];
							$orgInit = empty($orgUpdate[$i]['orgInit']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $orgUpdate[$i]['orgInit']).'"';
							$orgName = empty($orgUpdate[$i]['orgName']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $orgUpdate[$i]['orgName']).'"';
							$orgDesc = empty($orgUpdate[$i]['orgDesc']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $orgUpdate[$i]['orgDesc']).'"';
							$orgFb = empty($orgUpdate[$i]['orgFb']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $orgUpdate[$i]['orgFb']).'"';
							$orgFbLink = empty($orgUpdate[$i]['orgFbLink']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $orgUpdate[$i]['orgFbLink']).'"';
							$orgTwt = empty($orgUpdate[$i]['orgTwt']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $orgUpdate[$i]['orgTwt']).'"';
							$orgTwtLink = empty($orgUpdate[$i]['orgTwtLink']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $orgUpdate[$i]['orgTwtLink']).'"';
							$orgEmail = empty($orgUpdate[$i]['orgEmail']) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $orgUpdate[$i]['orgEmail']).'"';
							$logoSrc = '';

							$uploadLoc = '../images/content/student/org';
						
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
							
							if(preg_match('/^data:image\/(\w+);base64,/', $orgImg, $type)) {
								$orgImg = substr($orgImg, strpos($orgImg, ',') + 1);
								$type = strtolower($type[1]); // jpg, png, gif
								
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
						
								$orgImg = str_replace(' ', '+', $orgImg);
								$orgImg = base64_decode($orgImg);
								
								if($orgImg === false) {
									echo json_encode(array(false, 'Error: base64_decode failed'));
									exit;
								}
	
								$logoFile = $uploadLoc.'/'.$orgID.'.'.$type;
								
								if(file_exists($logoFile))
									unlink($logoFile);
		
								file_put_contents($logoFile, $orgImg);
	
								$logoSrc = substr($logoFile, 3);
							}

							$updateSql = 'UPDATE `org`
								SET `org_init` = '.$orgInit.', `org_name` = '.$orgName.', `org_desc` = '.$orgDesc.', `org_fb` = '.$orgFb.', `org_fb_link` = '.$orgFbLink.', `org_twt` = '.$orgTwt.', `org_twt_link` = '.$orgTwtLink.', `org_email` = '.$orgEmail.' ';

							if(!empty($logoSrc))
								$updateSql .= ', `org_img` = "'.$logoSrc.'" ';

							$updateSql .= 'WHERE `org_ID` = '.$orgID;
							$updateStmt = mysqli_prepare($conn, $updateSql);
							mysqli_stmt_execute($updateStmt);
						}
					}

					mysqli_commit($conn);
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
					exit();
				}
				
				if(!empty($delOrg)) {
					$path = '../images/content/student/org/';
					foreach($delOrg as $name) {
						foreach(glob($path.$name.'*') as $filename) {
							unlink(realpath($filename));
						}
					}
				}
				echo json_encode(array(true));
				
				break;
			case 10: // update student handbook
				$hbIntro = (!isset($_POST['hbIntro']) || empty($_POST['hbIntro'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['hbIntro']).'"';
				$hasFile = isset($_FILES['pdf']['name']);
				$newFile = array();
				
				mysqli_begin_transaction($conn);

				try {
					$uploadLoc = '';

					if($hasFile) {
						$filename = $_FILES['pdf']['name'];

						$uploadLoc = '../files/handbook';
						
						if(!file_exists($uploadLoc))
							mkdir($uploadLoc, 0777, true);

						$files = glob($uploadLoc.'/*');
						foreach($files as $file) {
							if(is_file($file)) {
								unlink($file);
							}
						}

						$newFileName = pathinfo($filename, PATHINFO_FILENAME);
						$newFileName = str_replace(' ', '-', $newFileName);
						$newFileName = preg_replace('/[^A-Za-z0-9\-]/', '', $newFileName);
						$newFileName = preg_replace('/-+/', '-', $newFileName).'.'.pathinfo($filename, PATHINFO_EXTENSION);
						$uploadLoc = $uploadLoc.'/'.$newFileName;
						$newFile = array($uploadLoc);
						$fileType = pathinfo($uploadLoc, PATHINFO_EXTENSION);
						$fileType = strtolower($fileType);
				
						if(strtolower($fileType) == 'pdf') {
							if(!move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadLoc)) {
								echo json_encode(array(false, 'Error: File upload failed'));
								exit();
							}
						}
					}

					$updateSql = 'UPDATE `cms`
						SET `cms_content` = '.$hbIntro.' ';

					if($hasFile) {
						$uploadLoc = substr($uploadLoc, 3);
						$updateSql .= ', `cms_link` = "'.$uploadLoc.'" ';
					}

					$updateSql .= 'WHERE `cms_purpose` = 10';
					$updateStmt = mysqli_prepare($conn, $updateSql);
					mysqli_stmt_execute($updateStmt);

					mysqli_commit($conn);
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
					exit();
				}
				
				if($hasFile) {
					$files = glob('../files/handbook/*');
					foreach($files as $file) {
						if(!in_array($file, $newFile)) {
							unlink($file);
						}
					}
				}
				
				echo json_encode(array(true));

				break;
			case 11: // update student forms
				$formCtr = count($_POST['formID']);
				$formID = $_POST['formID'];
				$hasNameChanged = $_POST['hasNameChanged'];
				$fileName = $_POST['fileName'];
				$fileSize = $_POST['fileSize'];
				$fileExist = $_POST['fileExist'];
				$allForm = $_POST['allForm'];
				$existForm = $_POST['existForm'];
				$hasMoreChanged = $_POST['hasMoreChanged'];
				$more = (!isset($_POST['more']) || empty($_POST['more'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['more']).'"';
				$moreLink = (!isset($_POST['moreLink']) || empty($_POST['moreLink'])) ? 'NULL' : '"'.mysqli_real_escape_string($conn, $_POST['moreLink']).'"';

				mysqli_begin_transaction($conn);

				try {
					if(!empty($allForm) && !empty($existForm)) {
						$old = explode(',', $allForm);
						$current = explode(',', $existForm);
						$delForm = array_diff($old, $current);

						if(count($delForm) > 0) {
							$delStmt = mysqli_prepare($conn, 'DELETE FROM `cms` WHERE `cms_ID` IN ('.implode(',', $delForm).')');
							mysqli_stmt_execute($delStmt);
						}
					}

					for($i = 0; $i < $formCtr; $i++) {
						if($hasNameChanged[$i] == 'true' || isset($_FILES['files']['name'][$i])) {
							$fileName[$i] = mysqli_real_escape_string($conn, $fileName[$i]);
							$fileSize[$i] = mysqli_real_escape_string($conn, $fileSize[$i]);
							$hasNewFile = false;
							$path = '';

							if($formID[$i] == '0') {
								$newStmt = mysqli_prepare($conn, 'INSERT INTO `cms` (`cms_purpose`, `cms_desc`, `cms_content`, `cms_info`) VALUES (11, "file", ?, ?)');
								mysqli_stmt_bind_param($newStmt, 'ss', $fileName[$i], $fileSize[$i]);
								mysqli_stmt_execute($newStmt);
								$formID[$i] = mysqli_stmt_insert_id($newStmt);
							}

							if(isset($_FILES['files']['name'][$i]) && $_FILES['files']['name'][$i] != '') {
								$hasNewFile = true;
								$file = $_FILES['files']['name'][$i];

								$uploadLoc = '../files/forms';

								if(!file_exists($uploadLoc))
									mkdir($uploadLoc, 0777, true);

								$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
								$valid_ext = array('pdf', 'doc', 'docx', 'xlsx', 'xls');
								if(in_array($ext, $valid_ext)) {
									$newFileName = str_replace(' ', '-', $fileName[$i]);
									$newFileName = preg_replace('/[^A-Za-z0-9\-]/', '', $newFileName);
									$newFileName = $formID[$i].'-'.preg_replace('/-+/', '-', $newFileName).'.'.$ext;
									$path = $uploadLoc.'/'.$newFileName;

									if(file_exists($path))
										unlink($path);
					
									if(move_uploaded_file($_FILES['files']['tmp_name'][$i], $path)){
										$fileExist[] = $path;
									}
								}
							}

							if($formID[$i] != '0') {
								$updateSql = 'UPDATE `cms`
									SET `cms_content` = "'.$fileName[$i].'"';
			
								if($hasNewFile) {
									$path = substr($path, 3);
									$updateSql .= ', `cms_link` = "'.$path.'", `cms_info` = "'.$fileSize[$i].'"';
								}
							} else
								$updateSql = 'UPDATE `cms` SET `cms_link` = "'.$path.'"';
		
							$updateSql .= ' WHERE `cms_ID` = '.$formID[$i];
							$updateStmt = mysqli_prepare($conn, $updateSql);
							mysqli_stmt_execute($updateStmt);
						}
					}

					if($hasMoreChanged == 'true') {
						$updateSql = 'UPDATE `cms`
							SET `cms_content` = '.$fileName.', `cms_link` = '.$path.'
							WHERE `cms_purpose` = 11 AND `cms_desc` = "more"';
						$updateStmt = mysqli_prepare($conn, $updateSql);
						mysqli_stmt_execute($updateStmt);
					}

					mysqli_commit($conn);
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
					exit();
				}
				
				if(!empty($fileExist)) {
					$files = glob('../files/forms/*');
					foreach($files as $file) {
						if(!in_array($file, $fileExist)) {
							unlink($file);
						}
					}
				}
				
				echo json_encode(array(true));

				break;
			case 12: // update faculty
				$allFaculty = (!isset($_POST['allFaculty']) || empty($_POST['allFaculty'])) ? null : mysqli_real_escape_string($conn, $_POST['allFaculty']);
				$existFaculty = (!isset($_POST['existFaculty']) || empty($_POST['existFaculty'])) ? null : mysqli_real_escape_string($conn, $_POST['existFaculty']);
				$empCreate = json_decode($_POST['empCreate'], true);
				$empUpdate = json_decode($_POST['empUpdate'], true);
				$delEmp = array();
				
				mysqli_begin_transaction($conn);

				try {
					if(!empty($allFaculty) && !empty($existFaculty)) {
						$old = explode(',', $allFaculty);
						$current = explode(',', $existFaculty);
						$delEmp = array_diff($old, $current);

						if(count($delEmp) > 0) {
							$delStmt = mysqli_prepare($conn, 'DELETE FROM `faculty_staff` WHERE `emp_ID` IN ('.implode(',', $delEmp).')');
							mysqli_stmt_execute($delStmt);
						}
					}

					if(!empty($empCreate)) {
						for($i = 0; $i < count($empCreate); $i++) {
							$empImg = $empCreate[$i]['empImg'];
							$empName = empty($empCreate[$i]['empName']) ? null : $empCreate[$i]['empName'];
							$empRole = empty($empCreate[$i]['empRole']) ? null : $empCreate[$i]['empRole'];
							$empJob = empty($empCreate[$i]['empJob']) ? null : $empCreate[$i]['empJob'];
							$isFaculty = $empCreate[$i]['isFaculty'];
							$isHead = $empCreate[$i]['isHead'];

							$newStmt = mysqli_prepare($conn, 'INSERT INTO `faculty_staff` (`emp_name`, `emp_role`, `emp_job`, `is_faculty`, `is_head`) VALUES (?, ?, ?, ?, ?)');
							mysqli_stmt_bind_param($newStmt, 'sssii', $empName, $empRole, $empJob, $isFaculty, $isHead);
							mysqli_stmt_execute($newStmt);
							$insertID = mysqli_stmt_insert_id($newStmt);
							
							$uploadLoc = '../images/content/faculty-staff';
						
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
							
							if(preg_match('/^data:image\/(\w+);base64,/', $empImg, $type)) {
								$empImg = substr($empImg, strpos($empImg, ',') + 1);
								$type = strtolower($type[1]);
								
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
						
								$empImg = str_replace(' ', '+', $empImg);
								$empImg = base64_decode($empImg);
								
								if($empImg === false) {
									echo json_encode(array(false, 'Error: base64_decode failed'));
									exit;
								}
	
								$imgFile = $uploadLoc.'/'.$insertID.'.'.$type;
								
								if(file_exists($imgFile))
									unlink($imgFile);
		
								file_put_contents($imgFile, $empImg);
	
								$imgSrc = substr($imgFile, 3);
							} else
								$imgSrc = substr($empImg, 6);

							$imgStmt = mysqli_prepare($conn, 'UPDATE `faculty_staff` SET `emp_img` = ? WHERE `emp_ID` = ?');
							mysqli_stmt_bind_param($imgStmt, 'si', $imgSrc, $insertID);
							mysqli_stmt_execute($imgStmt);
						}
					}
					
					if(!empty($empUpdate)) {
						for($i = 0; $i < count($empUpdate); $i++) {
							$empID = $empUpdate[$i]['empID'];
							$empImg = $empUpdate[$i]['empImg'];
							$empName = empty($empUpdate[$i]['empName']) ? null : $empUpdate[$i]['empName'];
							$empRole = empty($empUpdate[$i]['empRole']) ? null : $empUpdate[$i]['empRole'];
							$empJob = empty($empUpdate[$i]['empJob']) ? null : $empUpdate[$i]['empJob'];

							$uploadLoc = '../images/content/faculty-staff';
						
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
							
							if(preg_match('/^data:image\/(\w+);base64,/', $empImg, $type)) {
								$empImg = substr($empImg, strpos($empImg, ',') + 1);
								$type = strtolower($type[1]);
								
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
						
								$empImg = str_replace(' ', '+', $empImg);
								$empImg = base64_decode($empImg);
								
								if($empImg === false) {
									echo json_encode(array(false, 'Error: base64_decode failed'));
									exit;
								}
	
								$imgFile = $uploadLoc.'/'.$empID.'.'.$type;
								
								if(file_exists($imgFile))
									unlink($imgFile);
		
								file_put_contents($imgFile, $empImg);
	
								$imgSrc = substr($imgFile, 3);

								$imgStmt = mysqli_prepare($conn, 'UPDATE `faculty_staff` SET `emp_img` = ?, `emp_name` = ?, `emp_role` = ?, `emp_job` = ? WHERE `emp_ID` = ?');
								mysqli_stmt_bind_param($imgStmt, 'ssssi', $imgSrc, $empName, $empRole, $empJob, $empID);
								mysqli_stmt_execute($imgStmt);
							} else {
								$updateStmt = mysqli_prepare($conn, 'UPDATE `faculty_staff` SET `emp_name` = ?, `emp_role` = ?, `emp_job` = ? WHERE `emp_ID` = ?');
								mysqli_stmt_bind_param($updateStmt, 'sssi', $empName, $empRole, $empJob, $empID);
								mysqli_stmt_execute($updateStmt);
							}
						}
					}

					mysqli_commit($conn);
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
					exit();
				}
				
				if(!empty($allFaculty) && !empty($existFaculty) && !empty($delEmp)) {
					$path = '../images/content/faculty-staff/';
					foreach($delEmp as $name) {
						foreach(glob($path.$name.'*') as $filename) {
							unlink(realpath($filename));
						}
					}
				}
				echo json_encode(array(true));
				
				break;
			case 13: // update gallery
				$allImg = (!isset($_POST['allImg']) || empty($_POST['allImg'])) ? null : mysqli_real_escape_string($conn, $_POST['allImg']);
				$existImg = (!isset($_POST['existImg']) || empty($_POST['existImg'])) ? null : mysqli_real_escape_string($conn, $_POST['existImg']);
				$imgCreate = json_decode($_POST['imgCreate'], true);
				$delImg = array();
				
				mysqli_begin_transaction($conn);

				try {
					if(!empty($allImg) && !empty($existImg)) {
						$old = explode(',', $allImg);
						$current = explode(',', $existImg);
						$delImg = array_diff($old, $current);

						if(count($delImg) > 0) {
							$delStmt = mysqli_prepare($conn, 'DELETE FROM `cms` WHERE `cms_ID` IN ('.implode(',', $delImg).')');
							mysqli_stmt_execute($delStmt);
						}
					}

					if(!empty($imgCreate)) {
						for($i = 0; $i < count($imgCreate); $i++) {
							$imgID = $imgCreate[$i]['imgID'];
							$galImg = $imgCreate[$i]['galImg'];

							$uploadLoc = '../images/content/gallery';
						
							if(!file_exists($uploadLoc))
								mkdir($uploadLoc, 0777, true);
							
							if(preg_match('/^data:image\/(\w+);base64,/', $galImg, $type)) {
								$newStmt = mysqli_prepare($conn, 'INSERT INTO `cms` (`cms_purpose`, `cms_desc`) VALUES (12, "image")');
								mysqli_stmt_execute($newStmt);
								$insertID = mysqli_stmt_insert_id($newStmt);
								
								$galImg = substr($galImg, strpos($galImg, ',') + 1);
								$type = strtolower($type[1]);
								
								if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
									echo json_encode(array(false, 'Invalid image type'));
									exit;
								}
						
								$galImg = str_replace(' ', '+', $galImg);
								$galImg = base64_decode($galImg);
								
								if($galImg === false) {
									echo json_encode(array(false, 'Error: base64_decode failed'));
									exit;
								}
	
								$imgFile = $uploadLoc.'/'.$insertID.'.'.$type;
								
								if(file_exists($imgFile))
									unlink($imgFile);
		
								file_put_contents($imgFile, $galImg);
	
								$imgSrc = substr($imgFile, 3);

								$imgStmt = mysqli_prepare($conn, 'UPDATE `cms` SET `cms_content` = ? WHERE `cms_ID` = ?');
								mysqli_stmt_bind_param($imgStmt, 'si', $imgSrc, $insertID);
								mysqli_stmt_execute($imgStmt);
							} else
								continue;
						}
					}
					
					mysqli_commit($conn);
				} catch(mysqli_sql_exception $exception) {
					mysqli_rollback($mysqli);
					throw $exception;
					echo json_encode(array(false, $exception));
					exit();
				}
				
				if(!empty($allImg) && !empty($existImg) && !empty($delImg)) {
					$path = '../images/content/gallery/';
					foreach($delImg as $name) {
						foreach(glob($path.$name.'*') as $filename) {
							unlink(realpath($filename));
						}
					}
				}
				echo json_encode(array(true));
				
				break;
        }
	}
	mysqli_close($conn);
?>