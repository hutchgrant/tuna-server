<?php
include './main_social.php';
include '../Element/SyncInvObj.php';
include '../Database/validate.php';
include '../Sync/sync_interface.php';

/// check tuna token
$userToken = getTokenHeader();
///get received sync token
$syncToken = getSyncInviteToken();
if(checkTokenHeader($userToken) == true){
	$userID = getUserID($userToken);

	// get server's version of sync token
	$servSyncToken = getServSyncInviteToken($userID);

	if($syncToken != $servSyncToken){
	/// get the sync obj for that user and compare
	///-----------------------------------------------
	$sync = new SyncInvObj();
	$sync = getSyncInvObj($userID);
	$sync->display(); 

	}else{
		echo "OK";
	}
}else{
	echo "sync error, incorrect user token";
} 
?>
