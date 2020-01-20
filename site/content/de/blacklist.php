<?php
	
	require_once(dirname(__FILE__) . '/../../../api/access.php');
	
	$interpreten = array();
	$file = fopen('site/server/blacklists/interpreten', 'r');
	if ($file) {
		while (($line = fgets($file)) !== false) {
			$line = substr($line, 0, strlen($line) - 1);
			$interpret = explode("\t", $line, 2);
			$interpreten[$interpret[0]] = $interpret;
		}
		fclose($file);
	}
	
	$tracks = array();
	$file = fopen('site/server/blacklists/tracks', 'r');
	if ($file) {
		while (($line = fgets($file)) !== false) {
			$line = substr($line, 0, strlen($line) - 1);
			$track = explode("\t", $line, 4);
			$tracks[$track[0]] = $track;
		}
		fclose($file);
	}
	
?>

<h1>Blacklist</h1>
<p>Hier gelistete Tracks oder Interpreten werden nicht in die Playlist übernommen.</p>



<h2>Interpreten</h2>
<h3>Interpreten suchen</h3>
<form action="<?php echo LINK_PRE; ?>blacklist" method="get">
<label>Interpret suchen: </label>
<input type="text" name="int_search" value="<?php if (isset($_GET['int_search'])) { echo $_GET['int_search']; } ?>" />
<button>Suchen</button>
</form>
<?php
	if (isset($_GET['int_search']) and ($_GET['int_search'] != '')) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?limit=20&q=" . urlencode($_GET['int_search']) . "&type=artist");
		$response = curl_exec_access_token($ch);
		
		if (isset($response['error'])) {
			echo 'Error ' . $response['error']['status'] . ': ' . $response['error']['message'];
		} else {
			if (isset($response['artists']['items']) and (count($response['artists']['items']) > 0)) {
				echo '<div class="overflow"><table border="0">';
				
				echo '<tr bgcolor="#999999">';
				echo '<th style="padding: 5px 8px 5px 8px;">Name</th>';
				echo '<th></th>';
				echo '</tr>';
				
				foreach ($response['artists']['items'] as $key => $value) {
					$link = LINK_PRE . 'action/black_lock_int/' . $value['id'];
					if ($key % 2 == 0) {
						echo '<tr bgcolor="#dddddd">';
					} else {
						echo '<tr bgcolor="#bbbbbb">';
					}
					echo '<td style="padding: 5px 8px 5px 8px;">' . $value['name'] . '</td>';
					echo '<td style="padding: 5px 8px 5px 8px;"><form action="' . $link . '" method="post"><button>Sperren</button></form></td>';
					echo '</tr>';
				}
				
				echo '</table></div>';
			} else {
				echo '<p>Keine Interpreten gefunden</p>';
			}
		}
	}
?>

<h3>Gesperrte Interpreten</h3>
<div class="overflow"><table border="0">
<tr bgcolor="#999999">
<th style="padding: 5px 8px 5px 8px;">Name</th>
<th></th>
</tr>
<?php
	$i = 0;
	foreach ($interpreten as $id => $interpret) {
		$link = LINK_PRE . 'action/black_unlock_int/' . $id;
		if ($i % 2 == 0) {
			echo '<tr bgcolor="#dddddd">';
		} else {
			echo '<tr bgcolor="#bbbbbb">';
		}
		echo '<td style="padding: 5px 8px 5px 8px;">' . $interpret[1] . '</td>';
		echo '<td style="padding: 5px 8px 5px 8px;"><form action="' . $link . '" method="post"><button>Entsperren</button></form></td>';
		echo '</tr>';
		$i ++;
	}
?>
</table></div>

<hr>

<h2>Tracks</h2>
<h3>Tracks suchen</h3>
<form action="<?php echo LINK_PRE; ?>blacklist" method="get">
<label>Track suchen: </label>
<input type="text" name="tra_search" value="<?php if (isset($_GET['tra_search'])) { echo $_GET['tra_search']; } ?>" />
<button>Suchen</button>
</form>
<?php
	if (isset($_GET['tra_search']) and ($_GET['tra_search'] != '')) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?limit=20&q=" . urlencode($_GET['tra_search']) . "&type=track");
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
				echo '<th></th>';
				echo '</tr>';
				
				foreach ($response['tracks']['items'] as $key => $value) {
					$link = LINK_PRE . 'action/black_lock_tra/' . $value['id'];
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
					echo '<td style="padding: 5px 8px 5px 8px;"><form action="' . $link . '" method="post"><button>Sperren</button></form></td>';
					echo '</tr>';
				}
				
				echo '</table></div>';
			} else {
				echo '<p>Keine Tracks gefunden</p>';
			}
		}
	}
?>

<h3>Gesperrte Tracks</h3>
<div class="overflow"><table border="0">
<tr bgcolor="#999999">
<th style="padding: 5px 8px 5px 8px;">Titel</th>
<th style="padding: 5px 8px 5px 8px;">Interpret</th>
<th style="padding: 5px 8px 5px 8px;">Album</th>
<th></th>
</tr>
<?php
	$i = 0;
	foreach ($tracks as $id => $track) {
		$link = LINK_PRE . 'action/black_unlock_tra/' . $id;
		if ($i % 2 == 0) {
			echo '<tr bgcolor="#dddddd">';
		} else {
			echo '<tr bgcolor="#bbbbbb">';
		}
		echo '<td style="padding: 5px 8px 5px 8px;">' . $track[1] . '</td>';
		echo '<td style="padding: 5px 8px 5px 8px;">' . $track[2] . '</td>';
		echo '<td style="padding: 5px 8px 5px 8px;">' . $track[3] . '</td>';
		echo '<td style="padding: 5px 8px 5px 8px;"><form action="' . $link . '" method="post"><button>Entsperren</button></form></td>';
		echo '</tr>';
		$i ++;
	}
?>
</table></div>