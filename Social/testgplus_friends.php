<?php
	$url = "https://www.googleapis.com/plus/v1/people/me";
	$headr = array();
	$headr[] = 'Authorization: OAuth INSERTGTOKENHERE';
	
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
	echo $loginUser;


?>
