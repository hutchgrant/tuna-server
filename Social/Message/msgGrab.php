<?php
include 'message_main.php';
include '../../Element/LifeMessage.php';
include '../../Element/SyncMsg.php';
include '../../Database/validate.php';
include '../../Sync/sync_interface.php';
include '../../Element/SyncMsgObj.php';

$userToken = getTokenHeader();
$sync = new SyncMsgObj();

if(checkTokenHeader($userToken) == true){

	$userID = getUserID($userToken);
	$sync = getSyncMsgDetails();

	if(validateSyncMsg($sync) == true){  
		$life = new LifeMessage();
		if($sync->syncMsgCache != 0){
			$life = getMoreMessages($userID, $sync->syncMsgCache);
		} else{
			$life = getLifeMessages($userID, $sync->syncMsgDate, $sync->syncMsgTime); 
		}		
		$life->displayLife();
	}
} 
?>
