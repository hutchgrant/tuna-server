<?php
include '../Element/Album.php';
//include '../Element/Photo.php';
include './albumMain.php';
include '../Database/validate.php';
include '../Sync/sync_interface.php';

$userToken = getTokenHeader();
if(checkTokenHeader($userToken) == true){
	$userID = getUserID($userToken);
	$albums = getAlbumDetails();
	if(validateAlbum($albums) == true){
		if($albums->syncDate == "removed"){
			$albums = removeAlbum($albums);			
			updateImageSync($userID, $album->size, date('Y-m-d'), date('H:i:s', time()), "false");	
			$albums->displayAlbum();		
		}else if($albums->syncDate == "updated"){
			$album = updateAlbum($albums);
			$albums->displayAlbum();	
		} 
		else{
			$albums = writeAlbum($albums);	
			updateImageSync($userID, $albums->size, $albums->syncDate, $albums->syncTime, "true");
			$albums->displayAlbum();
		} 
	}

}  
?>
