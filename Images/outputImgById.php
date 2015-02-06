<?php
include '../Social/main_social.php';
include '../Database/validate.php';

$userToken = getTokenHeader();

if(checkTokenHeader($userToken) == true){
$json = file_get_contents('php://input');
$obj = json_decode($json);
$imageName = getPhotoById($obj->imageID);
$image = "../Images/images/post_images/".$imageName;
//echo $imageName;
// open the file in a binary mode
$fp = fopen($image, 'rb');

// send the right headers
header("Content-Type: image/jpeg");
header("Content-Length: " . filesize($image));
// dump the picture and stop the script
fpassthru($fp);
exit; 
}
?>
