<?php

include '../Database/main_interface.php';
include 'google_access.php';
include '../Element/User.php';
include '../Element/Group.php';
include '../Sync/sync_interface.php';
include 'invite_main.php';
include '../Element/SyncInvite.php';
include '../Database/validate.php';
include '../Element/LifeInvite.php';

$GaccessToken = getToken();
$USaccessToken = randString(20);
$outputProfile = getProfile($GaccessToken, $USaccessToken);
// verify profile is registered
$verify = VerifyUser($outputProfile->userGID);

if($verify == true){
	$outputProfile = writeUserLogin($outputProfile, $GaccessToken);
	$outputProfile->send();   
}else{  // write new user registration
	//$phone = getPhoneNumber();
	//$email = getEmail();
	$userDetails = array();
	$userDetails = getUserDetails();	
	
	$outputProfile->setUserContact($userDetails['phone'], $userDetails['email']);
	$outputProfile->setLimits("10","10","10","10");

	$FriendGrpID = randString(20);
	$outputProfile = writeNewUser($GaccessToken , $outputProfile);
	
	$grp = new Group();
	$actDate = date('Y-m-d');
	$actTime = date('H:i:s', time());
	$grp->fill($FriendGrpID, "Friends", 0, $actDate, $actTime, $outputProfile->userGID);
	writeNewGroup($grp, $outputProfile->userGID);

	$life = new LifeInvite();
	$life = readReceivedInvites($outputProfile->userGID, $outputProfile->userEmail, $outputProfile->userPhone);
	if($life->count != 0){	
		updateInvReceived($outputProfile->userGID, $life->count, $actDate, $actTime);
	} 
	$outputProfile->send();   
} 
?>
