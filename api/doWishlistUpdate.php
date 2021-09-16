<?php

	require_once(__DIR__ . '/access.php');
	require_once(__DIR__ . '/../site/server/functions.php');

	// ### REMOVE CURRENT SONG FROM PL_WISH AND PL_POOL AND TRACK IT #########################################

	// *** GET CURRENT SONG ***
	$track = spotify_getsong();
	if (($track !== false) and (isset($track['item']))) {
		$trackid = $track['item']['id'];
		// *** REMOVE SONG FROM PL_WISH ***
		spotify_remove(SP_USERNAME, PL_WISH, $trackid);
		// *** REMOVE SONG FROM PL_POOL ***
		spotify_remove(SP_USERNAME, PL_POOL, $trackid);
		// *** TRACK SONG ***
		trackSong($trackid);
	}

	// ### REMOVE UNPLAYABLE SONGS FROM PL_WISH #########################################

	// *** GET SONGS FROM WISHLIST ***
	$tracks = getPlaylist(SP_USERNAME, PL_WISH, -1, 0, true);
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
	if (($track !== false) and (count($track) > 0)) {
		for ($i = 0; $i < count($track); $i ++) {
			$trackid = $track[$i]['track']['id'];
			// *** ADD SONG TO PL_WISH AND PL_SAVED ***
			wish($trackid);
			// *** REMOVE SONG FROM PL_WYW ***
			spotify_remove(SP_USERNAME, PL_WDW, $trackid);
		}
	}

	// ### MOVE SONG FROM PL_POOL TO PL_WISH #########################################

	// *** GET SONGS FROM PL_WISH ***
	$tracks = getPlaylist(SP_USERNAME, PL_WISH, 3);
	if (($tracks !== false) and (count($tracks) < 3)) {
		// *** GET RANDOM SONG FROM PL_POOL ***
		$tracks = getPlaylist(SP_USERNAME, PL_POOL, -1, 0, true);
		if (($tracks !== false) and (count($tracks) > 0)) {
			$i = random_int(0, count($tracks) - 1);
			if ($tracks[$i]['track']['is_local']) {
				// TODO: is a local song, not removable
			} else {
				$trackid = $tracks[$i]['track']['id'];
				if ($tracks[$i]['track']['is_playable']) {
					// *** ADD SONG TO PL_WISH AND PL_SAVED ***
					$result = wish($trackid);
					if ($result != 0)
						file_put_contents(__DIR__ . '/cron.log', "wish returned $result\t$trackid\t" . $tracks[$i]['track']['name'] . "\t" . json_encode($tracks[$i]['track']) . "\n", FILE_APPEND);
				} else {
					file_put_contents(__DIR__ . '/cron.log', "unplayable\t$trackid\t" . $tracks[$i]['track']['name'] . "\t" . json_encode($tracks[$i]['track']) . "\n", FILE_APPEND);
				}
				if (isset($tracks[$i]['track']['linked_from'])) {
					$trackid = $tracks[$i]['track']['linked_from']['id'];
				}
				// *** REMOVE SONG FROM PL_POOL ***
				spotify_remove(SP_USERNAME, PL_POOL, $trackid);
			}
		}
	}

?>
