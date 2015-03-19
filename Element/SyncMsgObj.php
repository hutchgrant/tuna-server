<?php

class SyncMsgObj{

var $syncMsgToken = "";
var $syncMsgDate = "";
var $syncMsgTime = "";
var $syncMsgRecAmount = "";
var $syncMsgSntAmount = "";
var $syncMsgCache = "";

	function _construct(){
		$this->syncMsgToken = "";
		$this->syncMsgDate = "";
		$this->syncMsgTime = "";
		$this->syncMsgRecAmount = "";
		$this->syncMsgSntAmount = "";
		$this->syncMsgCache = "";
	}
	function fill($msgToken, $msgDate, $msgTime, $msgRecAmount, $msgSntAmount, $msgCache){
		$this->syncMsgToken = $msgToken;
		$this->syncMsgDate = $msgDate;
		$this->syncMsgTime = $msgTime;
		$this->syncMsgRecAmount = $msgRecAmount;
		$this->syncMsgSntAmount = $msgSntAmount;
		$this->syncMsgCache = $msgCache;
	}
	
	function display(){

		$arr = array();

		$arr['syncMsgToken'] = $this->syncMsgToken;
		$arr['syncMsgDate'] = $this->syncMsgDate;
		$arr['syncMsgTime'] = $this->syncMsgTime;
		$arr['syncMsgRecAmount'] = $this->syncMsgRecAmount;		
		$arr['syncMsgSntAmount'] = $this->syncMsgSntAmount;

		 echo json_encode($arr); 

	} 
}
?>
