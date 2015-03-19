<?php
include_once '../../Database/dbConnect.php';
include_once '../../Database/genToken.php';

function writeMessage($msg, $actDate, $actTime){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$msgToken = randString(10);
	$ip_address = $_SERVER['REMOTE_ADDR'];
	
	$msg->mDate = $actDate;
	$msg->mTime = $actTime;

	$q = "insert into Messages values ('0', '$msg->MID', '$msg->UserID', '$msg->UserName', '$msg->Type', '$msg->Content', '$msg->RecipientID', '$msg->RecipientGrpID','$msg->mDate', '$msg->mTime', '$ip_address')";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();  
}

function updateMessage($msg){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$msgToken = randString(10);
	$q = "Update Messages SET MessageID='$MID', UserID='$msg->UserID', UserName='$msg->UserName', Type='$msg->Type', Content='$msg->Content', RecipientID='$msg->RecipientID', RecipientGrpID='$msg->RecipientGrpID', mDate='$msg->mDate', mTime='$msg->mTime', ip_address='$ip_address'";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();  
}

function getLifeMessages($userID, $syncDate, $syncTime){
	$life = new LifeMessage();
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	if($syncDate == "0000-00-00"){
		$q = "SELECT * FROM (select * from Messages where UserID='$userID' OR RecipientID='$userID' ORDER BY id DESC LIMIT 10)sub ORDER BY id ASC";
	}else{
		$currentTime = date('H:i:s', time());
		$q = "select * from Messages where UserID='$userID' OR where RecipientID='$userID' and WHERE Timestamp(syncDate, syncTime) >= Timestamp('$syncDate','$syncTime')"; 
	}
	$userRes = mysql_query($q) or die("couldn't find user in database");
	while($qryRow = mysql_fetch_array($userRes)){
		$life->fillMessage($qryRow[1], $qryRow[2], $qryRow[3], $qryRow[4], $qryRow[5],$qryRow[6],$qryRow[7],$qryRow[8],$qryRow[9]);
	}
	$sqlCon->sqlClose();  
	return $life;
}

function getMoreMessages($userID, $cached){
	$life = new LifeMessage();
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "select * from Messages where UserID='$userID' OR where RecipientID='$userID' DESC LIMIT '$cached',10"; 

	$userRes = mysql_query($q) or die("couldn't find user in database");
	while($qryRow = mysql_fetch_array($userRes)){
		$life->fillMessage($qryRow[1], $qryRow[2], $qryRow[3], $qryRow[4], $qryRow[5],$qryRow[6],$qryRow[7],$qryRow[8],$qryRow[9]);
	}
	$sqlCon->sqlClose();  
	return $life;
}


function getLifeMsgDetails(){
	$life = new LifeMessage();

	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
			// echo all data
			foreach($obj['messages'] as $key => $value) {
				$life->fillMessage($value['MID'], 
					$value['AuthorID'], 
					$value['AuthorName'], 
					$value['Type'], 
					$value['Content'], 
					$value['ReceiverID'], 
					$value['ReceiverGrpID'], 
					$value['mDate'], 
					$value['mTime']); 
			} 
			return $life;
}
?>
