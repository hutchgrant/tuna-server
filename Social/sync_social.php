<?php
include './main_social.php';
include '../Element/SyncObj.php';
include '../Database/validate.php';
include '../Sync/sync_interface.php';

/// check tuna token
$userToken = getTokenHeader();
///get received sync token
$syncToken = getSyncToken();
if(checkTokenHeader($userToken) == true){
	$userID = getUserID($userToken);

	// get server's version of sync token
	$servSyncToken = getServSyncToken($userID);

	if($syncToken != $servSyncToken){
	/// get the sync obj for that user and compare
	///-----------------------------------------------
	$sync = new SyncObj();
	$sync = getSyncObj($userID);
	$sync->display(); 

	}else{
		echo "OK";
	}
}else{
	echo "sync error, incorrect user token";
} 
?>
