<?php
include 'main_social.php';
include '../Element/LifeGroup.php';
include '../Sync/sync_interface.php';
include '../Database/validate.php';
include_once '../Element/SyncObj.php';

$userToken = getTokenHeader();

$life = new LifeGroup();
if(checkTokenHeader($userToken) == true){
	$userID = getUserID($userToken);
	$syncOb = new SyncObj();
	$syncObj = getSyncDetails();	
	if(validateSync($syncObj) == true){
		$life = getLifeGroup($userID, $syncObj->syncGrpDate, $syncObj->syncGrpTime);
		$life->displayLife();
	} 
} else{
	echo "invalid token ".$userToken;
}  

?>
