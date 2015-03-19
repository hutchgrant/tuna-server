<?php

class SyncObj{

	var $syncUserID;
	var $syncToken;
	var $syncImgDate;
	var $syncImgTime;
	var $syncGrpDate;
	var $syncGrpTime;
	var $syncProfDate;
	var $syncProfTime;
	var $syncAlbAmount;
	var $syncImgAmount;
	var $syncGrpAmount;
	var $syncConAmount;
	var $syncInviteToken;
	var $syncInviteDate;
	var $syncInviteTime;
	var $syncInvRecAmount;
	var $syncInvSntAmount;	
	var $syncMsgToken;
	var $syncMsgDate;
	var $syncMsgTime;
	var $syncMsgRecAmount;
	var $syncMsgSntAmount;	
	function _construct(){
		fill("", "", "", "", "", "", "", "", 0, 0, 0, 0, "", "", "", 0, 0);
		fillInvite("", "", "", 0, 0);
		fillMessage("", "", "", 0, 0);
	}

	function fill($userID, $token, $imgDate, $imgTime, $grpDate, $grpTime, $profDate, $profTime, $albAmount, $imgAmount, $grpAmount, $conAmount){
		$this->syncUserID = $userID;
		$this->syncToken = $token;
		$this->syncImgDate = $imgDate;
		$this->syncImgTime = $imgTime;
		$this->syncGrpDate = $grpDate;
		$this->syncGrpTime = $grpTime;
		$this->syncProfDate = $profDate;
		$this->syncProfTime = $profTime;
		$this->syncAlbAmount = $albAmount;
		$this->syncImgAmount = $imgAmount;
		$this->syncGrpAmount = $grpAmount;
		$this->syncConAmount = $conAmount;
	}

	function fillInvite($inviteToken, $inviteDate, $inviteTime, $inviteRecAmount, $inviteSntAmount){
		$this->syncInviteToken = $inviteToken;
		$this->syncInviteDate = $inviteDate;
		$this->syncInviteTime = $inviteTime;
		$this->syncInvRecAmount = $inviteRecAmount;
		$this->syncInvSntAmount = $inviteSntAmount;
	}

	function fillMessage($msgToken, $msgDate, $msgTime, $msgRecAmt, $msgSntAmount){
		$this->syncMsgToken = $msgToken;
		$this->syncMsgDate =  $msgDate;
		$this->syncMsgTime = $msgTime;
		$this->syncMsgRecAmount = $msgRecAmt;
		$this->syncMsgSntAmount = $msgSntAmount;
	}

	function display(){
		$syncDisplay = array('syncUserID' => $this->syncUserID,
				'syncToken' => $this->syncToken,				
				'syncImgDate' => $this->syncImgDate,
				'syncImgTime' => $this->syncImgTime,
				'syncGrpDate' => $this->syncGrpDate,
				'syncGrpTime' => $this->syncGrpTime,
				'syncProfDate' => $this->syncProfDate,
				'syncProfTime' => $this->syncProfTime,
				'syncAlbAmount' => $this->syncAlbAmount,
				'syncImgAmount' => $this->syncImgAmount,
				'syncGrpAmount' => $this->syncGrpAmount,
				'syncConAmount' => $this->syncConAmount,
				'syncInviteToken' => $this->syncInviteToken,
				'syncInviteDate' => $this->syncInviteDate,
				'syncInviteTime' => $this->syncInviteTime,
				'syncInvSntAmount' => $this->syncInvSntAmount,
				'syncInvRecAmount' => $this->syncInvRecAmount,
				'syncMsgToken' => $this->syncMsgToken,
				'syncMsgDate' => $this->syncMsgDate,
				'syncMsgTime' => $this->syncMsgTime,
				'syncMsgSntAmount' => $this->syncMsgSntAmount,
				'syncMsgRecAmount' => $this->syncMsgRecAmount);
		
			echo json_encode($syncDisplay);
	}

}

?>
