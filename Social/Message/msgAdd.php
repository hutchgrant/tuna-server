<?php
include 'message_main.php';
include '../../Element/LifeMessage.php';
include '../../Database/validate.php';
include '../../Sync/sync_interface.php';

$userToken = getTokenHeader();
if(checkTokenHeader($userToken) == true){
	$userID = getUserID($userToken);
	 $life = new LifeMessage();
	$life = getLifeMsgDetails();

	if(validateLifeMessages($life) == true){
	$actDate = date('Y-m-d');
	$actTime = date('H:i:s', time());

		foreach($life->messages as $msg){
			writeMessage($msg, $actDate, $actTime);
		}
		
		updateMsgSync($msg->UserID, "add", "sent", $actDate, $actTime);
		updateMsgSync($msg->RecipientID, "add", "received", $actDate, $actTime);

		$life->displayLife();
	} 

}
?>
