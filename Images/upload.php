<?php
include 'main_upload.php';
include '../Element/Photo.php';
$uploadToken = getTokenHeader();

if(checkTokenHeader($uploadToken)){
		$photo = getPhotoDetails();
		writeUploadURL($photo);
}

/*if header correct with token
	if(upload url){ in header
		if(uploadurl in database == true){
			getImage
		}
		else{
			 send error
		} 
	else{
		getPhotodetails
		writeToDatabase
		createUploadUrl
	}
  else {
  	return error
  }
*/
?>
