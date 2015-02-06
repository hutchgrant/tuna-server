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

	function _construct(){
		fill("", "", "", "", "", "", "", "", 0, 0, 0, 0);
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

	function display(){
		$syncDisplay = array('syncUserID' => $this->syncUserID,
				'syncToken' => $this->syncToken,				
				'syncImgDate' => $this->syncImgDate,
				'syncImgTime' => $this->syncImgTime,
				'syncGrpDate' => $this->syncGrpDate,
				'syncGrpTime' => $this->syncGrpTime,
				'syncProfDate' => $this->syncProfDate,
				'syncProfTime' => $this->syncProfTime,
				'syncAlbAmount' => $this->sycnAlbAmount,
				'syncImgAmount' => $this->syncImgAmount,
				'syncGrpAmount' => $this->syncGrpAmount,
				'syncConAmount' => $this->syncConAmount);
		
			echo json_encode($syncDisplay);
	}

	function __destruct(){
	
	}

}

?>
