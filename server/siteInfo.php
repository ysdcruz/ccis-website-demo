<?php
	include 'dbconn.php';

	$genSql = 'SELECT * FROM `cms` WHERE `cms_purpose` = 1';
	$genResult = mysqli_query($conn, $genSql);
	$genRow = array();

	while($row = mysqli_fetch_array($genResult)) {
		$row['cms_content'] = stripcslashes($row['cms_content']);
		$genRow[] = $row;
	}

    $linkSql = 'SELECT * FROM `cms` WHERE `cms_purpose` = 2';
    $linkResult = mysqli_query($conn, $linkSql);
	$linkRow = array();

    while($row = mysqli_fetch_array($linkResult)) {
		$linkRow[] = $row;
	}
    
	$conSql = 'SELECT * FROM `cms` WHERE `cms_purpose` = 7';
	$conResult = mysqli_query($conn, $conSql);
	$conRow = array();

	while($row = mysqli_fetch_array($conResult)) {
		$conRow[] = $row;
	}
?>