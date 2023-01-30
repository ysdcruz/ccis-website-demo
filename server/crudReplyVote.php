<?php
    include 'dbconn.php';

	$replyID = $_POST['replyID'];
	$userID = $_POST['userID'];
    $vote = $_POST['vote'];

	mysqli_begin_transaction($conn);

	try {
		if($vote == 0) {
			$delStmt = mysqli_prepare($conn, 'DELETE FROM `reply_votes` WHERE `user_ID` = '.$userID);
			mysqli_stmt_execute($delStmt);
		} else {
			$newStmt = mysqli_prepare($conn, 'INSERT INTO `reply_votes` (`reply_ID`, `user_ID`, `user_vote`) VALUES (?, ?, ?)');
			mysqli_stmt_bind_param($newStmt, 'iii', $replyID, $userID, $vote);
			mysqli_stmt_execute($newStmt);
		}

		$ctrStmt = mysqli_prepare($conn, 'SELECT IFNULL(SUM(`user_vote`), 0) as "vote_count" FROM `reply_votes` WHERE `reply_ID` = '.$replyID);
		mysqli_stmt_execute($ctrStmt);
		$result = mysqli_stmt_get_result($ctrStmt);
		$row = mysqli_fetch_array($result);
		$voteCtr = (int)$row['vote_count'];

		$replyStmt = mysqli_prepare($conn, 'UPDATE `thread` SET `reply_upvotes` = ? WHERE `reply_ID` = '.$replyID);
		mysqli_stmt_bind_param($replyStmt, 'i', $voteCtr);
		mysqli_stmt_execute($replyStmt);

		mysqli_commit($conn);
		echo json_encode(array(true, $voteCtr));
	} catch(mysqli_sql_exception $exception) {
		mysqli_rollback($mysqli);
		throw $exception;
		echo json_encode(array(false, $exception));
	}

    mysqli_close($conn);
?>