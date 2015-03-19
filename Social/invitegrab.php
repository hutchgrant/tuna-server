<?php
include '../Element/LifeInvite.php';
include_once '../Element/SyncInvObj.php';
include '../Sync/sync_interface.php';
include '../Database/validate.php';
include 'invite_main.php';



$userToken = getTokenHeader();
$sync = new SyncInvObj();

if(checkTokenHeader($userToken) == true){
$userID = getUserID($userToken);
$sync = getInvDetails();

	if(validateSyncDetails($sync) == true){   /// write
		$life = new LifeInvite();
		$life = readInvites($userID, $sync->syncInviteDate, $sync->syncInviteTime);   // write
		$life->displayLife();
	}  
} 

?>
