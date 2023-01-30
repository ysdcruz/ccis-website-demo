<?php
	include 'dbconn.php';
    session_start();

    if(isset($_SESSION['user']) || isset($_SESSION['admin'])) {
        $userID = (isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin']);
        $sql = 'SELECT * FROM `user` WHERE `User_ID` = '.$userID;
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

		if(isset($_SESSION['admin']) && empty($user['Role'])) {
			$tempID = $_SESSION['admin'];
			session_destroy();

    		session_start();
			$_SESSION['user'] = $tempID;
		} else if(isset($_SESSION['user']) && !empty($user['Role'])) {
			$tempID = $_SESSION['user'];
			session_destroy();

    		session_start();
			$_SESSION['admin'] = $tempID;
		}
    } else
        $userID = 0;

?>