<?php
	
	require_once(dirname(__FILE__) . '/access.php');
	
	$song = spotify_getsong();
	$track = '--- NICHTS ---';
	if (($song !== false) and (isset($song['item']))) {
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
	}
	
?>

<html>
	<head>
		<meta http-equiv="refresh" content="15; URL=current.php" />
	</head>
	<body>
		<div align="center" style="white-space: no-wrap;">
		
		<b>Jetzt l&auml;uft:</b><br>
		<?php
			echo $track;
		?>
		</div>
	</body>
</html>