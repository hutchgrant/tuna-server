<?php
include '../Database/dbConnect.php';

/*
*  Convert all the JSON input to Albums
*/
function getAlbumDetails(){

$album = new Album();
$json = file_get_contents('php://input');
$obj = json_decode($json, true);
$album->fill($obj['ID'], $obj['UserName'], $obj['Title'], $obj['Size'], $obj['SyncDate'], $obj['SyncTime']);

	/// echo all data
	foreach($obj['images'] as $key => $value) {
		$photo = new Photo();	
		$photo->fill($value['ID'], $value['Type'], $value['Name'], $value['username'],
			$value['userID'], $value['AlbumID'], $value['Title'],
			$value['Description'], $value['UploadTime'], $value['UploadDate'], $value['UploadToken']); 
		$album->addPhoto($photo); 
	}  
	return $album;	
}

function writeAlbum($album){
	$actDate = date('Y-m-d');
	$actTime = date('H:i:s', time());
	$album->syncDate = $actDate;
	$album->syncTime = $actTime;
	$album->size = $album->size - 1;  // counter begins at 0
///	$album->id = randString(10);

	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();	
	$q = "insert into Albums values ('0', '$album->id', '$album->user', '$album->title', '$album->size', '$album->syncDate', '$album->syncTime')";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();  

	$album = writeAlbumPhotos($album);

	return $album;
}

function writeAlbumPhotos($album){
	$IPaddress = $_SERVER['REMOTE_ADDR'];
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	foreach($album->photos as $key => $value){
	//	$value->ID = randString(10);		
	//	$value->albumID = $album->id;		
		$value->UploadToken = randString(20);
		$value->UploadDate = $album->syncDate;
		$value->UploadTime = $album->syncTime;
		
		$q = "insert into Images values ('0', '$value->ID', '$value->UploadToken', '$value->Name', '$value->username', '$value->userID','$value->albumID', '$value->Title', '$value->Description', '$value->UploadTime', '$value->UploadDate', '$IPaddress')"; 
		$sqlCon->finQry($q);
	}
	$sqlCon->sqlClose();  

	return $album;
}

/*
 * Generate random string for token
*/
function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}
		return $str;
}

function updateAlbum($album){
	$actDate = date('Y-m-d');
	$actTime = date('H:i:s', time());
	$album->syncDate = $actDate;
	$album->syncTime = $actTime;
///	$album->id = randString(10);

	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();	
	$q = "update Albums SET AlbumName='$album->Title', AlbumSize='$album->size', SyncDate='$album->syncDate', SyncTime='$album->syncTime' WHERE AlbumID='$album->AlbumID'";

	$sqlCon->finQry($q);
	$sqlCon->sqlClose();  

	$album = updateAlbumPhotos($album);
	return $album;
}


function updateAlbumPhotos($album){
	foreach($album->photos as $upImg){	
		$upImg->UploadDate = $album->syncDate;
		$upImg->UploadTime = $album->syncTime;

		if($upImg->syncDate == "updated"){
			 updateImage($upImg);
		}else if($upImg->syncDate == "removed"){
			removeImageByID($upImg->userID, $upImg->ID, $upImg->Name);			
		}else{
			writeImage($upImg);
		}
	}
	return $album;
}

function updateImage($img){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "update Images SET imgName='$img->Name', username='$img->username', userID='$img->userID', albumID='$img->albumID', title='$img->Title', description='$img->Description', uploadtime='$img->UploadTime', uploaddate='$img->UploadDate' WHERE imgID='$img->ID'"; 
		$sqlCon->finQry($q);
	$sqlCon->sqlClose();  
}  
function writeImage($img){
	$IPaddress = $_SERVER['REMOTE_ADDR'];
	$img->UploadToken = randString(20);
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "insert into Images values ('0', '$img->ID', '$img->UploadToken', '$img->Name', '$img->username', '$img->userID','$img->albumID', '$img->Title', '$img->Description', '$img->UploadTime', '$img->UploadDate', '$IPaddress')"; 
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();  
} 

function removeAlbum($album){
	 $sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "delete from Albums where AlbumID='$album->id' AND AuthorID='$album->user'";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
	removeImagesByAlbum($album);
	return $album;
}

function removeImagesByAlbum($album){
	foreach($album->photos as $endImg){
		removeFile($endImg->Name);
	}	
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "delete from Images where userID='$album->user' AND albumID='$album->id'";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
}

function removeImageByID($userID, $photoID, $photoName){
	removeFile($photoName);
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "delete from Images where userID='$album->user' AND imgID='$photoID'";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
}

function removeFile($file){
		/// delete file from disk
	unlink("../Upload/images/post_images/" . $file);
	
} 

?>
