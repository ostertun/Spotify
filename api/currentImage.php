<?php
	
	require_once(dirname(__FILE__) . '/access.php');
	
	$song = spotify_getsong();
	$track = '--- NICHTS ---';
	if (($song !== false) and (isset($song['item']))) {
		$images = $song['item']['album']['images'];
		$size = 0;
		foreach ($images as $image) {
			if ($image['height'] > $size) {
				$size = $image['height'];
				$icon = $image['url'];
			}
		}
		if (isset($icon))
			$track = '<img style="height: 150px; margin: 10px; box-shadow: 0 0 5px 2px grey;" src="' . $icon . '" /><br>';
		$track .= htmlentities($song['item']['name']) . '<br>';
		$first = true;
		foreach ($song['item']['artists'] as $artist) {
			if ($first) {
				$track .= '<i>' . htmlentities($artist['name']) . '</i>';
				$first = false;
			} else {
				$track .= ', <i>' . htmlentities($artist['name']) . '</i>';
			}
		}
	}
	
?>

<html>
	<head>
		<meta http-equiv="refresh" content="15; URL=currentImage.php" />
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