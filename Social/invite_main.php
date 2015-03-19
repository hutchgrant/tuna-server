<?php
include_once '../Database/dbConnect.php';
include_once '../Database/genToken';

/*
 *  Get the group details from json post
 */ 
function getInviteDetails($authorID){

	$invites = new LifeInvite();
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
			
			foreach($obj['invites'] as $key => $value) {
				$invites->fillInvite($value['InviteID'],$value['InviteUserGID'],$value['InviteUserName'], $value['RecipientName'], $value['RecipientUserGID'],$value['RecipientEmail'], $value['RecipientPhone'], $value['InviteDate'], $value['InviteTime'],$value['InviteStatus']);
			}
			return $invites;
} 

function writeInvite($invite){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
   	$IPaddress = $_SERVER['REMOTE_ADDR'];
	$q = "insert into Invites values ('0', '$invite->InviteID', '$invite->InviteStatus', '$invite->InviteUserGID', '$invite->InviteName', '$invite->RecipientName', '$invite->RecipientUserGID', '$invite->RecipientEmail', '$invite->RecipientPhone', '$invite->InviteDate', '$invite->InviteTime')";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
	return $invite;

}

function updateInvite($invite){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
   	$IPaddress = $_SERVER['REMOTE_ADDR'];
	$invite->InviteDate =  date('Y-m-d');
	$invite->InviteTime = date('H:i:s', time());
	$q = "update Invites SET InviteStatus='$invite->InviteStatus', InviteDate='$invite->InviteDate', InviteTime='$invite->InviteTime' WHERE InviteUserGID='$invite->InviteUserGID' AND InviteID='$invite->InviteID'";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
	// update sync invite amount, date, time
	return $invite;
}

function removeInvite($userID, $inviteType, $inviteID){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();

	if( $inviteType == "sent" ){
		$q = "delete from Invites where InviteUserGID='$userID' AND InviteID='$InviteID'";
	}else{
		$q = "delete from Invites where RecipientUserGID='$userID' AND InviteID='$InviteID'";
	}
	
	$sqlCon->finQry($q);
	// update sync invite amount, date, time
	$sqlCon->sqlClose();
} 

/*
* inviteType = sent / received
*/

function readInvites($userID, $syncDate, $syncTime){
	 $sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$finQry = "";
	if($syncDate == "na"){
			$q = "select * from Invites where InviteUserGID='$userID' OR RecipientUserGID='$userID'";
	}else{
			$currentTime = date('H:i:s', time());
			$q = "select * from Invites where InviteUserGID='$userID' OR where RecipientUserGID='$userID' and WHERE Timestamp(syncDate, syncTime) >= Timestamp('$syncDate','$syncTime')"; 
	}
	$userRes = mysql_query($q);
	$life = new LifeInvite();
	while($qryRow = mysql_fetch_array($userRes)){
		$life->fillInvite($qryRow[1], $qryRow[3], $qryRow[4], $qryRow[5], $qryRow[6], $qryRow[7], $qryRow[8], $qryRow[9], $qryRow[10], $qryRow[2]);
	}
	$sqlCon->sqlClose();   
	return $life;

}

/*
* inviteType = received GID, email, phone
*/

function readReceivedInvites($userID, $email, $phone){
	 $sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$finQry = "";
	$q = "select * from Invites where RecipientUserGID='$userID' OR RecipientUserEmail='$email' OR RecipientUserPhone='$phone'";
	$userRes = mysql_query($q);
	$life = new LifeInvite();
	while($qryRow = mysql_fetch_array($userRes)){
		$life->fillInvite($qryRow[1], $qryRow[3], $qryRow[4], $qryRow[5], $qryRow[6], $qryRow[7], $qryRow[8], $qryRow[9], $qryRow[10], $qryRow[2]);
	}
	$sqlCon->sqlClose();   
	return $life;

}

function addUserFriends($userID, $friendID){

	$userFriendGrpID = getFriendGroupID($userID);  /// reminder
	$recepFriendGrpID = getFriendGroupID($friendID);

	$user = new User();
	$friend = new User();

	$userContact = new Contact();
	$friendContact = new Contact();

	$user = selectUserUSR($userID);
	$friend = selectUserUSR($friendID);

	$userContact = ConvertUserToContact($user, $recepFriendGrpID);  // remind
	$friendContact = ConvertUserToContact($friend, $userFriendGrpID);  // remind


	writeContact($friendContact, $userID);
	writeContact($userContact, $friendID);

	$actDate = date('Y-m-d');
	$actTime =  date('H:i:s', time());

	updateFriendGroup($userID, $userFriendGrpID, $actDate, $actTime);
	updateFriendGroup($friendID, $recepFriendGrpID, $actDate, $actTime);

	updateFriendSync($userID, $actDate, $actTime);
	updateFriendSync($friendID, $actDate, $actTime); 
}
?>


