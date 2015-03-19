<?php
include 'main_social.php';
include '../Element/Group.php';
include '../Element/LifeGroup.php';
include '../Sync/sync_interface.php';
include '../Database/validate.php';

$userToken = getTokenHeader();
$group = new Group();

if(checkTokenHeader($userToken) == true){
$userID = getUserID($userToken);
$group = getGroupDetails($userID);
	if(validateGroup($group) == true){
		if(checkGroupExists($group) == true){
			if($group->groupSyncDate == "removed"){
				removeGroupByID($userID, $group->groupID);	
				updateGroupSync($group->groupAuthor, $group->groupSize-1, date('Y-m-d'), date('H:i:s', time()), "false");		
			}else{
				$group = updateGroups($group);
				updateGroupSync($group->groupAuthor, $group->groupSize, $group->groupSyncDate, $group->groupSyncTime, "true"); 
				foreach($group->people as $obj){
					if(checkContactExists($obj, $userID) == true){
						if($obj->Name == "removed"){
							removeSingleContact($obj, $group->groupAuthor);	
						}else{				
							updateContact($obj, $group->groupAuthor);
						}			
					}else{
						writeContact($obj, $group->groupAuthor);			
					}
				} 
			}
		
		}else{
			$group = writeGroup($group);
			// echo "group author = ".$group->groupAuthor."  ".$group->groupSize."  ".$group->groupSyncDate."  ".$groupSyncTime;
			updateGroupSync($group->groupAuthor, $group->groupSize, $group->groupSyncDate, $group->groupSyncTime, "true"); 
		} 
		$lifeGrp = new LifeGroup();
		$lifeGrp->addGroup($group);
		$lifeGrp->displayLife(); 
	} 
} 
?>
