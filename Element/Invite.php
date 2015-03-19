<?php

class Invite{

	var $InviteID = "";
	var $InviteUserGID = "";
	var $InviteName = "";
	var $RecipientName = "";
	var $RecipientUserGID = "";
	var $RecipientEmail = "";
	var $RecipientPhone = "";
	var $InviteDate = "";
	var $InviteTime = "";
	var $InviteStatus = "";
	

	function _construct(){
		$this->InviteID = "";
		$this->InviteUserGID = "";
		$this->InviteName = "";		
		$this->RecipientName = "";
		$this->RecipientUserGID = "";
		$this->RecipientEmail = "";
		$this->RecipientPhone = "";
		$this->InviteDate = "";
		$this->InviteTime = "";
		$this->InviteStatus = "";
	
	}

	function fill($inviteID, $inviteUserID, $invName, $recName, $recGID, $recEmail, $recPhone, $inviteDate, $inviteTime, $inviteStatus){
		$this->InviteID = $inviteID;
		$this->InviteUserGID = $inviteUserID;
		$this->InviteName = $invName;
		$this->RecipientName = $recName;
		$this->RecipientUserGID = $recGID;
		$this->RecipientEmail = $recEmail;
		$this->RecipientPhone = $recPhone;
		$this->InviteDate = $inviteDate;
		$this->InviteTime = $inviteTime;
		$this->InviteStatus = $inviteStatus;
	}

	function display(){

	

	}
}


?>
