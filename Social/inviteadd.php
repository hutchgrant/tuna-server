<?php
include 'main_social.php';
include '../Database/main_interface.php';
include '../Element/Contact.php';
include '../Element/User.php';
include '../Element/Invite.php';
include '../Element/LifeInvite.php';
include '../Element/SyncInvObj.php';
include '../Sync/sync_interface.php';
include '../Database/validate.php';
include 'invite_main.php';
include_once '../Database/genToken.php';


$userToken = getTokenHeader();
$lifeInv = new LifeInvite();

if(checkTokenHeader($userToken) == true){

	$userID = getUserID($userToken);
	$lifeInv = getInviteDetails();
	
	if(validateLifeInvite($lifeInv) == true){
		foreach($lifeInv->invites as $invite){
			
			if(checkInviteExists($userID, $invite->InviteID) == false){

				$invite->InviteDate =  date('Y-m-d');
				$invite->InviteTime = date('H:i:s', time());

				if($invite->InviteStatus == "confirmed"){
					addUserFriends($userID, $invite->InviteUserGID);
					updateInvite($invite);
				//	removeInvite($invite->InviteID);
				//	updateInvSync($userID, "remove", "sent", $invite->InviteDate, $invite->InviteTime);
				}
				else if($invite->InviteStatus == "na"){
					writeInvite($invite);
					updateInvSync($userID, "add", "sent", $invite->InviteDate, $invite->InviteTime);
					// see if recipient exists
					if(checkInvitedUserExists($invite->RecipientUserGID, $invite->RecipientEmail, $invite->RecipientPhone) == true){ 
						updateInvSync($invite->RecipientUserGID, "add", "received", $invite->InviteDate, $invite->InviteTime);
					}  /// remind check new users for received invites

				}
				else if($invite->InviteStatus == "remove"){
					//removeInvite($invite);
				}else if($invite->InviteStatus == "block"){
					//removeInvite($invite);
					/// block sender
				}  
			}else{
				$invite->InviteStatus = "already_invited";		
			}   
		}
		$lifeInv->displayLife();
	}  
}


?>
