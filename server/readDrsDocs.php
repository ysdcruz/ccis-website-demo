<?php
    include 'dbconn.php';

    $docs = array();
    $sql = 'SELECT *
        FROM `drs_type`
        ORDER BY `Doc_Type`';
    
	$result = mysqli_query($conn, $sql);
	if($result) {
		while($row = mysqli_fetch_assoc($result)) {
			// assign fetched row to array
			$docs[] = $row;
		}
	} else {
		echo json_encode(array(false, 'Error: '. $sql . '\n'. mysqli_error($conn), $sql));
		exit;
	}

    echo json_encode(array($docs));
    mysqli_close($conn);
?>