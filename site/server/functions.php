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
	
	function getPlayedSongs() {
		$tracks = array();
		$file = fopen(dirname(__FILE__) . '/playlist/tracks', 'r');
		if ($file) {
			while (($line = fgets($file)) !== false) {
				$line = substr($line, 0, strlen($line) - 1);
				$track = explode("\t", $line, 5);
				$tracks[] = [
					'id' => $track[0],
					'title' => $track[1],
					'artists' => $track[2],
					'album' => $track[3],
					'time' => $track[4]
				];
			}
			fclose($file);
		}
		return $tracks;
	}
	
	function trackSong($id) {
		$lastCurrent = file_get_contents(__DIR__ . '/playlist/current');
		if ($id != $lastCurrent) {
			file_put_contents(__DIR__ . '/playlist/current', $id);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/tracks/" . urlencode($id));
			$response = curl_exec_access_token($ch);
			if (isset($response['id'])) {
				$art = '';
				$first = true;
				foreach($response['artists'] as $artist) {
					if ($first) {
						$art .= $artist['name'];
						$first = false;
					} else {
						$art .= ', ' . $artist['name'];
					}
				}
				$sizeSm = 1000000000000000;
				$sizeLa = 0;
				foreach($response['album']['images'] as $image) {
					if ($image['height'] < $sizeSm) {
						$sizeSm = $image['height'];
						$iconSm = $image['url'];
					}
					if ($image['height'] > $sizeLa) {
						$sizeLa = $image['height'];
						$iconLa = $image['url'];
					}
				}
				file_put_contents(__DIR__ . '/playlist/tracks', $response['id'] . "\t" . $response['name'] . "\t" . $art . "\t" . $response['album']['name'] . "\t" . time() . (isset($iconLa) ? "\t" . $iconLa . "\t" . $iconSm : '') . "\n", FILE_APPEND);
			}
		}
	}
	
	/**
	 * return 0: ok
	 * return 1: black listed
	 * return 2: already wished
	 * return 3: unkown error
	 */
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