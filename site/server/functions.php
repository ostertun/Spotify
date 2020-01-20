<?php
	
	function getBlacklistedInterprets() {
		$interpreten = array();
		$file = fopen(dirname(__FILE__) . '/blacklists/interpreten', 'r');
		if ($file) {
			while (($line = fgets($file)) !== false) {
				$line = substr($line, 0, strlen($line) - 1);
				$interpret = explode("\t", $line, 2);
				$interpreten[$interpret[0]] = $interpret;
			}
			fclose($file);
		}
		return $interpreten;
	}
	
	function getBlacklistedTracks() {
		$tracks = array();
		$file = fopen(dirname(__FILE__) . '/blacklists/tracks', 'r');
		if ($file) {
			while (($line = fgets($file)) !== false) {
				$line = substr($line, 0, strlen($line) - 1);
				$track = explode("\t", $line, 4);
				$tracks[$track[0]] = $track;
			}
			fclose($file);
		}
		return $tracks;
	}
	
	function wish($track_id) {
		$interpreten = getBlacklistedInterprets();
		$tracks = getBlacklistedTracks();
		
		if (isset($tracks[$track_id])) {
			return 1;
		} else {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/tracks/" . urlencode($track_id));
			$response = curl_exec_access_token($ch);
			if (isset($response['id'])) {
				$ok = true;
				foreach($response['artists'] as $artist) {
					if (isset($interpreten[$artist['id']])) {
						$ok = false;
						break;
					}
				}
				if ($ok) {
					if (inPlaylist('cagrrj', PL_WISH, $track_id)) {
						return 2;
					} else {
						if (spotify_add(SP_USERNAME, PL_WISH, $track_id)) {
							spotify_add(SP_USERNAME, PL_SAVED, $track_id);
							return 0;
						} else {
							return 3;
						}
					}
				} else {
					return 1;
				}
			} else {
				return 3;
			}
		}
	}
	
?>