<?php
include_once '../Database/dbConnect.php';
include_once '../Element/SyncObj.php';

function writeProfileSync($userID, $syncDate, $syncTime){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$syncToken = randString(10);
	$q = "insert into Sync values ('0', '$userID', '$syncToken', '$syncDate', '$syncTime', '0', '0', '0', '0', '0', '0', '0', '0')";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();  
}

function updateProfileSync($userID, $syncDate, $syncTime){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();

	$syncToken = randString(10);

	$q = "update Sync SET syncToken='$syncToken', syncProfDate='$syncDate', syncProfTime='$syncProfTime' WHERE UserID='$userID' ";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
}

function updateGroupSync($userID, $contactAmount, $syncDate, $syncTime, $increase){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	
	$syncToken = randString(10);

	if($increase == "true"){
$q = "update Sync SET syncToken='$syncToken', syncGrpDate='$syncDate', syncGrpTime='$syncTime', syncGrpAmount= syncGrpAmount + 1, syncConAmount= syncConAmount + $contactAmount WHERE UserID='$userID' ";
	}else{
$q = "update Sync SET syncToken='$syncToken', syncGrpDate='$syncDate', syncGrpTime='$syncTime', syncGrpAmount= syncGrpAmount - 1, syncConAmount= syncConAmount - $contactAmount WHERE UserID='$userID' ";
	}
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
}


function updateImageSync($userID, $imgAmount, $syncDate, $syncTime, $increase){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();

	$syncToken = randString(10);

	if($increase == "true"){
		$syncAmount =  "1";
	}else{
		$syncAmount = "-1";
	}
	$q = "update Sync SET syncToken='$syncToken', syncAlbDate='$syncDate', syncAlbTime='$syncTime', syncAlbAmount= syncAlbAmount +$syncAmount, syncImgAmount='$imgAmount' WHERE UserID='$userID' ";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();

}

function getSyncDetails(){
	$syncObj = new SyncObj();
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	$syncObj->fill($obj['syncUserID'], 
			$obj['syncToken'],
			$obj['syncImgDate'], 
			$obj['syncImgTime'], 
			$obj['syncGrpDate'],
			$obj['syncGrpTime'], 
			$obj['syncProfDate'], 
			$obj['syncProfTime'], 
			$obj['syncAlbAmount'], 
			$obj['syncImgAmount'], 
			$obj['syncGrpAmount'],
			$obj['syncConAmount']);

	return $syncObj;
}


function getSyncObj($userID){
	$syncObj = new SyncObj();
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "select * from Sync where UserID='$userID'";
		$userRes = mysql_query($q) or die("couldn't find user in database");
		while($qryRow = mysql_fetch_array($userRes)){
			$syncObj->fill($qryRow[1], $qryRow[2], $qryRow[5], $qryRow[6], $qryRow[9], $qryRow[10], $qryRow[3], $qryRow[4], $qryRow[7], $qryRow[8], $qryRow[11], $qryRow[12]);
		} 
	$sqlCon->sqlClose();  
	return $syncObj;
}
?>
