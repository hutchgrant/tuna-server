<?php
include '../Element/LifeAlbum.php';
include '../Database/validate.php';
include './imageMain.php';

$userToken = getTokenHeader();
if(checkTokenHeader($userToken) == true){
	$albumID = getSpecificAlbumDetail();

	if(validateAlbID($albumID) == true){
		$alb = new Album();
		$alb = getSingleAlbum($albumID);
		$life = new LifeAlbum();
		$life->addAlbum($alb);
 		$life->displayLife(); 
	}


}
