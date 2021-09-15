<?php

	require_once(__DIR__ . '/access.php');

	// ### MOVE SONG FROM PL_WYW TO PL_WISH #########################################

	if (!isset($_GET['trackid'])) die('no trackid given');
	// *** GET FIRST SONG FROM PL_WYW ***
	$trackid = $_GET['trackid'];
	// *** REMOVE SONG FROM PL_WYW ***
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/users/" . SP_USERNAME . "/playlists/" . PL_WDW . "/tracks");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	$buf = '{ "tracks": [{ "uri": "spotify:track:' . $trackid . '" }] }';
	curl_setopt($ch, CURLOPT_POSTFIELDS, $buf);
	$response = curl_exec_access_token($ch, strlen($buf));
	var_dump($response);

?>
