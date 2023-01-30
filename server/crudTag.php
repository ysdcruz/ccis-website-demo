<?php
	include 'dbconn.php';

	if(count($_POST) > 0) {
		switch($_POST['type']) {
			case 1: // select tags
				$sql = 'SELECT *
					FROM `tags`';
					
				if($result = mysqli_query($conn, $sql)) {
					$tagarray = array();
					while($row = mysqli_fetch_assoc($result)) {
						// assign fetched row to array
						$tagarray[] = $row;
					}

					echo json_encode($tagarray);
				} else
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 2: // delete, update & insert tags
				$deleteTag = $_POST['deleteTag'];

				if(isset($_POST['updateTag']))
					$updateTag = $_POST['updateTag'];

				$newTag = $_POST['newTag'];
				
				$insertTag = explode(',', $newTag);

				$sql = '';

				if($deleteTag != '') {
					$sql .= 'DELETE FROM `tags`
					WHERE `tag_ID` IN ('.$deleteTag.'); ';
				}

				if(isset($_POST['updateTag']) && count($updateTag)) {
					for($i = 0; $i < count($updateTag); $i++) {
						$sql .= 'UPDATE `tags`
							SET `tag_Name` = "'.$updateTag[$i]['tag_Name'].'"
								WHERE `tag_ID` = '.$updateTag[$i]['tag_ID'].'; ';
					}
				}

				if($newTag != '') {
					$sql .= 'INSERT INTO `tags` (`tag_Name`) VALUES ';
					for($i = 0; $i < count($insertTag); $i++) {
						$sql .= '("'.$insertTag[$i].'")';

						if($i + 1 != count($insertTag))
							$sql .= ',';
					}
				}
				
				if(mysqli_multi_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
				
				break;
		}
	}
	mysqli_close($conn);
?>