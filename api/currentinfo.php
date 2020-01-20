<html>
	<head>
		<meta http-equiv="refresh" content="15; URL=currentinfo.php<?php if (isset($_GET['dark'])) { echo '?dark'; } ?>" />
	</head>
	<body<?php if (isset($_GET['dark'])) { echo ' style="color: white;"'; } ?>>
		<div align="center" style="white-space: no-wrap;">
			<b>Jetzt l&auml;uft:</b><br>
<?php
	
	require_once(dirname(__FILE__) . '/access.php');
	
	$song = spotify_getsong();
	if (($song !== false) and (isset($song['item']))) {
		$trackid = $song['item']['id'];
		
		$track = htmlentities(utf8_decode($song['item']['name'])) . '<br>';
		$first = true;
		foreach ($song['item']['artists'] as $artist) {
			if ($first) {
				$track .= '<i>' . htmlentities(utf8_decode($artist['name'])) . '</i>';
				$first = false;
			} else {
				$track .= ', <i>' . htmlentities(utf8_decode($artist['name'])) . '</i>';
			}
		}
		
		$year = substr($song['item']['album']['release_date'], 0, 4);
		$images = $song['item']['album']['images'];
		$size = 0;
		foreach ($images as $image) {
			if ($image['height'] > $size) {
				$size = $image['height'];
				$icon = $image['url'];
			}
		}
		
		$features = spotify_getfeatures($trackid);
		
		echo '<table border="0"><tr>';
		
		if (isset($icon)) {
			echo '<td rowspan="5"><img style="height: 150px; margin-right: 20px; box-shadow: 0 0 5px 2px ' . (isset($_GET['dark']) ? 'white' : 'grey') . ';" src="' . $icon . '" /></td>';
		}
		
		echo '<td colspan="3"><div align="center">' . $track . '</div></td></tr>';
		
		if ($features !== false) {
			echo '<tr>';
				echo '<td><div align="right">Jahr:&nbsp;</div></td>';
				echo '<td>&nbsp;<progress value="' . ($year - date('Y') + 50) . '" max="50"></progress>&nbsp;</td>';
				echo '<td>&nbsp;' . $year . '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td><div align="right">Tanzbarkeit:&nbsp;</div></td>';
				echo '<td>&nbsp;<progress value="' . round($features['danceability'] * 100) . '" max="100"></progress>&nbsp;</td>';
				echo '<td>&nbsp;' . ($features['danceability'] * 100) . '%</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td><div align="right">Energie:&nbsp;</div></td>';
				echo '<td>&nbsp;<progress value="' . round($features['energy'] * 100) . '" max="100"></progress>&nbsp;</td>';
				echo '<td>&nbsp;' . ($features['energy'] * 100) . '%</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td><div align="right">Tempo:&nbsp;</div></td>';
				echo '<td>&nbsp;<progress value="' . round($features['tempo'] - 70) . '" max="80"></progress>&nbsp;</td>';
				echo '<td>&nbsp;' . round($features['tempo']) . ' BPM</td>';
			echo '</tr>';
		} else {
			echo '<tr><td rowspan="4" colspan="3"><div align="center"><i>Keine Eigenschaften verf&uuml;gbar.</i></div></td></tr>';
		}
		
		echo '</tr></table>';
		
	} else {
		echo '--- NICHTS ---';
	}
	
?>
		</div>
	</body>
</html>