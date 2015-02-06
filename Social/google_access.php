<?php

/*
 * Get the token from the android device via json
 * First We have to get the token received from the connected device
 * @param: JSON POST AuthUtils
 */
function getToken(){
	$json = file_get_contents('php://input');
	$obj = json_decode($json);
	$accesstoken = $obj->{'access_token'};
	return $accesstoken;
}
/*
 * Get profile from google using google token
 * @param: google token (retrieved from authenticated device source)
 */
function getProfile($token, $UStoken){
	$url = "https://www.googleapis.com/plus/v1/people/me";
	$headr = array();
	$headr[] = 'Authorization: OAuth '.$token;
	
	$crl = curl_init();
	curl_setopt($crl, CURLOPT_URL, $url);
	curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
	curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, true);
	curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
	$rest = curl_exec($crl);
	curl_close($crl);
	/// return array of user's profile
	$outputDecode = json_decode($rest, true);
	
	foreach($outputDecode['placesLived'] as $chunk) {
		$place = $chunk['value'];
	}
	
	$loginUser = new User();
	$loginUser->fill($UStoken, $outputDecode['id'], $outputDecode['displayName'],$outputDecode['url'], 
			$outputDecode['image']['url'], $place);

	return $loginUser;
}

/*
 * Get circled from google using google token
* @param: google token (retrieved from authenticated device source)
* @param: crl connection ( use $crl=curlconnect() )
*/
function getCircled($token){
	$url = "https://www.googleapis.com/plus/v1/people/me/people/visible";
	$headr = array();
	$headr[] = 'Authorization: OAuth '.$token;
	
	$crl = curl_init();
	curl_setopt($crl, CURLOPT_URL, $url);
	curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
	curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, true);
	curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
	$rest = curl_exec($crl);
	curl_close($crl);
	/// return array of users circled by token user
	/*$usrArray = array();
	$outputDecode = json_decode($rest, true);
	foreach($outputDecode['items'] as $chunk) {
		$circleUser = new User();
		$circleUser->fill("", $chunk['id'], $chunk['displayName'],$chunk['url'],$chunk['image']['url'], "");
		$circleUser->fillReg("", "");
		$circleUser->fillLogin("", "");
		array_push($usrArray, $circleUser);
		//$circleUser->send();
		// echo " : ".$chunk['displayName'];
	}*/

	return $rest;
}
/*
 * Converts the cURL , JSON, rest to something we can return
 * @param: type 
*/
function convertrest($type, $rest){
	
}

?>
