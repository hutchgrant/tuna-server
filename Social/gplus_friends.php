<?php
include_once 'google_access.php';
include_once '../Element/User.php';

$GToken = getToken();
$friends = getCircled($GToken);
/*
echo "{ \"items\" : ";
$count = 1;
foreach($friends as $user){
	if($count <= 30){
		$user->send();
	}
	$count++;
}
echo "\n } \n ] \n }";
*/
echo $friends;
?>
