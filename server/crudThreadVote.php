<?php
    include 'dbconn.php';

	$threadID = $_POST['threadID'];
	$userID = $_POST['userID'];
    $vote = $_POST['vote'];

	mysqli_begin_transaction($conn);

	try {
		if($vote == 0) {
			$delStmt = mysqli_prepare($conn, 'DELETE FROM `thread_votes` WHERE `user_ID` = '.$userID);
			mysqli_stmt_execute($delStmt);
		} else {
			$newStmt = mysqli_prepare($conn, 'INSERT INTO `thread_votes` (`thread_ID`, `user_ID`, `user_vote`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `user_vote` = ?');
			mysqli_stmt_bind_param($newStmt, 'iiii', $threadID, $userID, $vote, $vote);
			mysqli_stmt_execute($newStmt);
		}

		$ctrStmt = mysqli_prepare($conn, 'SELECT IFNULL(SUM(`user_vote`), 0) as "vote_count" FROM `thread_votes` WHERE `thread_ID` = '.$threadID);
		mysqli_stmt_execute($ctrStmt);
		$result = mysqli_stmt_get_result($ctrStmt);
		$row = mysqli_fetch_array($result);
		$voteCtr = (int)$row['vote_count'];

		$threadStmt = mysqli_prepare($conn, 'UPDATE `thread` SET `thread_upvotes`= ? WHERE `thread_ID` = '.$threadID);
		mysqli_stmt_bind_param($threadStmt, 'i', $voteCtr);
		mysqli_stmt_execute($threadStmt);

		mysqli_commit($conn);
		echo json_encode(array(true, $voteCtr));
	} catch(mysqli_sql_exception $exception) {
		mysqli_rollback($mysqli);
		throw $exception;
		echo json_encode(array(false, $exception));
	}
	
    mysqli_close($conn);
?>