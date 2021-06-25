<?php
	
	$tracks = getPlayedSongs();
	
	array_multisort(array_column($tracks, 'time'), SORT_DESC, $tracks);
	
?>

<div align="center" style="white-space: nowrap;">
<?php
	if ($isAdmin) {
		echo '<a href="' . LINK_PRE . 'action/clear_played">Liste leeren</a><br>';
	}
?>
<b>Bisher gespielte Songs:</b><br>
<div class="overflow"><table border="0">
<?php
	$day = date('D, d.m.Y');
	foreach ($tracks as $key => $track) {
		$date = date('D, d.m.Y', $track['time']);
		if ($day != $date) {
			$day = $date;
			echo '<tr><td colspan="4" style="padding: 5px 8px 5px 8px;" align="center">' . $day . '</td></tr>';
		}
		if ($key % 2 == 0) {
			echo '<tr bgcolor="#bbbbbb">';
		} else {
			echo '<tr bgcolor="#dddddd">';
		}
		echo '<td style="padding: 5px 8px 5px 8px;">' . date('H:i', $track['time']) . '</td>';
		echo '<td style="padding: 5px 8px 5px 8px;">' . htmlentities($track['title'], ENT_COMPAT, 'utf-8') . '</td>';
		echo '<td style="padding: 5px 8px 5px 8px;">' . htmlentities($track['artists'], ENT_COMPAT, 'utf-8') . '</td>';
		echo '<td style="padding: 5px 8px 5px 8px;"><a target="_blank" href="https://open.spotify.com/track/' . $track['id'] . '">Spotify</a></td>';
		echo '</tr>';
	}
?>
</table></div>
</div>