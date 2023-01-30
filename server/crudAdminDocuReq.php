<?php

include 'dbconn.php';

  if(count($_POST) > 0) {
		switch($_POST['type']) {
            case 1: 
                $avail = $_POST['docu_title'];
                $prereq = $_POST['docu_req_name'];
                $i = 0;
                $count = count($avail);
                $verify = 0;
                while ($i < $count) {
                    if($prereq[$i]===""){
                        $sql = 'INSERT INTO drs_type (Doc_Type, Doc_Prereq) VALUES ("'.$avail[$i].'", NULL)';
                    }
                    else{
                        $sql = 'INSERT INTO drs_type (Doc_Type, Doc_Prereq) VALUES ("'.$avail[$i].'", "'.$prereq[$i].'")';
                    }
                    if(mysqli_multi_query($conn, $sql))
                        ++$i;
                        ++$verify;
                }
                if ($count==$verify){
                    echo json_encode(array(true));
                }else{
                    echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
                }
            break;
            case 2: 
                $id = $_POST['id'];
                $avail = $_POST['docu_title'];
                $prereq = $_POST['docu_req_name'];
                    if($prereq[0]===""){
                        $sql = 'UPDATE drs_type SET Doc_Type ="'.$avail[0].'", Doc_Prereq = NULL WHERE type_ID ='.$id;
                    }
                    else{
                        $sql = 'UPDATE drs_type SET Doc_Type ="'.$avail[0].'", Doc_Prereq ="'.$prereq[0].'" WHERE type_ID ='.$id;
                    }
                if(mysqli_multi_query($conn, $sql)){
                    echo json_encode(array(true, 'Document Updated'));
                }else{
                    echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
                }
            break;
            case 3: 
                $id = $_POST['id'];
                $i = 0;
                $count = count($id);
                $verify = 0;
                while ($i < $count) {
                    $sql = 'DELETE FROM `drs_type` WHERE `type_ID` = '.$id[$i];
                    if(mysqli_multi_query($conn, $sql))
                    ++$i;
                    ++$verify;
                }
                if ($count==$verify){
                    echo json_encode(array(true, 'Document Deleted'));
                }else{
                    echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
                }
            break;
            case 4:
                $ctrlnum = $_POST['ctrlnum'];
                $ctrlnum = trim(preg_replace('/\s\s+/', '', $ctrlnum));
                $sql = 'SELECT `user`.`Personal_ID` AS "PID", CONCAT_WS(" ", `user`.`FName`, `user`.`MName`, `user`.`LName`) AS "Name", `type`.`Type_Desc` AS "UType",
                                `bg`.`Course` AS "Course", `bg`.`Admit_Yr` AS "Admityr", `bg`.`Grad_Yr` AS "Gradyr", `doc`.`Handler_ID` AS "Handler", 
                                `doc`.`Handler_Name` AS "Handler_Name" FROM `user`
                            LEFT JOIN (SELECT `Personal_ID`,`Course`,`Admit_Yr`,`Grad_Yr` FROM `student_background`) `bg` ON `user`.`Personal_ID` = `bg`.`Personal_ID`
                            LEFT JOIN (SELECT `Req_AuthorID`, `Req_ControlNum`, `Handler_ID`, `handler`.`Handler_Name` FROM `drs`
                                    LEFT JOIN (SELECT `Personal_ID`, CONCAT_WS(" ", `FName`, `MName`, `LName`) AS "Handler_Name"
                                        FROM `user`)`handler` ON `handler`.`Personal_ID` = `Handler_ID`
                                )`doc` ON `user`.`Personal_ID` = `doc`.`Req_AuthorID`
                            
                            LEFT JOIN (SELECT `Type_ID`, `Type_Desc` FROM `user_type`)`type` ON `type`.`Type_ID` = `user`.`Type`
                            WHERE `doc`.`Req_ControlNum` = "'.$ctrlnum.'"';
                $result = mysqli_query($conn, $sql);
                $row = array();
                while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
                {
                    $row = $res;
                }
                echo json_encode($row);
            break;
            case 5:
                $ctrlnum = $_POST['ctrlnum'];
                $handler = $_POST['handler'];
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d H:i:s");
                $ver = 'SELECT COUNT(`drs_process`) AS "Version" FROM `drs_history` WHERE `drs_ctrlnum` = "'.$ctrlnum.'"';
                $runver = mysqli_query($conn, $ver);
                while ($verrow= mysqli_fetch_assoc($runver)){
                  $version = $verrow['Version'];
                }
                $sql = 'BEGIN; 
                        UPDATE `drs` SET `Req_Status` = "Accepted", `Handler_ID` ="'.$handler.'", `Process_Date` ="'.$date.'" WHERE `Req_ControlNum` = "'.$ctrlnum.'";
                        INSERT INTO `drs_history` (`drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`)
                            SELECT `drs`.`Req_ControlNum`, '.$version.' ,`drs`.`Process_Date`, `drs`.`Req_Status`, `docreqs`.`Prereq_File_ID`, `drs`.`Handler_ID`, `drs`.`Remarks` FROM `drs`
                            JOIN (SELECT `Req_ControlNum`, `Prereq_File_ID` FROM `drs_docreqs`)`docreqs` ON `drs`.`Req_ControlNum`= `docreqs`.`Req_ControlNum`
                        WHERE `drs`.`Req_ControlNum` = "'.$ctrlnum.'";
                        COMMIT';
                $res = mysqli_multi_query($conn, $sql);
                if($res){
                    echo json_encode(array(true, 'Accepted'));
                }else{
                    echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
                }
            break;
            case 6:
                $ctrlnum = $_POST['ctrlnum'];
                $reason = $_POST['reason'];
                $handler = $_POST['handler'];
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d H:i:s");
                $ver = 'SELECT COUNT(`drs_process`) AS "Version" FROM `drs_history` WHERE `drs_ctrlnum` = "'.$ctrlnum.'"';
                $runver = mysqli_query($conn, $ver);
                while ($verrow= mysqli_fetch_assoc($runver)){
                  $version = $verrow['Version'];
                }
                $sql = 'BEGIN;
                        UPDATE `drs` SET `Req_Status` = "Rejected", `Handler_ID` ="'.$handler.'", `Remarks` ="'.$reason.'", `Process_Date` ="'.$date.'" WHERE `Req_ControlNum` = "'.$ctrlnum.'";
                        INSERT INTO `drs_history` (`drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`)
                            SELECT `drs`.`Req_ControlNum`, '.$version.',`drs`.`Process_Date`, `drs`.`Req_Status`, `docreqs`.`Prereq_File_ID`, `drs`.`Handler_ID`, `drs`.`Remarks` FROM `drs`
                            JOIN (SELECT `Req_ControlNum`, `Prereq_File_ID` FROM `drs_docreqs`)`docreqs` ON `drs`.`Req_ControlNum`= `docreqs`.`Req_ControlNum`
                        WHERE `drs`.`Req_ControlNum` = "'.$ctrlnum.'";
                        COMMIT';
                $res = mysqli_multi_query($conn, $sql);
                if($res){
                    echo json_encode(array(true, 'Rejected'));
                }else{
                    echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
                }
            break;
            case 7:
                $ctrlnum = $_POST['ctrlnum'];
                $reason = $_POST['reason'];
                $handler = $_POST['handler'];
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d H:i:s");
                $ver = 'SELECT COUNT(`drs_process`) AS "Version" FROM `drs_history` WHERE `drs_ctrlnum` = "'.$ctrlnum.'"';
                $runver = mysqli_query($conn, $ver);
                while ($verrow= mysqli_fetch_assoc($runver)){
                  $version = $verrow['Version'];
                }
                $sql = 'BEGIN;
                        UPDATE `drs` SET `Req_Status` = "Resubmission", `Handler_ID` ="'.$handler.'", `Remarks` ="'.$reason.'", `Process_Date` ="'.$date.'" WHERE `Req_ControlNum` = "'.$ctrlnum.'";
                        INSERT INTO `drs_history` (`drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`)
                            SELECT `drs`.`Req_ControlNum`, '.$version.',`drs`.`Process_Date`, `drs`.`Req_Status`, `docreqs`.`Prereq_File_ID`, `drs`.`Handler_ID`, `drs`.`Remarks` FROM `drs`
                            JOIN (SELECT `Req_ControlNum`, `Prereq_File_ID` FROM `drs_docreqs`)`docreqs` ON `drs`.`Req_ControlNum`= `docreqs`.`Req_ControlNum`
                        WHERE `drs`.`Req_ControlNum` = "'.$ctrlnum.'";
                        COMMIT';
                $res = mysqli_multi_query($conn, $sql);
                if($res){
                    echo json_encode(array(true, 'Resubmit'));
                }else{
                    echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
                }
            break;
            case 8:
                $sql = 'SELECT Personal_ID, CONCAT_WS(" ", `FName`, `MName`, `LName`) AS "Handler_Name" FROM `user` WHERE `Type` IN (1, 2, 4)';
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
            break;
            case 9:
                $ctrlnum = $_POST['ctrlnum'];
                $new = $_POST['newhandler'];    
                $sql = 'UPDATE `drs` SET `Handler_ID` ="'.$new.'" WHERE `Req_ControlNum` = "'.$ctrlnum.'"';
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo json_encode(array(true, 'Changed'));
                }else{
                    echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
                }
            break;
            case 10:
                $reqname = $_POST['filename'];
                $ctrlnum = $_POST['ctrlnum'];

                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d H:i:s");
                $getauth = 'SELECT `Req_AuthorID`, `user`.`LName`
                    FROM `drs`
                    JOIN (SELECT `LName`, `Personal_ID` FROM `user`)`user` ON `drs`.`Req_AuthorID` = `user`.`Personal_ID` 
                    WHERE `drs`.`Req_ControlNum` ="'.$ctrlnum.'"';

                $runauth = mysqli_query($conn, $getauth);
                while($namereq = mysqli_fetch_array($runauth)) {
                  $surname = $namereq['LName'];
                }

                if(isset($_FILES)) {
                    $uploadLoc = '../files/document-req';
                    
                    if(!file_exists($uploadLoc))
                        mkdir($uploadLoc, 0777, true);

                    $file = $_FILES['UploadReq']['name'];
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $valid = array('pdf');

                    if(in_array($ext, $valid)) {
                        $surname = str_replace(' ', '-', $surname);

                        $reqname = str_replace(' ', '-', $reqname);
                        $reqname = preg_replace('/[^A-Za-z0-9\-]/', '', $reqname);

                        $filename = $ctrlnum.'_'.$surname.'_'.$reqname.'.'.$ext;
                        $path = $uploadLoc.'/'.$filename;
                        $dbpath = 'files/document-req/'.$filename;
                        $ver = 'SELECT COUNT(`drs_process`) AS "Version" FROM `drs_history` WHERE `drs_ctrlnum` = "'.$ctrlnum.'"';
                        $runver = mysqli_query($conn, $ver);
                        while ($verrow= mysqli_fetch_assoc($runver)){
                          $version = $verrow['Version'];
                        }

                        if(move_uploaded_file($_FILES['UploadReq']['tmp_name'], $path)) {
                            $sql = 'BEGIN;
                                    INSERT INTO drs_files (File_ControlNum, File_Desc) VALUES ("'.$ctrlnum.'","'.$dbpath.'");
                                    UPDATE drs SET `Req_Status` = "Completed", `Req_DelDate` = "'.$date.'", `Process_Date` = "'.$date.'" WHERE Req_ControlNum = "'.$ctrlnum.'";
                                    UPDATE drs_docreqs, drs_files SET drs_docreqs.`Req_File_ID` = drs_files.`File_ID` WHERE `drs_files`.`File_Desc` = "'.$dbpath.'" 
                                        AND drs_docreqs.`Req_ControlNum` = "'.$ctrlnum.'";
                                    INSERT INTO `drs_history` (`drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`)
                                        SELECT `drs`.`Req_ControlNum`, '.$version.' ,`drs`.`Process_Date`, `drs`.`Req_Status`, `docreqs`.`Req_File_ID`, `drs`.`Handler_ID`, `drs`.`Remarks` FROM `drs`
                                        JOIN (SELECT `Req_ControlNum`, `Req_File_ID` FROM `drs_docreqs`)`docreqs` ON `drs`.`Req_ControlNum`= `docreqs`.`Req_ControlNum`
                                        WHERE `drs`.`Req_ControlNum` = "'.$ctrlnum.'";
                                    COMMIT';

                            if(mysqli_multi_query($conn, $sql))
                              echo json_encode(array(true, 'Document Sent!'));
                            else
                              echo json_encode(array(false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
                        }
                    } else {
                        echo json_encode(array(false, 'Invalid Document Type. Upload PDF only'));
                    }
                } else {
                  echo json_encode(array(false, 'Document not uploaded.'));
                }
                break;
        }
	}
	mysqli_close($conn);
?>  