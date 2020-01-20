<?php
	
	/* Adds a song to a playlist
	 *
	 * Required REQUEST params:
	 *  track        the spotify track id
	 *  user         the spotify username of the playlists owner
	 *  playlist     the spotify playlist id
	 */
	
	if (isset($_REQUEST['track'], $_REQUEST['user'], $_REQUEST['playlist'])) {
		
		require_once(__DIR__ . '/../access.php');
		
		if (spotify_add($_REQUEST['user'], $_REQUEST['playlist'], $_REQUEST['track'])) {
			echo 'OK';
		} else {
			echo 'ERR';
		}
		
	}
	
?>