<?php
include 'main_upload.php';
include '../Element/Photo.php';
include '../Database/validate.php';

$ourToken = getImageTokenHeader();
if(checkTokenHeader($ourToken) == true){
	$uploadURL = getUploadHeader();
	if(checkUploadUrl($uploadURL) == true){
				$base = $_REQUEST["image"];

				if (isset($base)) {
					$suffix = createRandomID();
					$image_name = "img_".$suffix."_".date("Y-m-d-H-m-s").".jpg";
					
					// base64 encoded utf-8 string
					$binary = base64_decode($base);
					
					// binary, utf-8 bytes
					header("Content-Type: bitmap; charset=utf-8");
					
					$file = fopen("./images/post_images/" . $image_name, "wb");
					fwrite($file, $binary);
					fclose($file);
					$imgFinURL = writeImage($uploadURL, $image_name);

					$FinalPhoto = getImage($imgFinURL);
					$FinalPhoto->send();
					die($image_name);
				
				} else {
					die("No POST");
				}  
			
	}else{
		echo "invalid upload url :=".$uploadURL;
	}
}else{
	echo "invalid Utoken :=".$ourToken;
}
?>
