<?php
include_once 'Message.php';

class LifeMessage {

var $messages;
var $count;

function _construct(){
	$messages = array();
	$count = 0;
}

function fillMessage($mID, $UserID, $Name, $type, $cntent, $recID, $recGrpID, $actDate, $actTime){
	$msg = new Message();
	$msg->fill($mID, $UserID, $Name, $type, $cntent, $recID, $recGrpID, $actDate, $actTime);
	$this->messages[$this->count] = $msg;
	$this->count = $this->count +1; 
}

function addMessage($msg){
	$this->messages[$this->count] = $msg;
	$this->count = $this->count +1;
}

function displayLife(){
		$ct = 1;
	//	echo "{ \"life\" : ";
		echo "{ \"messages\" : [ ";
		foreach($this->messages as $msg){
			if($ct != 1){
				echo ",\n";			
			}
			$totalArr[$ct]= send($msg);
 			echo json_encode($totalArr[$ct]); 
			$ct++;
		}
		
		echo " \n] \n } ";
	}
}

function send($msg){
		$contactArray = array();
			$contactArray['MID'] = $msg->MID;
			$contactArray['AuthorID'] = $msg->UserID;
			$contactArray['AuthorName'] = $msg->UserName;
			$contactArray['ReceiverID'] = $msg->RecipientID;
			$contactArray['ReceiverGrpID'] = $msg->RecipientUserGrpID;
			$contactArray['Type'] = $msg->Type;
			$contactArray['Content'] = $msg->Content;
			$contactArray['mDate'] = $msg->mDate;
			$contactArray['mTime'] = $msg->mTime;
		return $contactArray;

}

?>
