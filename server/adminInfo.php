<?php
	include 'dbconn.php';
    session_start();

	if(!isset($_SESSION['admin'])) {
        header('location:../index.php');
    } else {
    	$sql = 'SELECT `user`.*, `roles`.`Role_Desc`, `student_org`.`stud_org`, IFNULL(`org`.`org_init`, `org`.`org_name`) AS "org_init" 
			FROM `user` 
			LEFT JOIN `roles` ON `user`.`Role` = `roles`.`Role_ID`
			LEFT JOIN `student_org` ON `user`.`Personal_ID` = `student_org`.`Personal_ID` 
			LEFT JOIN `org` ON `student_org`.`stud_org` = `org`.`org_ID`
			WHERE `User_ID` = "'.$_SESSION['admin'].'"';
        $result = mysqli_query($conn, $sql);
        $admin = mysqli_fetch_assoc($result);

		if(empty($admin['Role'])) {
			$userID = $_SESSION['admin'];
			session_destroy();

    		session_start();
			$_SESSION['user'] = $userID;
		
			header('location:../index.php');
		}
    }
?>