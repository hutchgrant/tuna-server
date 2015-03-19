<?php
include_once '../Database/dbConnect.php';

function validateToken($token){
	$errorFree = true;
	if(!preg_match("/^[ -_().,a-zA-Z0-9]+$/i", $token)){
		echo "TUNAERROR: token";
		$errorFree = false;
	}	
	return $errorFree;
}

/*
*  validate image ID input for upload
*/
function validateID($imageID){
	$errorFree = true;
	 if(!preg_match("/^[ -_().,a-zA-Z0-9]+$/i", $imageID) && strlen($imageID) >= 1){
		echo "TUNAERROR: imageID";
		$errorFree = false;
	}
	return $errorFree;
}

/*
* Validate album input for upload
*/
function validateAlbum($album){
	$errorFree = true;
        if(!preg_match("/^[ -_().,a-zA-Z0-9]+$/i", $album->title) && strlen($album->title) >= 1) {
           echo "TUNAERROR : title";
		$errorFree = false;
	}
        if(!preg_match("/^[ -_().,a-zA-Z0-9]+$/i", $album->user) && strlen($album->user) >= 1) {
           echo "TUNAERROR : user";
		$errorFree = false;
	}
        if(!preg_match("/^[ -_.,a-zA-Z0-9]+$/i", $album->id) && strlen($album->id) >= 1) {
           echo "TUNAERROR : id";
		$errorFree = false;
	}
        if(!preg_match("/^[ -_.,a-zA-Z0-9]+$/i", $album->syncDate) && strlen($album->syncDate) >= 1) {
           echo "TUNAERROR : syncDate";
		$errorFree = false;
	}
        if(!preg_match("/^[ -_.,a-zA-Z0-9]+$/i", $album->syncTime) && strlen($album->syncTime) >= 1){
           echo "TUNAERROR : syncTime";
		$errorFree = false;
	}

	foreach($album->photos as $key => $value){
		$error = validatePhoto($value);
		if($error != true){
			$errorFree = $error;
		}
	}
	return $errorFree;
}

/*
* Validate Photo input for upload
*/
function validatePhoto($photo){
	$errorFree = true;
        if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $photo->Title) && strlen($photo->Title) >= 1){
           echo "TUNAERROR : Title PHOTO:".$photo->ID;
		$errorFree = false;
	} 
        if(!preg_match("/^[ -_)(.,a-zA-Z0-9]+$/i", $photo->Description) && strlen($photo->Description) >= 1){
           echo "TUNAERROR : Description PHOTO:".$photo->ID;
		$errorFree = false;
	}
        if(!preg_match("/^[ -_.,a-zA-Z0-9]+$/i", $photo->ID) && strlen($photo->ID) >= 1){
           echo "TUNAERROR : ID PHOTO:".$photo->ID;
		$errorFree = false;
	}
        if(!preg_match("/^[ -_.,a-zA-Z0-9]+$/i", $photo->Name) && strlen($photo->Name) >= 1){
           echo "TUNAERROR : photoName PHOTO:".$photo->ID." NAME: ".$photo->Name;
		$errorFree = false;
	}
        if(!preg_match("/^[ -_.,a-zA-Z0-9]+$/i", $photo->UploadDate) && strlen($photo->UploadDate) >= 1){
           echo "TUNAERROR : syncDate PHOTO:".$photo->ID;
		$errorFree = false;
	}
        if(!preg_match("/^[ -_.,a-zA-Z0-9]+$/i", $photo->UploadTime) && strlen($photo->UploadTime) >= 1){
           echo "TUNAERROR : syncTime PHOTO:".$photo->ID;
		$errorFree = false;
	}
	return $errorFree;
}

/*
* Validate Group input for upload
*/
function validateGroup($group){
	$errorFree = true;
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $group->groupID) && strlen($group->groupID) >= 1){
           echo "TUNAERROR : groupID Group INVALID:".$group->groupID;
		$errorFree = false;
	}
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $group->groupAuthor) && strlen($group->groupAuthor) >= 1){
           echo "TUNAERROR : groupAuthor Group INVALID:".$group->groupAuthor;
		$errorFree = false;
	}
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $group->groupName) && strlen($group->groupName) >= 1){
           echo "TUNAERROR : groupName Group INVALID:".$group->groupName;
		$errorFree = false;
	}
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $group->groupSize) && strlen($group->groupName) >= 1){
           echo "TUNAERROR : groupSize Group INVALID:".$group->groupSize;
		$errorFree = false;
	}
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $group->groupSyncDate) && strlen($group->groupSyncDate) >= 1){
           echo "TUNAERROR : groupSyncDate Group INVALID:".$group->groupSyncDate;
		$errorFree = false;
	}
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $group->groupSyncTime) && strlen($group->groupSyncTime) >= 1){
           echo "TUNAERROR : groupSyncTime Group INVALID:".$group->groupSyncTime;
		$errorFree = false;
	}
	foreach($group->people as $key => $value){
		$error = validateContact($value);
		if($error != true){
			$errorFree = $error;
		}
	}
	return $errorFree;
}

/*
* Validate Contact input for upload
*/
function validateContact($contact){
	$errorFree = true;
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $contact->ID) && strlen($contact->ID) >= 1){
           echo "TUNAERROR : ID Contact INVALID:".$contact->ID;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $contact->GroupID) && strlen($contact->GroupID) >= 1){
           echo "TUNAERROR : groupID Contact INVALID:".$contact->GroupID;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $contact->GoogleID) && strlen($contact->GoogleID) >= 1){
           echo "TUNAERROR : googleID Contact INVALID:".$contact->GoogleID;
	$errorFree = false;
	}
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $contact->Name) && strlen($contact->Name) >= 1){
           echo "TUNAERROR : Name Contact INVALID:".$contact->Name;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $contact->Email) && strlen($contact->Email) >= 1){
	echo "TUNAERROR : Email Contact INVALID:".$contact->Email;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $contact->Phone) && strlen($contact->Phone) >= 1){
	echo "TUNAERROR : Phone Contact INVALID:".$contact->Phone;
	$errorFree = false;
	} 
	return $errorFree;
}

/*
* Validate overall sync input 
*/
function validateSync($sync){
	$errorFree = true;
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncUserID) && strlen($sync->syncUserID) >= 1){
           echo "TUNAERROR : syncUserID INVALID:".$sync->syncUserID;
	$errorFree = false;
	}
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncToken)){
           echo "TUNAERROR : syncToken INVALID:".$sync->syncToken;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncGrpDate)){
           echo "TUNAERROR : syncGrpDate INVALID:".$sync->syncGrpDate;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncGrpTime)){
           echo "TUNAERROR : syncGrpTime INVALID:".$sync->syncGrpTime;
	$errorFree = false;
	}
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncImgDate)){
           echo "TUNAERROR : syncImgDate INVALID:".$sync->syncImgDate;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncImgTime)){
          echo "TUNAERROR : syncImgTime INVALID:".$sync->syncImgTime;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncProfDate)){
           echo "TUNAERROR : syncProfDate INVALID:".$sync->syncProfDate;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncProfTime)){
           echo "TUNAERROR : syncProfTime INVALID:".$sync->syncProfTime;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncImgAmount)){
           echo "TUNAERROR : syncImgAmount INVALID:".$sync->syncImgAmount;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncGrpAmount)){
           echo "TUNAERROR : syncGrpAmount INVALID:".$sync->syncGrpAmount;
	$errorFree = false;
	} 
	return $errorFree;
}
/*
* Validate sync invite input
*/
function validateSyncDetails($sync){
	$errorFree = true;
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncInviteToken)){
          echo "TUNAERROR : syncInviteToken INVALID:".$sync->syncInviteToken;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncInviteDate)){
           echo "TUNAERROR : syncInviteDate INVALID:".$sync->syncInviteDate;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncInviteTime)){
           echo "TUNAERROR : syncInviteTime INVALID:".$sync->syncInviteTime;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncInviteRecAmount)){
           echo "TUNAERROR : syncInviteRecAmount INVALID:".$sync->syncInviteRecAmount;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncInviteSntAmount)){
           echo "TUNAERROR : syncInviteSntAmount INVALID:".$sync->syncInviteSntAmount;
	$errorFree = false;
	} 
	return $errorFree;
}
/*
* Validate each invite input
*/

function validateLifeInvite($invite){
	$errorFree = true;
	foreach($life->invites as $invite){
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $invite->InviteID)){
           		echo "TUNAERROR : InviteID INVALID:".$invite->InviteID;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $invite->InviteUserGID)){
           		echo "TUNAERROR : InviteUserGID INVALID:".$invite->InviteUserGID;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $invite->RecipientName)){
           		echo "TUNAERROR : RecipientName INVALID:".$this->RecipientName;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $invite->RecipientUserGID)){
           		echo "TUNAERROR : RecipientUserGID INVALID:".$this->RecipientUserGID;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $invite->RecipientEmail)){
           		echo "TUNAERROR : RecipientEmail INVALID:".$invite->RecipientEmail;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $invite->RecipientPhone)){
           		echo "TUNAERROR : RecipientPhone INVALID:".$invite->RecipientPhone;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $invite->InviteDate)){
           		echo "TUNAERROR : InviteDate INVALID:".$invite->InviteDate;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $invite->InviteTime)){
           		echo "TUNAERROR : InviteTime INVALID:".$invite->InviteTime;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $invite->InviteStatus)){
           		echo "TUNAERROR : InviteStatus INVALID:".$invite->InviteStatus;
			$errorFree = false;
		}
	} 
	return $errorFree;
}
/*
* Validate each Message input
*/

function validateLifeMessages($life){
	$errorFree = true;
	foreach($life->messages as $msg){
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $msg->MID)){
           		echo "TUNAERROR : MessageID INVALID:".$msg->MID;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $msg->UserID)){
           		echo "TUNAERROR : Message UserID INVALID:".$msg->UserID;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $msg->UserName)){
           		echo "TUNAERROR : Message UserName INVALID:".$msg->UserName;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $msg->Type)){
           		echo "TUNAERROR : Message Type INVALID:".$msg->Type;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $msg->Content)){
           		echo "TUNAERROR : Message Content INVALID:".$msg->Content;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $msg->RecipientID)){
           		echo "TUNAERROR : Message RecipientID INVALID:".$msg->RecipientID;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $msg->RecipientGrpID)){
           		echo "TUNAERROR : Message RecipientGrpID INVALID:".$msg->RecipientGrpID;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $msg->mDate)){
           		echo "TUNAERROR : Message Date INVALID:".$msg->mDate;
			$errorFree = false;
		}
		if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $msg->mTime)){
           		echo "TUNAERROR : Message Time INVALID:".$msg->mTime;
			$errorFree = false;
		}
	} 
	return $errorFree;
}

/*
* Validate sync message input
*/
function validateSyncMsg($sync){
	$errorFree = true;
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncMsgToken)){
          echo "TUNAERROR : syncMsgToken INVALID:".$sync->syncMsgToken;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncMsgDate)){
           echo "TUNAERROR : syncMsgDate INVALID:".$sync->syncMsgDate;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncMsgTime)){
           echo "TUNAERROR : syncMsgTime INVALID:".$sync->syncMsgTime;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncMsgRecAmount)){
           echo "TUNAERROR : syncMsgRecAmount INVALID:".$sync->syncMsgRecAmount;
	$errorFree = false;
	} 
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $sync->syncMsgSntAmount)){
           echo "TUNAERROR : syncMsgSntAmount INVALID:".$sync->syncMsgSntAmount;
	$errorFree = false;
	} 
	return $errorFree;
}

/*
* Validate sync message input
*/
function validateImgID($imgID){
	$errorFree = true;
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $imgID)){
          echo "TUNAERROR : ImageID INVALID:".$imgID;
	$errorFree = false;
	} 
	return $errorFree;
}

/*
* Validate sync message input
*/
function validateAlbID($albID){
	$errorFree = true;
	if(!preg_match("/^[ -_.,()a-zA-Z0-9]+$/i", $albID)){
          echo "TUNAERROR : AlbumID INVALID:".$albID;
	$errorFree = false;
	} 
	return $errorFree;
}

/*
* Validate Registered User
*/
function validateUser($user){
	$errorFree = true;

	return $errorFree;
}

/*
* Check database to see if the record already exists for a given object and userID
*/

/*
* Check Group Exists in Group table
*/
function checkInviteExists($userID, $inviteID){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "SELECT * from Invites where InviteUserGID='$userID' AND InviteID='$inviteID'";
	$userRes = mysql_query($q);
	
	if(is_resource($userRes) && mysql_num_rows($userRes) > 0 ){
		return true;
	}
	else{
		return false;
	}
 	$sqlCon->sqlClose();
}

function checkInvitedUserExists($recID, $recEmail, $recPhone){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();

	$q = "select * from Users where UserID='$recID' OR userEmail='$recEmail' OR userPhone='$recPhone' ";
		$userRes = mysql_query($q);
		if(is_resource($userRes) && mysql_num_rows($userRes) > 0 ){
		return true;
	}
	else{
		return false;
	}
	$sqlCon->sqlClose();	
}

/*
* Check Group Exists in Group table
*/
function checkGroupExists($group){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "SELECT * from Groups where UserID='$group->groupAuthor' AND UserGroupID='$group->groupID'";
	$userRes = mysql_query($q);
	
	if(is_resource($userRes) && mysql_num_rows($userRes) > 0 ){
		return true;
	}
	else{
		return false;
	}
 	$sqlCon->sqlClose();
}

/*
* Check if a Contact in a given Group Exists in Contact table
*/
function checkContactExists($contact, $userID){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "SELECT * from Contacts where UserID='$userID' AND GroupID='$contact->GroupID' AND ContactID='$contact->ID'";
	$userRes = mysql_query($q);
	
	if(is_resource($userRes) && mysql_num_rows($userRes) > 0 ){
		return true;
	}
	else{
		return false;
	}
	 $sqlCon->sqlClose();
}

function getTokenHeader(){
	$headers = apache_request_headers();
	$counter = 0;
	$finalToken = "";
	foreach ($headers as $header) {
		if($counter == 2){
			$finalToken = $header;
		}
		$counter++;
	}	
	/* if(validateToken($finalToken)){
		return $finalToken;
	}else {
		return "";
	} */
	return $finalToken;
}

function getImageTokenHeader(){
	$headers = apache_request_headers();
	$counter = 0;
	foreach ($headers as $header) {

		if($counter == 0){
			$finalToken = $header;
		}
		$counter++;
	}
	if(validateToken($finalToken)){
		return $finalToken;
	}else {
		return "";
	}
}

function getUploadHeader(){
	$headers = apache_request_headers();
	$counter = 0;
	foreach ($headers as $header) {
		if($counter == 1){
			$finalToken = $header;
		}
		$counter++;
	}
	if(validateToken($finalToken)){
		return $finalToken;
	}else {
		return "";
	}
}

function checkTokenHeader($userToken){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "SELECT * from Users where ourToken='$userToken'";
	$userRes = mysql_query($q);
	
	if(is_resource($userRes) && mysql_num_rows($userRes) > 0 ){
		$sqlCon->sqlClose();
		return true;
	}
	else{
		$sqlCon->sqlClose();
		return false;
	}
}

function getUserID($userToken){
	 $sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$finQry = "";
	$q = "SELECT * from Users where ourToken='$userToken'";
	$userRes = mysql_query($q);

	while($qryRow = mysql_fetch_array($userRes)){
		$qry = $qryRow[2];  // user id
		if($qry == $userToken){
			$finQry = $qryRow[3];	
		}	
	}
	$sqlCon->sqlClose();   
	
	return $finQry;
}

?>
