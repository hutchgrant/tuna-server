<?php
include '../Element/LifeAlbum.php';
include_once '../Element/SyncObj.php';
include '../Database/validate.php';
include '../Sync/sync_interface.php';
include './imageMain.php';

$userToken = getTokenHeader();
if(checkTokenHeader($userToken) == true){
	$userID = getUserID($userToken);
	$syncObj = new SyncObj();
	$syncObj = getSyncDetails();	
	if(validateSync($syncObj) == true){	
		$life = new LifeAlbum();
		$life = getLifeAlbum($userID, $syncObj->syncImgDate, $syncObj->syncImgTime);
		$life->displayLife();
	} 
 }  
?>
