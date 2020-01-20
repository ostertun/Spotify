<?php
	
	require_once(__DIR__ . '/access.php');
	require_once(__DIR__ . '/../site/server/functions.php');
	
	// ### REMOVE CURRENT SONG FROM PL_WISH #########################################
	
	// *** GET CURRENT SONG ***
	$track = spotify_getsong();
	if (($track !== false) and (isset($track['item']))) {
		$trackid = $track['item']['id'];
		// *** REMOVE SONG FROM PL_WISH ***
		spotify_remove(SP_USERNAME, PL_WISH, $trackid);
	}
	
	// ### REMOVE UNPLAYABLE SONGS FROM PL_WISH #########################################
	
	// *** GET SONGS FROM WISHLIST ***
	$tracks = getPlaylist(SP_USERNAME, PL_WISH);
	if (($tracks !== false) and (count($tracks) > 0)) {
		foreach ($tracks as $track) {
			if (!$track['track']['is_playable']) {
				// *** REMOVE SONG FROM PL_WISH
				$trackid = $track['track']['id'];
				spotify_remove(SP_USERNAME, PL_WISH, $trackid);
			}
		}
	}
	
	// ### MOVE SONG FROM PL_WYW TO PL_WISH #########################################
	
	// *** GET FIRST SONG FROM PL_WYW ***
	$track = getPlaylist(SP_USERNAME, PL_WDW, 1);
	if (($track !== false) and (count($track) == 1)) {
		$trackid = $track[0]['track']['id'];
		// *** ADD SONG TO PL_WISH AND PL_SAVED ***
		wish($trackid);
		// *** REMOVE SONG FROM PL_WYW ***
		spotify_remove(SP_USERNAME, PL_WDW, $trackid);
	}
	
	// ### MOVE SONG FROM PL_POOL TO PL_WISH #########################################
	
	// *** GET SONGS FROM PL_WISH ***
	$tracks = getPlaylist(SP_USERNAME, PL_WISH, 3);
	if (($tracks !== false) and (count($tracks) < 3)) {
		// *** GET RANDOM SONG FROM PL_POOL ***
		$tracks = getPlaylist(SP_USERNAME, PL_POOL);
		if (($tracks !== false) and (count($tracks) > 0)) {
			$i = random_int(0, count($tracks) - 1);
			$trackid = $tracks[$i]['track']['id'];
			// *** ADD SONG TO PL_WISH AND PL_SAVED ***
			wish($trackid);
			// *** REMOVE SONG FROM PL_POOL ***
			spotify_remove(SP_USERNAME, PL_POOL, $trackid);
		}
	}
	
?>