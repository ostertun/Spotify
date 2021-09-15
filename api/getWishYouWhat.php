<?php

	require_once(__DIR__ . '/access.php');

	// ### MOVE SONG FROM PL_WYW TO PL_WISH #########################################

	// *** GET FIRST SONG FROM PL_WYW ***
	$track = getPlaylist(SP_USERNAME, PL_WDW);
	if (($track !== false) and (count($track) > 0)) {
		for ($i = 0; $i < count($track); $i ++) {
			$trackid = $track[$i]['track']['id'];
			echo $trackid . ": " . $track[$i]['track']['name']
			 	. " /// in WYW: " . (inPlaylist(SP_USERNAME, PL_WDW, $trackid) ? 'JA' : 'NEIN')
				. " /// in WISH: " . (inPlaylist(SP_USERNAME, PL_WISH, $trackid) ? 'JA' : 'NEIN')
				. "<br>\n";
		}
	}

?>
