<?php
	
	/* Adds the currently playing song to the playlist TBS
	 *
	 * Required REQUEST params:
	 *  ---
	 */
	
	require_once(__DIR__ . '/../access.php');
	
	$song = spotify_getsong();
	if (($song !== false) and (isset($song['item']))) {
		$trackid = $song['item']['id'];
		if (inPlaylist('cagrrj', '0kLNtkC5ELWCBlLi8GrutN', $trackid)) {
			echo 'CONTAINED';
		} else {
			if (spotify_add('cagrrj', '0kLNtkC5ELWCBlLi8GrutN', $trackid)) {
				echo 'OK';
			} else {
				echo 'ERR';
			}
		}
	} else {
		echo 'OFF';
	}
	
?>