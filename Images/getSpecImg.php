<?php
include '../Element/Photo.php';
include '../Database/validate.php';
include './imageMain.php';

$userToken = getTokenHeader();
if(checkTokenHeader($userToken) == true){
	$imageID = getSpecificImageDetail();

	if(validateImgID($imageID) == true){
		$photo = new Photo();		
		$photo = getSingleImage($imageID);
		$finArr = array();
		$finArr = $photo->send();
		echo json_encode($finArr);
	}


}
