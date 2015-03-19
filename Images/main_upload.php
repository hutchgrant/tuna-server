<?php
include_once '../Database/dbConnect.php';
include_once '../Database/genToken.php';


/*
 *  Get the photo details from json post
 */
function getPhotoDetails(){
	$photo = new Photo();
	$json = file_get_contents('php://input');
	$obj = json_decode($json);
	$photo->fill($obj->{'ID'}, $obj->{'Type'}, $obj->{'Name'}, $obj->{'username'}, $obj->{'userID'}, $obj->{'Title'}, $obj->{'Description'},
	 $obj->{'UploadDate'}, $obj->{'UploadTime'});
	
	return $photo;
}

/*
* Get the Album details from JSON post
*//*
function getAlbumDetails(){
	$album = new Album();
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	$album->fill($obj['
}*/

/*
 * create random id for uploaded image
 */
function createRandomID() {

	$chars = "abcdefghijkmnopqrstuvwxyz0123456789?";
	//srand((double) microtime() * 1000000);
	$i = 0;
	$pass = "";

	while ($i <= 8) {
		$num = rand() % 33;
		$tmp = substr($chars, $num, 1);
		$pass = $pass . $tmp;
		$i++;
	}
	return $pass;
}

/*
 * write upload URL and photo file details
*/
function writeUploadURL($photo){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$actDate = date('Y-m-d');
	$actTime = date('H:i:s', time());
   	$IPaddress = $_SERVER['REMOTE_ADDR'];
	/// create random token for image upload
	$imguploadURL = createRandomID();
	
	$q = "insert into Images values ('0', '$photo->ID', '$imguploadURL', '$photo->Name', '$photo->username', '$photo->userID', '$photo->albumID', 
	'$photo->Title', '$photo->Description', '$actTime', '$actDate', '$IPaddress' )";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
	echo $imguploadURL;
}

/*
 *  check if upload URL is legit
*/
function checkUploadUrl($uploadURL){
	$fin = array();
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "SELECT * from Images where imguploadID='$uploadURL'";
	$userRes = mysql_query($q);
	
	if(is_resource($userRes) && mysql_num_rows($userRes) > 0 ){
		$sqlCon->sqlClose();
		return true;
	}
	else{
		$sqlCon->sqlClose();
		return false;
	}
}

/*
 * Write Final Image Name to image record
 * @param: imgName  created by the saveImage()
 */
function writeImage($uploadURL, $imgName){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	/// set random string for img
	//$imgResult = createRandomID();
	$q = "UPDATE Images SET imgName='$imgName' where imguploadID ='$uploadURL'";
	$sqlCon->finQry($q);
	$sqlCon->sqlClose();
	return $imgResult;
}

/*
 *  Return final photo after details and photo uploaded
 *  @param: pageToken created by the writeImage()
 */
function getImage($pageToken){
	$sqlCon = new dbConnect();
	$sqlCon->sqlConn();
	$q = "select * from Images where imgID='$pageToken'";
	$photo = new Photo();
	$userRes = mysql_query($q) or die("couldn't find user in database");
	
	while($qryRow = mysql_fetch_array($userRes)){
		$photo->ID = $qryRow[1];         // skip record and uploadID
		$photo->Type = $qryRow[3];  
		$photo->Name = $qryRow[4]; 
		$photo->username = $qryRow[5]; 
		$photo->userID = $qryRow[6]; 
		$photo->albumID = $qryRow[7];
		$photo->Title = $qryRow[8];
		$photo->Description = $qryRow[9];
		$photo->UploadTime = $qryRow[10];
		$photo->UploadDate = $qryRow[11]; 
	}
	
	$sqlCon->sqlClose();
	
	return $photo;
}


?>
