<?php
include 'config.php';
include 'dbConnect.php';

/* Read User from database
 * @param: usrID
*/
function selectUser($userID){
	$sqlCon->sqlConn();
	$q = "select * from Users where userID = $userID";
	$fin = array();
	$userRes = mysql_query($q) or die("couldn't find user in database");

	while($qryRow = mysql_fetch_array($userRes)){
		$fin[0] = $qryRow[0];  // user id
		$fin[1] = $qryRow[1];  // user name
		$fin[2] = $qryRow[2];  // user displayname
		$fin[3] = $qryRow[3];  // user profileUrl
		$fin[4] = $qryRow[4];  // user profileImageUrl
		$fin[5] = $qryRow[5];  // user location
		$fin[6] = $qryRow[6];  // Total number of posts
		$fin[7] = $qryRow[7];  // Total number of circles
		$fin[8] = $qryRow[8];  // Total number of contacts
		$fin[9] = $qryRow[9];  // app installed yes/no
	}
	echo json_encode($fin);
	$sqlCon->sqlClose();   
	
	return $fin;
}

/* Verify User from database
 * @param: usrID
*/
function VerifyUser($userID){
	$sqlCon = new dbConnect();
	$registered = false;
	$sqlCon->sqlConn();
	$q = "SELECT * from Users where userID='$userID'";
	$userRes = mysql_query($q);

	if(is_resource($userRes) && mysql_num_rows($userRes) > 0 ){
		$sqlCon->sqlClose();
	    return true;
	}
	else{
		$sqlCon->sqlClose();
	    return false;
	}
}

/* Write User to database when registered
 * @param: USaccessToken // our access token
 * @param: usrToken   // google's access token
 * @para: usrID
 * @param: usrDisplayName
 * @param: usrProfile, usrProfileURL
 * @param: usrLocation
 * assumes total posts + circles + contacts = 0 default
 * app installed = yes
 */
function writeNewUser($token, $user, $phone){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$actDate = date('Y-m-d');
	$actTime = date('H:i:s', time());
	$IPaddress = $_SERVER['REMOTE_ADDR'];
	$q = "insert into Users values ('0', '$token', '$user->userToken', '$user->userGID', '$user->userGName', '$user->userEmail', '$user->userPhone', '$user->userProfile', '$user->userImgUrl', '$user->userLocation', '0', '0', '0', 'yes', '$actDate', '$actTime', '$IPaddress', '$actDate', '$actTime', '$IPaddress', '$user->MaxAlbum', '$user->MaxImage', '$user->MaxGroup', '$user->Contact')"; 
    	$sqlCon->finQry($q);
    	$sqlCon->sqlClose();
	$user->fillReg($actDate, $actTime);
	$user->fillLogin($actDate, $actTime);
    	writeLog("connect.php", $user->userGID, "user registration");
    	writeProfileSync($user->userGID, $actDate, $actTime);
	$user->userPhone = $phone;
	return $user;
}

/*
* Get User registration date and time
*/
function getUserRegDateTime($user){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "SELECT * from Users where userID='$user->userGID'";
	$fin = array();
	$userRes = mysql_query($q) or die("couldn't find user in database");
	$regDate = "";
	$regTime = "";
	while($qryRow = mysql_fetch_array($userRes)){
		$regDate = $qryRow[12];  // registration date
		$regTime = $qryRow[13];
		
	}	
	$user->fillReg($regDate, $regTime);
	$sqlCon->sqlClose();   
	
	return $user;
}

/*
 * Write User Database when user connects
 */
function writeUserLogin($user, $GaccessToken, $phone){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$actDate = date('Y-m-d');
	$actTime = date('H:i:s', time());
	$IPaddress = $_SERVER['REMOTE_ADDR'];
	$q = "UPDATE Users SET userToken='$GaccessToken', userPhone='$phone', location='$user->userlocation', logintime='$actTime', logindate='$actDate', loginIP='$IPaddress' where userID ='$user->userGID'";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
	writeLog("connect.php", $userID, "user login");
	$user = getPreviousUserDetails($user);
	$user->fillLogin($actDate, $actTime);
	$user->userPhone = $phone;
	return $user;
}


/* Write Log to database when activity occurs
 * @param: parent  - page written from
 * @param: userID  - User we're logging about
 * @param: activity - Activity we're logging e.g. "new user registration" "get circled" "post circled"
 * @param: actTime - actiontime
*/
function writeLog($parent, $userID, $activity){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$actDate = date('Y-m-d');
	$actTime = date('H:i:s', time());
   	$IPaddress = $_SERVER['REMOTE_ADDR'];
    
    $q = "insert into Logs values ('0', '$activity', '$parent', '$userID', '$actTime', '$actDate', '$IPaddress')";
    $sqlCon->finQry($q);
    $sqlCon->sqlClose();
}
/* Read Log from database
 * @param: usrID
*/
function selectLogID(){
	$sqlCon->sqlConn();
	$q = "select * from logs";
	$fin = array();
	$userRes = mysql_query($q) or die("couldn't find user in database");

	while($qryRow = mysql_fetch_array($userRes)){
		$fin[0] = $qryRow[0];  // log id
		$fin[1] = $qryRow[1];  // log user
		$fin[2] = $qryRow[2];  // log activity
		$fin[3] = $qryRow[3];  // log date
		$fin[4] = $qryRow[4];  // log time
		$fin[5] = $qryRow[5];  // log IP
	}
	echo json_encode($fin);

	$sqlCon->sqlClose();

	return $fin;
}

function writeNewGroup($group, $userID){
	$sqlCon->sqlConn();
	$q = "insert into Groups values ('0','$userID', '$group->groupID', '$group->groupName', '$group->groupSize', '$group->groupSyncDate', '$group->groupSyncTime')";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
}
function writeNewContact($contact, $groupID, $userID){
	$sqlCon->sqlConn();
	$q = "insert into Contacts values ('0','$userID', '$groupID', '$contact->cntID', '$contact->cntName', '$contact->cntEmail', '$contact->cntPhone')";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
}

/*
* Get the previous login token we assigned to this user
*/
function getPreviousUserDetails($user){
$sqlCon = new dbConnect();
$sqlCon->sqlConn();
$q = "select * from Users where userID='$user->userGID'";
$userRes = mysql_query($q) or die("couldn't find user in database");

	while($qryRow = mysql_fetch_array($userRes)){
		$user->userToken = $qryRow[2];  // ourToken

		$user->userRegDate = $qryRow[12];  // registration date
		$user->userRegTime = $qryRow[13];

		$user->userPhone = $qryRow[6];
		$user->userEmail = $qryRow[5];

		$user->MaxAlbum = $qryRow[16];
		$user->MaxImage = $qryRow[17];
		$user->MaxGroup = $qryRow[18];
		$user->MaxContact = $qryRow[19];
	}
	$sqlCon->sqlClose();
	return $user;
}

function getPhoneNumber(){
	return getTokenHeader();
}

?>
