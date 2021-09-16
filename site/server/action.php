<?php

	require_once(dirname(__FILE__) . '/../../api/access.php');

	$interpreten = getBlacklistedInterprets();
	$tracks = getBlacklistedTracks();

	$redirect = '';

	switch(ACTION) {

		case 'entercode':
			if (isset($_POST['partycode']) and (($_POST['partycode'] == PARTY_CODE) or ($_POST['partycode'] == ADMIN_CODE))) {
				setcookie('partycode', $_POST['partycode'], time() + 10 * 60 * 60, '/'); // 10h
			} else {
				fail(STRING_INVALID_REQUEST);
				$redirect = 'entercode';
			}
			break;

		case 'wish':
			if (isset($request[0])) {
				switch (wish($request[0])) {
					case 0:
						success(SUC);
						break;
					case 1:
						fail('Dieser Song wurde vom Veranstalter blockiert.');
						break;
					case 2:
						fail('Dieser Song befindet sich bereits in der Wunschliste.');
						break;
					case 3:
						fail('Dieser Song ist leider nicht in Deutschland spielbar.');
						break;
					case 4:
					default:
						fail(STRING_UNKNOWN_ERR);
						break;
				}
			} else {
				fail(STRING_INVALID_REQUEST);
			}
			break;

		case 'black_lock_int':
			if (isset($request[0]) and ($isAdmin)) {
				if (!isset($interpreten[$request[0]])) {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/artists/" . urlencode($request[0]));
					$response = curl_exec_access_token($ch);
					if (isset($response['id'])) {
						file_put_contents('site/server/blacklists/interpreten', $response['id'] . "\t" . $response['name'] . "\n", FILE_APPEND);

						// *** REMOVE ALL TRACKS WITH THIS INTERPRET
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/users/" . SP_USERNAME . "/playlists/" . PL_WISH . "/tracks");
						$response2 = curl_exec_access_token($ch);
						if (isset($response2['items'])) {
							foreach ($response2['items'] as $key => $value) {
								$ok = true;
								foreach($value['track']['artists'] as $artist) {
									if ($artist['id'] == $response['id']) {
										$ok = false;
										break;
									}
								}
								if (!$ok) {
									spotify_remove(SP_USERNAME, PL_WISH, $value['track']['id']);
								}
							}
						}
						// *** END OF REMOVE

						success(SUC);
					} else {
						fail(STRING_INVALID_REQUEST);
					}
				} else {
					fail('Bereits gesperrt.');
				}
				$redirect = 'blacklist';
			} else {
				fail(STRING_INVALID_REQUEST);
			}
			break;

		case 'black_unlock_int':
			if (isset($request[0]) and ($isAdmin)) {
				if (isset($interpreten[$request[0]])) {
					$output = '';
					foreach ($interpreten as $interpret) {
						if ($interpret[0] != $request[0]) {
							$output .= $interpret[0] . "\t" . $interpret[1] . "\n";
						}
					}
					file_put_contents('site/server/blacklists/interpreten', $output);
					success(SUC);
				} else {
					fail('Nicht gesperrt.');
				}
				$redirect = 'blacklist';
			} else {
				fail(STRING_INVALID_REQUEST);
			}
			break;

		case 'black_lock_tra':
			if (isset($request[0]) and ($isAdmin)) {
				if (!isset($tracks[$request[0]])) {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/tracks/" . urlencode($request[0]));
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
						file_put_contents('site/server/blacklists/tracks', $response['id'] . "\t" . $response['name'] . "\t" . $art . "\t" . $response['album']['name'] . "\n", FILE_APPEND);
						spotify_remove(SP_USERNAME, PL_WISH, $response['id']);
						success(SUC);
					} else {
						fail(STRING_INVALID_REQUEST);
					}
				} else {
					fail('Bereits gesperrt.');
				}
				$redirect = 'blacklist';
			} else {
				fail(STRING_INVALID_REQUEST);
			}
			break;

		case 'black_unlock_tra':
			if (isset($request[0]) and ($isAdmin)) {
				if (isset($tracks[$request[0]])) {
					$output = '';
					foreach ($tracks as $track) {
						if ($track[0] != $request[0]) {
							$output .= $track[0] . "\t" . $track[1] . "\t" . $track[2] . "\t" . $track[3] . "\n";
						}
					}
					file_put_contents('site/server/blacklists/tracks', $output);
					success(SUC);
				} else {
					fail('Nicht gesperrt.');
				}
				$redirect = 'blacklist';
			} else {
				fail(STRING_INVALID_REQUEST);
			}
			break;

		case 'clear_played':
			if ($isAdmin) {
				file_put_contents(__DIR__ . '/playlist/tracks', '');
				$redirect = 'played';
				success(SUC);
			} else {
				fail(STRING_INVALID_REQUEST);
			}
			break;

		default: // action not found
			$redirect = null;
			break;

	}

?>
