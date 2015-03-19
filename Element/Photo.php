<?php

class Photo{

	var $ID;
	var $Type;
	var $Name;
	var $username;
	var $userID;
	var $albumID;
	var $Title;
	var $Description;
	var $UploadTime;
	var $UploadDate;
	var $UploadToken;
	
	
	function _construct(){
		$ID = "";
		$Type = "";
		$Name = "";
		$username = "";
		$userID = "";
		$albumID = "";
		$Title = "";
		$Description = "";
		$UploadTime = "";
		$UploadDate = "";
		$UploadToken = "";
	}

	function fill($imgID, $imgType, $imgName, $imgAuthor, $imgAuthorID, $albID, $imgTitle, $imgDescription, $upTime, $upDate, $upToken){
		$this->ID = $imgID;
		$this->Type = $imgType;
		$this->Name = $imgName;
		$this->username = $imgAuthor;
		$this->userID = $imgAuthorID;
		$this->albumID = $albID;
		$this->Title = $imgTitle;
		$this->Description = $imgDescription;
		$this->UploadTime = $upTime;
		$this->UploadDate = $upDate;
		$this->UploadToken = $upToken;
	}

	function send(){
		$userdisplay = array('ID' => $this->ID,
							'Type' => $this->Type,
							'Name' => $this->Name,
							'username' => $this->username,
							'userID' => $this->userID,
							'AlbumID' => $this->albumID,
							'Title' => $this->Title,
							'Description' => $this->Description,
							'UploadTime' => $this->UploadTime,
							'UploadDate' => $this->UploadDate,
							'UploadToken' => $this->UploadToken);
			return $userdisplay;
		//echo json_encode($userdisplay);
	}
}

?>
