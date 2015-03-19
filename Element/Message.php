<?php

class Message{

	var $MID = "";
	var $UserID = "";
	var $UserName = "";
	var $RecipientID = "";
	var $RecipientGrpID = "";
	var $Content = "";
	var $Type = "";
	var $mDate = "";
	var $mTime = "";
	

	function _construct(){
		$this->MID = "";
		$this->UserID = "";
		$this->UserName = "";		
		$this->RecipientID = "";
		$this->RecipientGrpID = "";
		$this->mDate = "";
		$this->mTime = "";
		$this->Type = "";
		$this->Content = "";
	
	}

	function fill($mID, $mUserID, $Name, $type, $cntent, $recID, $recGrpID, $actDate, $actTime){
		$this->MID = $mID;
		$this->UserID = $mUserID;
		$this->UserName = $Name;
		$this->RecipientID = $recID;
		$this->RecipientGrpID = $recGrpID;
		$this->Content = $cntent;
		$this->Type = $type;
		$this->mDate = $actDate;
		$this->mTime = $actTime;
	}

	function display(){

	

	}
}


?>
