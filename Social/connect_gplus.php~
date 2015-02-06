<?php
include '../Database/main_interface.php';
include 'google_access.php';
include '../Element/User.php';
include '../Sync/sync_interface.php';

$GaccessToken = getToken();
$USaccessToken = randString(20);
$outputProfile = getProfile($GaccessToken, $USaccessToken);
// verify profile is registered
$verify = VerifyUser($outputProfile->userGID);

if($verify == true){
	$phone = getPhoneNumber();
	$outputProfile = writeUserLogin($outputProfile, $GaccessToken, $phone);
}else{  // write new user registration
	$phone = getPhoneNumber();
	$outputProfile = writeNewUser($GaccessToken , $outputProfile, $phone);
}
$outputProfile->send(); 

?>
