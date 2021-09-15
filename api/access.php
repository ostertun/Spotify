<?php

	require_once(dirname(__FILE__) . '/../server/server/const.php');
	require_once(dirname(__FILE__) . '/../const/server/log.php');
	require_once(dirname(__FILE__) . '/../site/server/const.php');

	function get_access_token() {
		return file_get_contents(dirname(__FILE__) . '/accesstoken');
	}

	function refresh_access_token() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://accounts.spotify.com/api/token");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=refresh_token&client_id=' . CLIENT_ID . '&client_secret=' . CLIENT_SECRET . '&refresh_token=' . REFRESH_TOKEN);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($output, true);
		if (isset($response['access_token'])) {
			file_put_contents(dirname(__FILE__) . '/accesstoken', $response['access_token']);
		}
	}

	function curl_exec_access_token($ch, $contentlen=0) {
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer " . get_access_token(), "Content-Length: " . $contentlen));
		$output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($httpcode == 401) {
			refresh_access_token();
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer " . get_access_token()));
			$output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}

		if (($httpcode != 200) and ($httpcode != 201)) {
			if (floor($httpcode / 100) != 2) {
				logE('Spotify Curl', 'HTTP ' . $httpcode . "\n" . $output);
			}
			$output = '{"httpcode":"' . $httpcode . '"}';
		}

		curl_close($ch);
		return json_decode($output, true);
	}

	function spotify_prev() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me/player/previous");
		curl_exec_access_token($ch);
	}

	function spotify_next() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me/player/next");
		curl_exec_access_token($ch);
	}

	function spotify_play() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me/player/play");
		curl_exec_access_token($ch);
	}

	function spotify_pause() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me/player/pause");
		curl_exec_access_token($ch);
	}

	function spotify_remove($username, $playlist, $trackid) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/users/" . $username . "/playlists/" . $playlist . "/tracks");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		$buf = '{ "tracks": [{ "uri": "spotify:track:' . $trackid . '" }] }';
		curl_setopt($ch, CURLOPT_POSTFIELDS, $buf);
		$response = curl_exec_access_token($ch, strlen($buf));
		if (isset($response['httpcode'])) {
			return false;
		} elseif (isset($response['error'])) {
			return false;
		} else {
			return true;
		}
	}

	function spotify_add($username, $playlist, $trackid) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/users/" . $username . "/playlists/" . $playlist . "/tracks" . "?uris=spotify:track:" . $trackid);
		curl_setopt($ch, CURLOPT_POST, 1);
		$response = curl_exec_access_token($ch);
		if (isset($response['httpcode'])) {
			return false;
		} elseif (isset($response['error'])) {
			return false;
		} else {
			return true;
		}
	}

	function spotify_add2queue($trackid) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me/player/queue" . "?uri=spotify:track:" . $trackid);
		curl_setopt($ch, CURLOPT_POST, 1);
		$response = curl_exec_access_token($ch);
		if (isset($response['httpcode']) && $response['httpcode'] == 204) {
			return spotify_add('cagrrj', PL_WISH, $trackid);
		} else {
			return false;
		}
	}

	function spotify_getsong() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me/player/currently-playing");
		$response = curl_exec_access_token($ch);
		if (isset($response['httpcode'])) {
			return false;
		} elseif (isset($response['error'])) {
			return false;
		} else {
			return $response;
		}
	}

	function spotify_getfeatures($trackid) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/audio-features/" . $trackid);
		$response = curl_exec_access_token($ch);
		if (isset($response['httpcode'])) {
			return false;
		} elseif (isset($response['error'])) {
			return false;
		} else {
			return $response;
		}
	}

	function getPlaylist($username, $playlist, $limit=-1, $offset=0) {
		if ($limit < 0) {
			$l = 100;
		} else {
			$l = min(100, $limit);
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/users/" . $username . "/playlists/" . $playlist . "/tracks?market=DE&limit=" . $l . "&offset=" . $offset);
		$response = curl_exec_access_token($ch);
		if (isset($response['error'])) {
			return false;
		} else {
			if (isset($response['items'])) {
				$tracks = array_values($response['items']);
				$total = $response['total'];
				if (($total > $offset + $l) and (($limit < 0) or ($limit > $l))) {
					$newLimit = ($limit < 0) ? -1 : $limit - $l;
					$newOffset = $offset + $l;
					$rest = getPlaylist($username, $playlist, $newLimit, $newOffset);
					return array_merge($tracks, $rest);
				} else {
					return $tracks;
				}
			}
		}
		return false;
	}

	function inPlaylist($username, $playlist, $trackid) {
		$tracks = getPlaylist($username, $playlist);
		if ($tracks !== false) {
			foreach ($tracks as $key => $value) {
				if ($value['track']['id'] == $trackid) {
					return true;
				}
			}
		}
		return false;
	}

?>
