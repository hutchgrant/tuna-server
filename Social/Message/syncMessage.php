<?php
include 'message_main.php';
include '../../Database/validate.php';
include '../../Sync/sync_interface.php';
include '../../Element/SyncMsgObj.php';

$user = getTokenHeader();
if(checkTokenHeader($user) == true){
	$userID = getUserID($userToken);

	// get server's version of sync token
	$servSyncToken = getServSyncMsgToken($userID);

	if($syncToken != $servSyncToken){
	/// get the sync obj for that user and compare
	///-----------------------------------------------
	$sync = new SyncMsgObj();
	$sync = getSyncMsgObj($userID);
	$sync->display(); 

	}else{
		echo "OK";
	}  
}else{
	echo "invalid user token";
}
?>
