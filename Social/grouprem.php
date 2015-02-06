<?php
include 'main_social.php';
include '../Element/Group.php';
include '../Sync/sync_interface.php';
include '../Database/validate.php';

$userToken = getTokenHeader();

if(checkTokenHeader($userToken) == true){
	$userID = getUserID($userToken);

	$groupID = removeGroupByID($userID);
	removeContactsByID($userID, $groupID);

	$actDate = date('Y-m-d');
	$actTime = date('H:i:s', time());

	updateGroupSync($userID, $actDate, $actTime, "false");
	echo $actDate . " " . $actTime;
}

?>
