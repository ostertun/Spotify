<?php
	
	$keys = array(
		'C',
		'C#',
		'D',
		'D#',
		'E',
		'F',
		'F#',
		'G',
		'G#',
		'A',
		'B',
		'H'
	);
	
	require_once(dirname(__FILE__) . '/access.php');
	
	$song = spotify_getsong();
	if (($song !== false) and (isset($song['item']))) {
		$trackid = $song['item']['id'];
		$trackname = $song['item']['name'];
	}
	
	$features = false;
	if (isset($trackid)) {
		$features = spotify_getfeatures($trackid);
	}
	
	if ($features !== false) {
		echo '<b>' . htmlentities($trackname) . '</b><br>';
		echo 'Tonart: ' . $keys[$features['key']] . ' ';
		if ($features['mode']) {
			echo 'Dur<br>';
		} else {
			echo 'Moll<br>';
		}
		echo 'Akustik: ' . ($features['acousticness'] * 100) . '%<br>';
		echo 'Tanzbarkeit: ' . ($features['danceability'] * 100) . '%<br>';
		echo 'Energie: ' . ($features['energy'] * 100) . '%<br>';
		echo 'Instrumentalit&auml;t: ' . ($features['instrumentalness'] * 100) . '%<br>';
		echo 'Lebhaftigkeit: ' . ($features['liveness'] * 100) . '%<br>';
		echo 'Redlichkeit: ' . ($features['speechiness'] * 100) . '%<br>';
		echo 'Wertigkeit: ' . ($features['valence'] * 100) . '%<br>';
		echo 'Lautst&auml;rke: ' . $features['loudness'] . 'dB<br>';
		echo 'Tempo: ' . $features['tempo'] . 'BPM<br>';
		
	}
	
?>