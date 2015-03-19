<?php
include_once '../Database/dbConnect.php';
include_once '../Database/genToken.php';
include_once '../Element/SyncObj.php';

function writeProfileSync($userID, $syncDate, $syncTime){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$syncToken = randString(10);
	$q = "insert into Sync values ('0', '$userID', '$syncToken', '$syncDate', '$syncTime', '0', '0', '0', '0', '0', '0', '1', '0', 'na', '0', '0', '0', '0', '0', '0', '0', '0', '0')";
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

function updateContactSync($userID, $contactAmount, $syncDate, $syncTime, $increase){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	
	$syncToken = randString(10);

	if($increase == "true"){
$q = "update Sync SET syncToken='$syncToken', syncGrpDate='$syncDate', syncGrpTime='$syncTime', syncConAmount= syncConAmount + $contactAmount WHERE UserID='$userID' ";
	}else{
$q = "update Sync SET syncToken='$syncToken', syncGrpDate='$syncDate', syncGrpTime='$syncTime', syncConAmount= syncConAmount - $contactAmount WHERE UserID='$userID' ";
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

function updateFriendSync($userID, $syncDate, $syncTime){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();

	$syncToken = randString(10);
	$q = "update Sync SET syncToken='$syncToken', syncGrpDate='$syncDate', syncGrpTime='$syncTime', syncConAmount= syncConAmount + 1 WHERE UserID='$userID' ";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
}

/*
*  Update_type = add / remove  : + / - from amount
*  invite_type = sent/ receive  : which amount to add/remove from.
*/  
function updateInvSync($userID, $update_type, $invite_type, $invDate, $invTime){
	$finalToken = randString(10);
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	
	 if($update_type == "add"){
		if($invite_type == "sent"){  
			$q= "update Sync SET inviteToken='$finalToken', inviteDate='$invDate', inviteTime='$invTime', inviteSntAmount= inviteSntAmount +1 WHERE UserID='$userID' ";		
		}else{   /// received invite update
			$q= "update Sync SET inviteToken='$finalToken', inviteDate='$syncDate', inviteTime='$syncTime', inviteRecAmount= inviteRecAmount +1 WHERE UserID='$userID' ";			
		}
	} else{
		if($invite_type == "sent"){
			$q= "update Sync SET inviteToken='$finalToken', inviteDate='$syncDate', inviteTime='$syncTime', inviteSntAmount= inviteSntAmount -1 WHERE UserID='$userID' ";		
		}else{   /// received invite update
			$q= "update Sync SET inviteToken='$finalToken', inviteDate='$syncDate', inviteTime='$syncTime', inviteRecAmount= inviteRecAmount -1 WHERE UserID='$userID' ";			
		}
	} 
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
}

function updateInvReceived($userID, $count, $invDate, $invTime){
	$finalToken = randString(10);
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q= "update Sync SET inviteToken='$finalToken', inviteDate='$invDate', inviteTime='$invTime', inviteRecAmount= inviteRecAmount+'$count' WHERE UserID='$userID' ";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
}

/*
*  Update_type = add / remove  : + / - from amount
*  invite_type = sent/ receive  : which amount to add/remove from.
*/  
function updateMsgSync($userID, $update_type, $invite_type, $msgDate, $msgTime){
	$finalToken = randString(10);
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	
	 if($update_type == "add"){
		if($invite_type == "sent"){  
			$q= "update Sync SET msgToken='$finalToken', msgDate='$msgDate', msgTime='$msgTime', msgSntAmount= msgSntAmount +1 WHERE UserID='$userID' ";		
		}else{   /// received invite update
			$q= "update Sync SET msgToken='$finalToken', msgDate='$syncDate', msgTime='$syncTime', msgRecAmount= msgRecAmount +1 WHERE UserID='$userID' ";			
		}
	} else{
		if($invite_type == "sent"){
			$q= "update Sync SET msgToken='$finalToken', msgDate='$msgDate', msgTime='$msgTime', msgSntAmount= msgSntAmount -1 WHERE UserID='$userID' ";		
		}else{   /// received invite update
			$q= "update Sync SET msgToken='$finalToken', msgDate='$syncDate', msgTime='$syncTime', msgRecAmount= msgRecAmount -1 WHERE UserID='$userID' ";			
		}
	} 
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

	$syncObj->fillInvite($obj['syncInviteToken'],
			$obj['syncInviteDate'],
			$obj['syncInviteTime'],
			$obj['syncInvRecAmount'],
			$obj['syncInvSntAmount']);

	$syncObj->fillMessage($obj['syncMsgToken'],
			$obj['syncMsgDate'],
			$obj['syncMsgTime'],
			$obj['syncMsgRecAmount'],
			$obj['syncMsgSntAmount']);

	return $syncObj;
}

function getInvDetails(){
	$sync = new SyncInvObj();
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	$sync->fill(	$obj['syncInviteToken'],
			$obj['syncInviteDate'],
			$obj['syncInviteTime'],
			$obj['syncInvRecAmount'],
			$obj['syncInvSntAmount']);
	return $sync;
}

function getSyncMsgDetails(){
	$sync = new SyncMsgObj();
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	$sync->fill(	$obj['syncMsgToken'],
			$obj['syncMsgDate'],
			$obj['syncMsgTime'],
			$obj['syncMsgRecAmount'],
			$obj['syncMsgSntAmount']);
	return $sync;
}

function getSyncToken(){
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	$syncToken = $obj['syncToken'];

	return $syncToken;
}

function getSyncInviteToken(){
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	$syncToken = $obj['syncInviteToken'];

	return $syncToken;
}

function getSyncMessageToken(){
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	$syncToken = $obj['syncMessageToken'];
	return $syncToken;
}

function getServSyncToken($userID){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "select * from Sync where UserID='$userID'";
		$userRes = mysql_query($q) or die("couldn't find user in database");
		while($qryRow = mysql_fetch_array($userRes)){
			$servSyncToken = $qryRow[2];
		} 
	$sqlCon->sqlClose();  
	return $servSyncToken;
}

function getServSyncInviteToken($userID){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "select * from Sync where UserID='$userID'";
		$userRes = mysql_query($q) or die("couldn't find user in database");
		while($qryRow = mysql_fetch_array($userRes)){
			$servSyncToken = $qryRow[13];
		} 
	$sqlCon->sqlClose();  
	return $servSyncToken;
}

function getServSyncMsgToken($userID){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "select * from Sync where UserID='$userID'";
		$userRes = mysql_query($q) or die("couldn't find user in database");
		while($qryRow = mysql_fetch_array($userRes)){
			$servSyncToken = $qryRow[18];
		} 
	$sqlCon->sqlClose();  
	return $servSyncToken;
}

function getSyncObj($userID){
	$sync = new SyncObj();
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "select * from Sync where UserID='$userID'";
		$userRes = mysql_query($q) or die("couldn't find user in database");
		while($qryRow = mysql_fetch_array($userRes)){
			$sync->fill($qryRow[1], $qryRow[2], $qryRow[5], $qryRow[6], $qryRow[9], $qryRow[10], $qryRow[3], $qryRow[4], $qryRow[7], $qryRow[8], $qryRow[11], $qryRow[12]);
			$sync->fillInvite($qryRow[13], $qryRow[14], $qryRow[15], $qryRow[16], $qryRow[17]);
			$sync->fillMessage($qryRow[18], $qryRow[19], $qryRow[20], $qryRow[21], $qryRow[22]);
		} 
	$sqlCon->sqlClose();  
	return $sync;
}

function getSyncInvObj($userID){
	$sync = new SyncInvObj();
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "select * from Sync where UserID='$userID'";
		$userRes = mysql_query($q) or die("couldn't find user in database");
		while($qryRow = mysql_fetch_array($userRes)){
			$sync->fill($qryRow[13], $qryRow[14], $qryRow[15], $qryRow[16], $qryRow[17]);
		} 
	$sqlCon->sqlClose();  
	return $sync;
}

function getSyncMsgObj($userID){
	$sync = new SyncMsgObj();
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "select * from Sync where UserID='$userID'";
		$userRes = mysql_query($q) or die("couldn't find user in database");
		while($qryRow = mysql_fetch_array($userRes)){
			$sync->fill($qryRow[18], $qryRow[19], $qryRow[20], $qryRow[21], $qryRow[22], "0");
		} 
	$sqlCon->sqlClose();  
	return $sync;
}

?>
