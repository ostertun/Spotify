<?php

	require_once(__DIR__ . '/access.php');

	$showLinked = isset($_GET['showlinked']);
	$remove = isset($_GET['remove']);

	if ($showLinked) echo '<a href="?">Hide linked songs</a>';
	else echo '<a href="?showlinked">Show linked songs</a>';
	if ($remove) echo ' <a href="?">Normal view</a>';
	else echo ' <a href="?remove">Remove unplayable songs</a>';
	echo "<br>\n<br>\n";

	$local = 0;
	$unplayable = 0;
	$linked = 0;
	$duration = 0;
	$tracks = getPlaylist(SP_USERNAME, PL_POOL, -1, 0, true);
	if (($tracks !== false) and (count($tracks) > 0)) {
		for ($i = 0; $i < count($tracks); $i++) {
			$duration += $tracks[$i]['track']['duration_ms'];
			if ($tracks[$i]['track']['is_local']) {
				$local++;
				echo "Song #" . ($offset + $i + 1) . " is local<br>\n";
				echo $tracks[$i]['track']['name'] . "<br>\n<br>\n";
			} elseif (!$tracks[$i]['track']['is_playable']) {
				$unplayable++;
				echo "Song #" . ($offset + $i + 1) . " is unplayable<br>\n";
				echo $tracks[$i]['track']['name'] . "<br>\n";
				if ($remove) {
					if (spotify_remove(SP_USERNAME, PL_POOL, $tracks[$i]['track']['id']))
						echo "Removed<br>\n";
					else
						echo "Can not remove<br>\n";
				}
				echo "<br>\n";
			} elseif (isset($tracks[$i]['track']['linked_from'])) {
				$linked++;
				if ($showLinked) {
					echo "Song #" . ($offset + $i + 1) . " is linked (" . $tracks[$i]['track']['linked_from']['id'] . " => " . $tracks[$i]['track']['id'] . ")<br>\n";
					echo $tracks[$i]['track']['name'] . "<br>\n<br>\n";
				}
			}
		}
		$offset += count($tracks);
	}

	$duration = floor($duration / 1000); $duration_s = $duration % 60;
	$duration = floor(($duration - $duration_s) / 60); $duration_m = $duration % 60;
	$duration = floor(($duration - $duration_m) / 60); $duration_h = $duration;
	echo "$local local, $unplayable unplayable and $linked linked songs found (total: $offset, " . sprintf("%d:%02d:%02d", $duration_h, $duration_m, $duration_s) . " h)<br>\n";

?>
