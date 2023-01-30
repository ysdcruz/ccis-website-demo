<?php
date_default_timezone_set('Asia/Manila');
include 'dbconn.php';
$uploadLoc = '../files/document-req/';
if(is_dir($uploadLoc) === false)
    mkdir($uploadLoc, 0777, true);

  if(count($_POST) > 0) {
		switch($_POST['type']) {
			case 1: 
                $docu = $_POST['docu'];
                $sql = 'SELECT `Doc_Prereq` FROM `drs_type` WHERE `type_ID` = "'.$docu.'"';
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                if(is_null($row['Doc_Prereq']))
                    echo json_encode(array('None'));
                else
                    echo json_encode(array($row['Doc_Prereq']));
				break;
      case 2: 
                $max = 'SELECT AUTO_INCREMENT AS ID FROM information_schema.tables WHERE table_name = "drs"';
                $runmax = mysqli_query($conn, $max);
                while ($maxrow = mysqli_fetch_assoc($runmax)){
                  $id = $maxrow['ID'];
                }
                $lastid = sprintf("%04d", $id);
                date_default_timezone_set('Asia/Manila');
                $yr = date ("Y");
                $date = date("Y-m-d H:i:s");
                $ctrlnum = $yr."-".$lastid;
                $author = $_POST['Author'];
                $docu = $_POST['req-docu'];
                $purpose = $_POST['purpose-req'];
                $reqdate = $_POST['req-date'];
                $submit = true;
                $checkauthor = 'SELECT `Course` AS Course,`Admit_Yr` AS Admit_YR FROM `student_background` WHERE `Personal_ID` ="'.$author.'"';
                $runauth = mysqli_query($conn, $checkauthor);
                if (mysqli_num_rows($runauth)==0){
                  $submit = false;
                }
                if($submit){
                    $ver = 'SELECT COUNT(`drs_process`) AS "Version" FROM `drs_history` WHERE `drs_ctrlnum` = "'.$ctrlnum.'"';
                    $runver = mysqli_query($conn, $ver);
                    while ($verrow= mysqli_fetch_assoc($runver)){
                      $version = $verrow['Version'];
                    }
                  if($reqdate!="")
                  {
                    $sql = 'BEGIN;
                            INSERT INTO drs (Req_ControlNum, Req_AuthorID, Req_Date, Req_Purpose, Req_Urgency, Req_Status) VALUES ("'.$ctrlnum.'","'.$author.'","'.$date.'","'.$purpose.'","'.$reqdate.'","Pending");
                            INSERT INTO drs_docreqs (Req_ControlNum, Req_TypeID) VALUES ("'.$ctrlnum.'",'.$docu.');
                            INSERT INTO `drs_history` (`drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`)
                              SELECT `drs`.`Req_ControlNum`, '.$version.' ,`drs`.`Req_Date`, `drs`.`Req_Status`, `docreqs`.`Prereq_File_ID`, `drs`.`Handler_ID`, `drs`.`Remarks` FROM `drs`
                              JOIN (SELECT `Req_ControlNum`, `Prereq_File_ID` FROM `drs_docreqs`)`docreqs` ON `drs`.`Req_ControlNum`= `docreqs`.`Req_ControlNum`
                              WHERE `drs`.`Req_ControlNum` = "'.$ctrlnum.'";
                            COMMIT';
                  }
                  else{
                    $sql = 'BEGIN;
                            INSERT INTO drs (Req_ControlNum, Req_AuthorID, Req_Date, Req_Purpose, Req_Status) VALUES ("'.$ctrlnum.'","'.$author.'","'.$date.'","'.$purpose.'","Pending");
                            INSERT INTO drs_docreqs (Req_ControlNum,Req_TypeID) VALUES ("'.$ctrlnum.'",'.$docu.');
                            INSERT INTO `drs_history` (`drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`)
                              SELECT `drs`.`Req_ControlNum`, '.$version.' ,`drs`.`Req_Date`, `drs`.`Req_Status`, `docreqs`.`Prereq_File_ID`, `drs`.`Handler_ID`, `drs`.`Remarks` FROM `drs`
                              JOIN (SELECT `Req_ControlNum`, `Prereq_File_ID` FROM `drs_docreqs`)`docreqs` ON `drs`.`Req_ControlNum`= `docreqs`.`Req_ControlNum`
                              WHERE `drs`.`Req_ControlNum` = "'.$ctrlnum.'";
                            COMMIT';
                  }
                  if(mysqli_multi_query($conn, $sql))
                    echo json_encode(array(true, 'Document Request Sent!'));
                  else
                    echo json_encode(array(false, true, 'Error: ' . $sql . '\n' . mysqli_error($conn)));
                  }
                else{
                  echo json_encode(array(false, false, 'Please set you educational background details first!'));
                }
        break;
      case 3:
                $author = $_POST['Author'];
                $purpose = $_POST['purpose-req'];
                $reqdate = $_POST['req-date'];
                $docu = $_POST['req-docu'];
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d H:i:s");
                $submit = true;

                $sqlname = 'SELECT `LName` FROM user WHERE `Personal_ID`="'.$author.'"';
                $runsql = mysqli_query($conn, $sqlname);
                while($namereq = mysqli_fetch_array($runsql)){
                  $surname = $namereq['LName'];
                }
                $max = 'SELECT AUTO_INCREMENT AS ID FROM information_schema.tables WHERE table_name = "drs"';
                $reqname = $_POST['Filename'];
                $runmax = mysqli_query($conn, $max);
                  while ($maxrow = mysqli_fetch_assoc($runmax)){
                    $id = $maxrow['ID'];
                  }
                $lastid = sprintf("%04d", $id);
                $yr = date ("Y");
                $ctrlnum = $yr."-".$lastid;
                $checkauthor = 'SELECT `Course` AS Course,`Admit_Yr` AS Admit_YR FROM `student_background` WHERE `Personal_ID` ="'.$author.'"';
                $runauth = mysqli_query($conn, $checkauthor);
                if (mysqli_num_rows($runauth)==0){
                  $submit = false;
                }

                if($submit){
                      if($_FILES['Prereq']['error'] == 0){
                        $ver = 'SELECT COUNT(`drs_process`) AS "Version" FROM `drs_history` WHERE `drs_ctrlnum` = "'.$ctrlnum.'"';
                        $runver = mysqli_query($conn, $ver);
                        while ($verrow= mysqli_fetch_assoc($runver)){
                          $version = $verrow['Version'];
                        }
                        $file = $_FILES['Prereq']['name'];
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $valid = array('pdf');
                        if(in_array($ext, $valid)) {
                          $filename = $ctrlnum.'_'.$surname.'_'.$reqname.'.'.$ext;
                          $path = $uploadLoc.$filename;
                          $dbpath = 'files/document-req/'.$filename;
                          $upload = move_uploaded_file($_FILES['Prereq']['tmp_name'], $path);
                          if($upload){
                            if($reqdate!=""){
                              $sql = 'BEGIN;
                                      INSERT INTO drs (Req_ControlNum, Req_AuthorID, Req_Date, Req_Purpose, Req_Urgency, Req_Status) VALUES ("'.$ctrlnum.'","'.$author.'","'.$date.'","'.$purpose.'","'.$reqdate.'","Pending");
                                      INSERT INTO drs_files (File_ControlNum, File_Desc) VALUES ("'.$ctrlnum.'","'.$dbpath.'");
                                      INSERT INTO drs_docreqs (Req_ControlNum,Req_TypeID,Prereq_File_ID) SELECT "'.$ctrlnum.'",'.$docu.', `File_ID` FROM `drs_files` WHERE `File_ControlNum` = "'.$ctrlnum.'";
                                      INSERT INTO `drs_history` (`drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`)
                                        SELECT `drs`.`Req_ControlNum`, '.$version.' ,`drs`.`Req_Date`, `drs`.`Req_Status`, `docreqs`.`Prereq_File_ID`, `drs`.`Handler_ID`, `drs`.`Remarks` FROM `drs`
                                        JOIN (SELECT `Req_ControlNum`, `Prereq_File_ID` FROM `drs_docreqs`)`docreqs` ON `drs`.`Req_ControlNum`= `docreqs`.`Req_ControlNum`
                                        WHERE `drs`.`Req_ControlNum` = "'.$ctrlnum.'";
                                      COMMIT';
                              }
                            else{
                              $sql = 'BEGIN;
                                      INSERT INTO drs (Req_ControlNum, Req_AuthorID, Req_Date, Req_Purpose, Req_Status) VALUES ("'.$ctrlnum.'","'.$author.'","'.$date.'","'.$purpose.'","Pending");
                                      INSERT INTO drs_files (File_ControlNum, File_Desc) VALUES ("'.$ctrlnum.'","'.$dbpath.'");
                                      INSERT INTO drs_docreqs (Req_ControlNum,Req_TypeID,Prereq_File_ID) SELECT "'.$ctrlnum.'",'.$docu.', `File_ID` FROM `drs_files` WHERE `File_ControlNum` = "'.$ctrlnum.'";
                                      INSERT INTO `drs_history` (`drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`)
                                        SELECT `drs`.`Req_ControlNum`, '.$version.' ,`drs`.`Req_Date`, `drs`.`Req_Status`, `docreqs`.`Prereq_File_ID`, `drs`.`Handler_ID`, `drs`.`Remarks` FROM `drs`
                                        JOIN (SELECT `Req_ControlNum`, `Prereq_File_ID` FROM `drs_docreqs`)`docreqs` ON `drs`.`Req_ControlNum`= `docreqs`.`Req_ControlNum`
                                        WHERE `drs`.`Req_ControlNum` = "'.$ctrlnum.'";
                                      COMMIT';
                              }
                              if(mysqli_multi_query($conn, $sql))
                                echo json_encode(array(true, 'Document Request Sent!'));
                              else
                                echo json_encode(array(false, true, 'Error: ' . $sql . '\n' . mysqli_error($conn))); 
                          }
                          else
                            echo json_encode(array(false, false, true, 'Document Not Uploaded'));
                        }
                        else
                        {
                          echo json_encode(array(false, false, false, true, 'Invalid Document Type. Upload PDF only'));
                        }
                      }
                  }
                  else{
                    echo json_encode(array(false, false, 'Please set you educational background details first!'));
                  }
        break;
      case 4: 
                $author = $_POST['Author'];
                $reqname = $_POST['Filename'];
                $prevreq = $_POST['Prevreq'];
                $sqlname = 'SELECT `LName` FROM user WHERE `Personal_ID`="'.$author.'"';
                $runsql = mysqli_query($conn, $sqlname);
                while($namereq = mysqli_fetch_array($runsql)){
                  $surname = $namereq['LName'];
                }
                $getctrl = 'SELECT `File_ControlNum` AS "ctrl" FROM `drs_files` WHERE `File_Desc` = "'.$prevreq.'"';
                $runctrl = mysqli_query($conn, $getctrl);
                  while ($res = mysqli_fetch_assoc($runctrl)){
                    $ctrlnum = $res['ctrl'];
                  }
                $getcount = 'SELECT COUNT(`File_ControlNum`) AS "count" FROM `drs_files` WHERE `File_ControlNum` = "'.$ctrlnum.'"';
                $runcount = mysqli_query($conn, $getcount);
                  while ($rescount = mysqli_fetch_assoc($runcount)){
                    $count= $rescount['count'];
                  }
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d H:i:s");
                if(isset($_FILES)){
                        $file = $_FILES['Newreq']['name'];
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $valid = array('pdf');
                        if(in_array($ext, $valid)) {
                          $filename = $ctrlnum.'_'.$surname.'_'.$reqname.'('.$count.').'.$ext;
                          $path = $uploadLoc.$filename;
                          $dbpath = 'files/document-req/'.$filename;
                          $upload = move_uploaded_file($_FILES['Newreq']['tmp_name'], $path);
                          if($upload){
                            $ver = 'SELECT COUNT(`drs_process`) AS "Version" FROM `drs_history` WHERE `drs_ctrlnum` = "'.$ctrlnum.'"';
                            $runver = mysqli_query($conn, $ver);
                            while ($verrow= mysqli_fetch_assoc($runver)){
                              $version = $verrow['Version'];
                            }
                            $sql = 'BEGIN;
                                    INSERT INTO drs_files (File_ControlNum, File_Desc) VALUES ("'.$ctrlnum.'","'.$dbpath.'");
                                    UPDATE drs SET `Req_Status` = "Accepted", `Process_Date`="'.$date.'" WHERE Req_ControlNum = "'.$ctrlnum.'";
                                    UPDATE drs_docreqs, drs_files SET drs_docreqs.`Prereq_File_ID` = drs_files.`File_ID` WHERE `drs_files`.`File_Desc` = "'.$dbpath.'" 
                                      AND drs_docreqs.`Req_ControlNum` = "'.$ctrlnum.'";
                                    INSERT INTO `drs_history` (`drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`)
                                      SELECT `drs`.`Req_ControlNum`, '.$version.' ,`drs`.`Process_Date`, `drs`.`Req_Status`, `docreqs`.`Prereq_File_ID`, `drs`.`Handler_ID`, `drs`.`Remarks` FROM `drs`
                                      JOIN (SELECT `Req_ControlNum`, `Prereq_File_ID` FROM `drs_docreqs`)`docreqs` ON `drs`.`Req_ControlNum`= `docreqs`.`Req_ControlNum`
                                      WHERE `drs`.`Req_ControlNum` = "'.$ctrlnum.'";
                                    COMMIT';
                          }
                            if(mysqli_multi_query($conn, $sql))
                              echo json_encode(array(true, 'Document Resubmission Sent!'));
                            else
                              echo json_encode(array(false, false, 'Error: ' . $sql . '\n' . mysqli_error($conn)));        
                        }
                        else{
                          echo json_encode(array(false, true, 'Invalid Document Type. Upload PDF only'));
                        }
                }
                else{
                  echo json_encode(array(false, 'Required document not uploaded.'));
                }
          break;
      case 5:
                $ctrlnum = $_POST['ctrlnum'];
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d H:i:s");
                $ver = 'SELECT COUNT(`drs_process`) AS "Version" FROM `drs_history` WHERE `drs_ctrlnum` = "'.$ctrlnum.'"';
                $runver = mysqli_query($conn, $ver);
                while ($verrow= mysqli_fetch_assoc($runver)){
                  $version = $verrow['Version'];
                }
                $cancelsql = 'BEGIN;
                              UPDATE `drs` SET `Req_Status` = "Cancelled", `Process_Date` = "'.$date.'" WHERE `Req_ControlNum` = "'.$ctrlnum.'";
                              INSERT INTO `drs_history` (`drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`)
                                SELECT `drs`.`Req_ControlNum`, '.$version.' ,`drs`.`Process_Date`, `drs`.`Req_Status`, `docreqs`.`Prereq_File_ID`, `drs`.`Handler_ID`, `drs`.`Remarks` FROM `drs`
                                JOIN (SELECT `Req_ControlNum`, `Prereq_File_ID` FROM `drs_docreqs`)`docreqs` ON `drs`.`Req_ControlNum`= `docreqs`.`Req_ControlNum`
                                WHERE `drs`.`Req_ControlNum` = "'.$ctrlnum.'";
                              COMMIT';
                $res = mysqli_multi_query($conn, $cancelsql);
                if($res)
                  echo json_encode(array(true, 'Document Cancelled!', $res, $ctrlnum));
                else
                  echo json_encode(array(false, 'Error: ' . $cancelsql . '\n' . mysqli_error($conn)));
          break;
      case 6:
                $ctrlnum = $_POST['ctrlnum'];
                $history = array();
                $sql = 'SELECT `histo`.`drs_ctrlnum` AS `ctrlnum`, `histo`.`drs_process` AS `process`, date_format(`histo`.`drs_date`, "%M %d, %Y") AS `prodate`, date_format(`histo`.`drs_date`, "%h:%i %p") AS `protime`,	
                        `histo`.`drs_status` AS `status`, `histo`.`Remarks` AS `remarks`, `files`.`File_Desc` AS `prereq`, `user`.`Handler`, `docreq`.`Doc_Prereq` AS `prereqname`, 
                        `drs`.`Req_Urgency` AS `urgent`, `drs`.`Req_Purpose` AS `purpose`, `docreq`.`Doc_Type` AS `reqname`
                        FROM `drs_history` `histo`
                        LEFT JOIN (SELECT `Personal_ID`, CONCAT(`LName`, ", ", SUBSTRING(`FName`,1,1), ".") AS "handler" FROM `user`)`user` 
                          ON `user`.`Personal_ID` = `histo`.`drs_Handler_ID`
                        LEFT JOIN (SELECT `File_ID`, `File_Desc` FROM `drs_files`)`files` 
                          ON `files`.`File_ID` = `histo`.`drs_file_ID`
                        LEFT JOIN (SELECT `Req_ControlNum`, `Req_Urgency`, `Req_Purpose` FROM `drs`)`drs` 
                          ON `drs`.`Req_ControlNum` = `histo`.`drs_ctrlnum`
                        LEFT JOIN (SELECT `Req_TypeID`, `Req_ControlNum`, `type`.`Doc_Prereq`, `type`.`Doc_Type` FROM `drs_docreqs`
                          LEFT JOIN (SELECT `Doc_Prereq`, `type_ID`, `Doc_Type` FROM `drs_type`)`type`
                            ON `type`.`type_ID` = `Req_TypeID`) `docreq`
                        ON `docreq`.`Req_ControlNum` = `histo`.`drs_ctrlnum`
                        WHERE `histo`.`drs_ctrlnum` =  "'.$ctrlnum.'"
                        ORDER BY `drs_process` DESC';
                $result = mysqli_query($conn, $sql);
                if($result) {
                  while($row = mysqli_fetch_assoc($result)) {
                    $history[] = $row;
                  }
                } 
                echo json_encode($history);
          break;
    }
	}
	mysqli_close($conn);
?>  