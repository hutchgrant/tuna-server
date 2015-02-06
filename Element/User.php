<?php

class User{
	
	var $userToken;
	var $userGID;
	var $userGName;
	var $userEmail;
	var $userPhone;
	var $userProfile;
	var $userImgUrl;
	var $userLocation;	
	var $userRegDate;
	var $userRegTime;
	var $userLoginTime;
	var $userLoginDate;
	
	var $MaxAlbum;
	var $MaxImage;
	var $MaxGroup;
	var $MaxContact;

	function _construct(){
		$userToken = "";
		$userGID = "";
		$userGName = "";
		$userEmail = "";
		$userPhone = "";
		$userProfile = "";
		$userImgUrl = "";
		$userLocation = "";
		$userRegDate = "";
		$userRegTime = "";
		$userLoginTime = "";
		$userLoginDate = "";

		$MaxAlbum = "";
		$MaxImage = "";
		$MaxGroup = "";
		$MaxContact = "";
	}
	
	function fill($usrToken, $userID, $displayName, $email, $phone, $usrProfile, $usrImgUrl, $usrLocation,
			$maxAlb, $maxImg, $maxGrp, $maxCont){
		$this->userToken = $usrToken;
		$this->userGID = $userID;
		$this->userGName = $displayName;
		$this->userEmail = $email;
		$this->userPhone = $phone;
		$this->userProfile = $usrProfile;
		$this->userImgUrl = $usrImgUrl;
		$this->userLocation = $usrLocation;
		
		$this->MaxAlbum = $maxAlb;
		$this->MaxImg = $maxImg;
		$this->MaxGrp = $maxGrp;
		$this->MaxContact = $maxCont;
	}

	function fillLogin($date, $time){
		$this->userLoginDate = $date;
		$this->userLoginTime = $time;
	}

	function fillReg($date, $time){
		$this->userRegDate = $date;
		$this->userRegTime = $time;
	}
		

	function send(){
		$userdisplay = array('userToken' => $this->userToken,
							'userGID' => $this->userGID,
							'userGName' => $this->userGName,
							'userEmail' => $this->userEmail,
							'userPhone' => $this->userPhone,
							'userProfile' => $this->userProfile,
							'userImgUrl' => $this->userImgUrl,
							'userLocation' => $this->userLocation,
							'userRegDate' => $this->userRegDate,
							'userRegTime' => $this->userRegTime,
							'userLoginDate' => $this->userLoginDate,
							'userLoginTime' => $this->userLoginTime,
							'MaxAlbums' => $this->MaxAlbum,
							'MaxImages' => $this->MaxImage,
							'MaxGroups' => $this->MaxGroup,
							'MaxContacts' => $this->MaxContact);
			
		echo json_encode($userdisplay);
	}
	
	function __destruct(){
		
	}
}
?>
