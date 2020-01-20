<?php

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://accounts.spotify.com/api/token");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	$code = '**********';
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=authorization_code&redirect_uri=https%3A%2F%2Fsandbox.ostertun.net&client_id=*****&client_secret=*****&code=' . $code);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	$response = json_decode($output, true);
	
	$req_dump = print_r($response, TRUE);
	$fp = fopen('auth.log', 'a');
	fwrite($fp, $req_dump);
	fclose($fp);
	
	echo $req_dump;