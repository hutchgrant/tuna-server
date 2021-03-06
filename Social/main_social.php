<?php
include_once '../Database/dbConnect.php';

/*
 *  Get the group details from json post
 */
function getGroupDetails($authorID){

	$group = new Group();
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
			$group->fill(
			$obj['grpID'], 
			$obj['grpName'], 
			$obj['grpSize'], 
			$obj['grpSyncDate'], 
			$obj['grpSyncTime'],
			$authorID);
			
			// echo all data
			foreach($obj['People'] as $key => $value) {
				$grpID = $value['groupID'];
				$googID = $value['googleID'];
				$id = $value['id'];
				$name = $value['name'];
				$email = $value['email'];
				$phone = $value['phone'];
				$img = $value['img'];
				$group->addContact($grpID,$id, $googID, $name, $email, $phone, $img); 
			}
			return $group;
}

function writeGroup($group){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
   	$IPaddress = $_SERVER['REMOTE_ADDR'];
	$group->groupSyncDate =  date('Y-m-d');
	$group->groupSyncTime = date('H:i:s', time());
	$q = "insert into Groups values ('0', '$group->groupAuthor', '$group->groupID', '$group->groupName', '$group->groupSize', '$group->groupSyncDate', '$group->groupSyncTime')";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
	writeAllContacts($group);
	return $group;
}

function writeAllContacts($group){
	 $sqlCon = new dbConnect();
	 $sqlCon->sqlConn();
	foreach($group->people as $obj){
	 $q = "insert into Contacts values ('0', '$group->groupAuthor', '$group->groupID', '$obj->ID', '$obj->GoogleID', '$obj->Name', '$obj->Email', '$obj->Phone', '$obj->Image')";
	 $sqlCon->finQry($q);
	}

	 $sqlCon->sqlClose();
} 

function writeContact($contact, $userID){
	 $sqlCon = new dbConnect();
	 $sqlCon->sqlConn();
	 $q = "insert into Contacts values ('0', '$userID', '$contact->GroupID', '$contact->ID', '$contact->GoogleID', '$contact->Name', '$contact->Email', '$contact->Phone', '$contact->Image')";
	 $sqlCon->finQry($q);
	 $sqlCon->sqlClose();
}

function updateGroups($group){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
   	$IPaddress = $_SERVER['REMOTE_ADDR'];
	$group->groupSyncDate =  date('Y-m-d');
	$group->groupSyncTime = date('H:i:s', time());
	$q = "update Groups SET groupName='$group->groupName', groupSize='$group->groupSize', syncDate='$group->groupSyncDate', syncTime='$group->groupSyncTime' WHERE UserGroupID='$group->groupID' AND UserID='$group->groupAuthor'";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
	return $group;
}

function updateContact($contact, $userID){
	if($contact->Name != "removed"){	
		$sqlCon = new dbConnect();
		$sqlCon->sqlConn();
		$q = "update Contacts SET ContactID='$contact->ID', GoogleID='$contact->GoogleID', ContactName='$contact->Name', ContactEmail='$contact->Email', ContactPhone='$contact->Phone', ContactImage='$contact->Image' WHERE UserID='$userID' AND GroupID='$contact->GroupID' AND ContactID='$contact->ID'";
		$sqlCon->finQry($q);
		$sqlCon->sqlClose();
	}else{
		removeSingleContact($contact, $userID);	
	}
} 

/*
* Read all groups from database at once as a LifeGroup
*/
function getLifeGroup($userID, $syncDate, $syncTime){
	 $sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$finQry = "";
	if($syncDate == "na" || $syncDate == "0000-00-00"){
		$q = "select * from Groups where UserID='$userID' ";
	}else{
		$currentTime = date('H:i:s', time());
		$q = "select * from Groups where UserID='$userID' and Timestamp(syncDate, syncTime) >= Timestamp('$syncDate','$syncTime')";
	}	
	$userRes = mysql_query($q) or die("couldn't find user in database");
	$life = new LifeGroup();
	while($qryRow = mysql_fetch_array($userRes)){
		$grp = new Group();
		$grp->fill($qryRow[2], $qryRow[3], $qryRow[4], $qryRow[5], $qryRow[6], $userID);	
		$life->addGroup($grp);
	}
	$sqlCon->sqlClose();   
	$life = getLifeGroupContacts($life);
	return $life;
} 

function getLifeGroupContacts($life){

	 $sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$finQry = "";
	foreach($life->groups as $group){
		$q = "select * from Contacts where GroupID='$group->groupID'";
		$userRes = mysql_query($q) or die("couldn't find user in database");
		while($qryRow = mysql_fetch_array($userRes)){
			$group->addContact($qryRow[2], $qryRow[3], $qryRow[4], $qryRow[5], $qryRow[6], $qryRow[7], $qryRow[8]);
		} 
	}
	
	$sqlCon->sqlClose();
	 return $life; 
}

function updateFriendGroup($userID, $groupID, $syncDate, $syncTime){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
   	$IPaddress = $_SERVER['REMOTE_ADDR'];
	$group->groupSyncDate =  $syncDate;
	$group->groupSyncTime = $syncTime;
	$q = "update Groups SET groupSize=groupSize+1, syncDate='$syncDate', syncTime='$syncTime' WHERE UserGroupID='$groupID' AND UserID='$userID'";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
	return $group;
}

function removeGroupByID($userID, $groupID){
	 $sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "delete from Groups where UserGroupID='$groupID' AND UserID='$userID'";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
	removeContactsByGroup($userID, $groupID);
}

function removeContactsByGroup($userID, $groupID){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();

	if( $groupID ){
		$q = "delete from Contacts where UserID='$userID' AND GroupID='$groupID'";
		$sqlCon->finQry($q);
	}
	$sqlCon->sqlClose();
}

function removeSingleContact($contact, $userID){
		$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "delete from Contacts where UserID='$userID' AND GroupID='$contact->GroupID' AND ContactID='$contact->ID'";
		$sqlCon->finQry($q);
	$sqlCon->sqlClose();
}

function displayDateTime(){
	
}

function getPhotoById($pID){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$finQry = "";
	$q = "select * from Images where imgID='$pID'";
	$userRes = mysql_query($q) or die("couldn't find user in database");
	while($qryRow = mysql_fetch_array($userRes)){
			$img = $qryRow[3];
	} 	
	$sqlCon->sqlClose();  
	 return $img; 
}


?>
