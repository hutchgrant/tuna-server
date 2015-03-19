<?php

class SyncInvObj{

var $syncInviteToken = "";
var $syncInviteDate = "";
var $syncInviteTime = "";
var $syncInviteRecAmount = "";
var $syncInviteSntAmount = "";

	function _construct(){
		$this->syncInviteToken = "";
		$this->syncInviteDate = "";
		$this->syncInviteTime = "";
		$this->syncInviteRecAmount = "";
		$this->syncInviteSntAmount = "";
	}
	function fill($inviteToken, $inviteDate, $inviteTime, $inviteRecAmount, $inviteSntAmount){
		$this->syncInviteToken = $inviteToken;
		$this->syncInviteDate = $inviteDate;
		$this->syncInviteTime = $inviteTime;
		$this->syncInviteRecAmount = $inviteRecAmount;
		$this->syncInviteSntAmount = $inviteSntAmount;
	}
	
	function display(){

		$arr = array();

		$arr['syncInviteToken'] = $this->syncInviteToken;
		$arr['syncInviteDate'] = $this->syncInviteDate;
		$arr['syncInviteTime'] = $this->syncInviteTime;
		$arr['syncInvRecAmount'] = $this->syncInviteRecAmount;		
		$arr['syncInvSntAmount'] = $this->syncInviteSntAmount;

		 echo json_encode($arr); 

	} 
}
?>
