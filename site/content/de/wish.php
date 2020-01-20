<?php
	
	require_once(dirname(__FILE__) . '/../../../api/access.php');
	
	echo '<p>';
	echo '<form action="wish" method="get">';
	echo '<input style="width: calc(80% - 10px);" type="text" name="search" value="' . (isset($_GET['search']) ? $_GET['search'] : '') . '" /> ';
	echo '<button style="width: 20%;">Suchen</button>';
	echo '</form>';
	echo '</p>';
	
	if (isset($_GET['search'])) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?limit=20&q=" . urlencode($_GET['search']) . "&type=track");
		$response = curl_exec_access_token($ch);
		
		if (isset($response['error'])) {
			echo 'Error ' . $response['error']['status'] . ': ' . $response['error']['message'];
		} else {
			if (isset($response['tracks']['items']) and (count($response['tracks']['items']) > 0)) {
				echo '<div class="overflow"><table border="0">';
				
				echo '<tr bgcolor="#999999">';
				echo '<th style="padding: 5px 8px 5px 8px;">Titel</th>';
				echo '<th style="padding: 5px 8px 5px 8px;">Interpret</th>';
				echo '<th style="padding: 5px 8px 5px 8px;">Album</th>';
				echo '<th style="padding: 5px 8px 5px 8px;">Eigenschaften</th>';
				echo '<th></th>';
				echo '</tr>';
				
				foreach ($response['tracks']['items'] as $key => $value) {
					$features = spotify_getfeatures($value['id']);
					$link = LINK_PRE . 'action/wish/' . $value['id'];
					if ($key % 2 == 0) {
						echo '<tr bgcolor="#dddddd">';
					} else {
						echo '<tr bgcolor="#bbbbbb">';
					}
					echo '<td style="padding: 5px 8px 5px 8px;">' . $value['name'] . '</td>';
					echo '<td style="padding: 5px 8px 5px 8px;">';
					$first = true;
					foreach($value['artists'] as $artist) {
						if ($first) {
							echo $artist['name'];
							$first = false;
						} else {
							echo ', ' . $artist['name'];
						}
					}
					echo '</td>';
					echo '<td style="padding: 5px 8px 5px 8px;">' . $value['album']['name'] . '</td>';
					$dur_sec = round($value['duration_ms'] / 1000);
					$duration = floor($dur_sec / 60) . ':' . ((($dur_sec % 60) < 10) ? '0' : '') . ($dur_sec % 60);
					echo '<td style="padding: 5px 8px 5px 8px;">Tanzbar: ' . ($features['danceability'] * 100) . '%<br>' . round($features['tempo']) . ' BPM<br>' . $duration . ' Minuten</td>';
					echo '<td style="padding: 5px 8px 5px 8px;"><form action="' . $link . '" method="post"><button>W&uuml;nschen</button></form></td>';
					echo '</tr>';
				}
				
				echo '</table></div>';
			} else {
				echo '<p>Keine Songs gefunden</p>';
			}
		}
	}
	
?>