<?php
	include 'dbconn.php';

	if(count($_POST) > 0) {
		switch($_POST['type']) {
			case 1: // create category
				$categories = $_POST['categories'];
	            $catName = explode(',', mysqli_real_escape_string($conn, $categories));

				$sql = 'INSERT INTO `category` (`cat_name`) VALUES ';
				for($i = 0; $i < count($catName); $i++) {
					$sql .= '("'.$catName[$i].'")';

					if($i + 1 != count($catName))
						$sql .= ',';
				}

				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 2: // update category
				$catID = $_POST['catID'];
				$catName = mysqli_real_escape_string($conn, $_POST['catName']);

				$sql = 'UPDATE `category`
					SET `cat_name` = "'.$catName.'"
					WHERE `cat_ID` = '.$catID;

				if(mysqli_query($conn, $sql))
					echo json_encode(array(true));
				else 
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 3: // select category
				$catID = $_POST['catID'];

				$sql = 'SELECT *
					FROM `category`
					WHERE `cat_ID` IN ('.$catID.')';

				if($result = mysqli_query($conn, $sql)) {
					$catarray = array();
					while($row = mysqli_fetch_assoc($result)) {
						// assign fetched row to array
						$catarray[] = $row;
					}
					echo json_encode($catarray);
				} else
					echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));

				break;
			case 4: // delete category
				$catID = $_POST['catID'];

				mysqli_begin_transaction($conn);

				try {
					$updateStmt = mysqli_prepare($conn, 'UPDATE `thread` SET `cat_ID` = 1');
					mysqli_stmt_execute($updateStmt);
					
					$delStmt = mysqli_prepare($conn, 'DELETE FROM `category` WHERE `cat_ID` IN ('.$catID.')');
					mysqli_stmt_execute($delStmt);
					
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