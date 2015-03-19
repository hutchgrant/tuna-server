<?php
include_once '../Element/Invite.php';

class LifeInvite {

var $invites;
var $count;

function _construct(){
	$invites = array();
	$count = 0;
}

function fillInvite($inviteID, $inviteUserID, $invName, $recName, $recGID, $recEmail, $recPhone, $inviteDate, $inviteTime, $inviteStatus){
	$inv = new Invite();
	$inv->fill($inviteID, $inviteUserID, $invName, $recName, $recGID, $recEmail, $recPhone, $inviteDate, $inviteTime, $inviteStatus);
	$this->invites[$this->count] = $inv;
	$this->count = $this->count +1;
}

function addInvite($invite){
	$this->invites[$this->count] = $invite;
	$this->count = $this->count +1;
}

function displayLife(){
		$ct = 1;
	//	echo "{ \"life\" : ";
		echo "{ \"invites\" : [ ";
		foreach($this->invites as $invite){
			if($ct != 1){
				echo ",\n";			
			}
			$totalArr[$ct]= send($invite);
 			echo json_encode($totalArr[$ct]); 
			$ct++;
		}
		
		echo " \n] \n } ";
	}
}

function send($invite){
		$contactArray = array();
			$contactArray['InviteID'] = $invite->InviteID;
			$contactArray['InviteUserGID'] = $invite->InviteUserGID;
			$contactArray['InviteUserName'] = $invite->InviteName;
			$contactArray['RecipientName'] = $invite->RecipientName;
			$contactArray['RecipientUserGID'] = $invite->RecipientUserGID;
			$contactArray['RecipientEmail'] = $invite->RecipientEmail;
			$contactArray['RecipientPhone'] = $invite->RecipientPhone;
			$contactArray['InviteDate'] = $invite->InviteDate;
			$contactArray['InviteTime'] = $invite->InviteTime;
			$contactArray['InviteStatus'] = $invite->InviteStatus;
		return $contactArray;

}

?>
