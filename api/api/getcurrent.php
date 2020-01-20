<?php
	
	/* Returns infos about the currently playing song
	 *
	 * Required REQUEST params:
	 *  ---
	 */
	
	require_once(__DIR__ . '/../access.php');
	
	$song = spotify_getsong();
	if (($song !== false) and (isset($song['item']))) {
		$trackid = $song['item']['id'];
		
		$track = ['id' => $trackid, 'name' => $song['item']['name'], 'artists' => [], 'artiststring' => ''];
		$first = true;
		foreach ($song['item']['artists'] as $artist) {
			$track['artists'][] = $artist['name'];
			if ($first) {
				$first = false;
			} else {
				$track['artiststring'] .= ', ';
			}
			$track['artiststring'] .= $artist['name'];
		}
		
		$track['year'] = substr($song['item']['album']['release_date'], 0, 4);
		
		$images = $song['item']['album']['images'];
		$size = 0;
		foreach ($images as $image) {
			if ($image['height'] > $size) {
				$size = $image['height'];
				$icon = $image['url'];
			}
		}
		$track['image'] = $icon;
		
		$track['features'] = spotify_getfeatures($trackid);
		
		echo json_encode($track);
	} else {
		echo 'OFF';
	}
	
?>