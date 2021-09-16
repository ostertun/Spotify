<?php

	/* Sends an SKIP request to the currently playing device
	 *
	 * Required REQUEST params:
	 *  ---
	 */

	require_once(__DIR__ . '/../access.php');

	// *** GET CURRENT SONG ***
	$track = spotify_getsong();

	spotify_next();

	if (($track !== false) and (isset($track['item']))) {
		$trackid = $track['item']['id'];
		// *** REMOVE SONG FROM PL_WISH ***
		spotify_remove(SP_USERNAME, PL_WISH, $trackid);
		// *** REMOVE SONG FROM PL_POOL ***
		spotify_remove(SP_USERNAME, PL_POOL, $trackid);
	}

?>
