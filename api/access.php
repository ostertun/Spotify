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
	
	function inPlaylist ($username, $playlist, $trackid, $offset=0) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/users/" . $username . "/playlists/" . $playlist . "/tracks?limit=100&offset=" . $offset);
		$response = curl_exec_access_token($ch);
		if (isset($response['error'])) {
			return false;
		} else {
			if (isset($response['items'])) {
				foreach ($response['items'] as $key => $value) {
					if ($value['track']['id'] == $trackid) {
						return true;
					}
				}
			}
			if ($response['total'] > 99) {
				return inPlaylist($user, $playlist, $trackid, $offset + $response['total']);
			}
		}
		return false;
	}
	
?>