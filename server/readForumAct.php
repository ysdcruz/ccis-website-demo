<?php
	include 'dbconn.php';

	if(count($_POST) > 0) {
		$range = $_POST['range'];
		$time = strtoupper($_POST['time']);
		
		if($time == 'WEEK')
			$sql = 'SELECT YEAR(NOW() - INTERVAL '.$range.' WEEK) AS "old_yr", YEAR(NOW()) AS "new_yr", WEEK(LAST_DAY(MAKEDATE(YEAR(NOW() - INTERVAL '.$range.' WEEK), 365))) AS "prev_week", WEEK(NOW() - INTERVAL '.$range.' WEEK) AS "first_week", WEEK(NOW()) AS "last_week"';
		else
			$sql = 'SELECT YEAR(NOW() - INTERVAL '.$range.' MONTH) AS "old_yr", YEAR(NOW()) AS "new_yr", MONTH(NOW() - INTERVAL '.$range.' MONTH) AS "first_month", MONTH(NOW()) AS "last_month"';

		$result = mysqli_query($conn, $sql);
				
		$labelarray = array();
		$row = mysqli_fetch_assoc($result);

		if($time == 'WEEK') {
			$weekInit = (int) $row['first_week'];

			if($row['old_yr'] != $row['new_yr']) {
				for($i = $weekInit; $i <= (int) $row['prev_week']; $i++) {
					$labelarray[] = $row['old_yr'].'/'.$i;
				}

				for($i = 1; $i <= (int) $row['last_week']; $i++) {
					$labelarray[] = $row['new_yr'].'/'.$i;
				}
			} else {
				for($i = $weekInit; $i <= (int) $row['last_week']; $i++) {
					$labelarray[] = $row['new_yr'].'/'.$i;
				}
			}
		} else {
			$monthInit = (int) $row['first_month'];

			if($row['old_yr'] != $row['new_yr']) {
				for($i = $monthInit; $i <= 12; $i++) {
					$labelarray[] = $row['old_yr'].'/'.$i;
				}

				for($i = 1; $i <= (int) $row['last_month']; $i++) {
					$labelarray[] = $row['new_yr'].'/'.$i;
				}
			} else {
				for($i = $monthInit; $i <= (int) $row['last_month']; $i++) {
					$labelarray[] = $row['new_yr'].'/'.$i;
				}
			}
		}

		$sql = 'SELECT CONCAT(YEAR(content.`event_date`), "/", '.$time.'(content.`event_date`)) AS "label", '.$time.'(content.`event_date`) AS '.($time == 'WEEK' ? '"week_no"' : '"month_no"').', COUNT(*) AS "activity"
		FROM `thread_history` content
		INNER JOIN (
			SELECT `thread_ID`, MAX(`thread_ver`) AS "latest_ver"
			FROM `thread_history`
			GROUP BY `thread_ID`
		) ver ON content.`thread_ID` = ver.`thread_ID` AND content.`thread_ver` = ver.`latest_ver`
		WHERE content.`event_date` >= NOW() - INTERVAL '.$range.' '.$time.' AND content.`event_date` <= NOW()
		GROUP BY label';

		if($result = mysqli_query($conn, $sql)) {
			$actarray = array_fill(0, count($labelarray), 0);

			while($row = mysqli_fetch_array($result)) {
				for($i = 0; $i < count($labelarray); $i++) {
					if($row['label'] == $labelarray[$i])
						$actarray[$i] = (int) $row['activity'];
				}
			}
			echo json_encode(array(true, $labelarray, $actarray));
		} else 
			echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
	}
	mysqli_close($conn);
?>