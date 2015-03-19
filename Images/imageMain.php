<?php
include_once '../Database/dbConnect.php';

function getAllImages($userID){
	$album = new Album();
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$finQry = "";
	$q = "select * from Images where userID='$userID'";
	$userRes = mysql_query($q) or die("couldn't find user in database");
	while($qryRow = mysql_fetch_array($userRes)){
		$img = new Photo();
		$img->fill($qryRow[1],$qryRow[3],$qryRow[4],$qryRow[5],$qryRow[6],$qryRow[7],$qryRow[8],$qryRow[9],$qryRow[10],$qryRow[12],$qryRow[13],$qryRow[14],$qryRow[15]);
		$album->addPhoto($img);
	}
	$sqlCon->sqlClose();
	return $album;
}

function getSingleImage($imgID){
	$sqlCon = new dbConnect();
	$img = new Photo();
	$sqlCon->sqlConn();
	$finQry = "";
	$q = "select * from Images where imgID='$imgID'";
	$userRes = mysql_query($q) or die("couldn't find user in database");
	while($qryRow = mysql_fetch_array($userRes)){
		$img->fill($qryRow[1],"jpg",$qryRow[3],$qryRow[4],$qryRow[5],$qryRow[6],$qryRow[7],$qryRow[8],$qryRow[10],$qryRow[9],$qryRow[2]);
	}
	$sqlCon->sqlClose();
	return $img;
}

function getSingleAlbum($albID){
	$alb = new Album();
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$finQry = "";
	$q = "select * from Albums where AlbumID='$albID'";
	$userRes = mysql_query($q) or die("couldn't find user in database");
	while($qryRow = mysql_fetch_array($userRes)){
		$alb->fill($qryRow[1], $qryRow[2], $qryRow[3], $qryRow[4], $qryRow[5], $qryRow[6]);
	}
	$sqlCon->sqlClose();
	$alb = getAlbumPhotos($alb);
	return $alb;
}

/*
* Read all groups from database at once as a LifeGroup
*/   
 function getLifeAlbum($userID, $syncDate, $syncTime){
	 $sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$finQry = "";
	if($syncDate == "na"){
		$q = "select * from Albums where AuthorID='$userID'";
	}else{
		$q = "select * from Albums where AuthorID='$userID' and Timestamp(syncDate,syncTime) > Timestamp('$syncDate', '$syncTime')";
	}
	$userRes = mysql_query($q) or die("couldn't find user in database");
	$life = new LifeAlbum();
	while($qryRow = mysql_fetch_array($userRes)){
		$alb = new Album();
		$alb->fill($qryRow[1], $qryRow[2], $qryRow[3], $qryRow[4], $qryRow[5], $qryRow[6]);	
		$life->addAlbum($alb);
	}
	$sqlCon->sqlClose();   
	$life = getLifeAlbumPhotos($life);
	return $life;
}

function getLifeAlbumPhotos($life){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	foreach($life->albums as $album){
	$q = "select * from Images where albumID='$album->id'";
	$userRes = mysql_query($q) or die("couldn't find user in database");
		while($qryRow = mysql_fetch_array($userRes)){
			$album->addImage($qryRow[1],"jpg",$qryRow[3],$qryRow[4],$qryRow[5],$qryRow[6],$qryRow[7],$qryRow[8],$qryRow[10],$qryRow[9],$qryRow[2]);
		} 
	}
	$sqlCon->sqlClose();  
	return $life; 
}

function getAlbumPhotos($album){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "select * from Images where albumID='$album->id'";
	$userRes = mysql_query($q) or die("couldn't find user in database");
	while($qryRow = mysql_fetch_array($userRes)){
		$album->addImage($qryRow[1],"jpg",$qryRow[3],$qryRow[4],$qryRow[5],$qryRow[6],$qryRow[7],$qryRow[8],$qryRow[10],$qryRow[9],$qryRow[2]);
	}
	$sqlCon->sqlClose();  
	return $album; 
}

function getSpecificImageDetail(){
	$photo = new Photo();
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	$imgID = $obj['imageID'];
	return $imgID;
}

function getSpecificAlbumDetail(){
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	$imgID = $obj['albumID'];
	return $imgID;
}

?>
