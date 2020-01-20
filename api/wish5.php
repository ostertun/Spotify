<?php
	
	require_once(dirname(__FILE__) . '/access.php');
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/users/cagrrj/playlists/" . PL_WISH . "/tracks?limit=5");
	$response = curl_exec_access_token($ch);
	
	$wish = '';
	if (isset($response['error'])) {
		$wish = 'Error ' . $response['error']['status'] . ': ' . $response['error']['message'];
	} else {
		$wish = '<table border="0">';
		if (isset($_GET['dark'])) {
			$color1 = '888888';
			$color2 = '666666';
		} else {
			$color1 = 'bbbbbb';
			$color2 = 'dddddd';
		}
		if (isset($response['items'])) {
			foreach ($response['items'] as $key => $value) {
				if ($key % 2 == 0) {
					$wish .= '<tr bgcolor="#' . $color1 . '">';
				} else {
					$wish .= '<tr bgcolor="#' . $color2 . '">';
				}
				$wish .= '<td style="padding: 5px 8px 5px 8px;"><div align="right"><b>' . ($key + 1) . '.</b></div></td>';
				$wish .= '<td style="padding: 5px 8px 5px 8px;">' . htmlentities($value['track']['name']) . '</td>';
				$wish .= '<td style="padding: 5px 8px 5px 8px;">';
				$first = true;
				foreach($value['track']['artists'] as $artist) {
					if ($first) {
						$wish .= '<i>' . htmlentities($artist['name']) . '</i>';
						$first = false;
					} else {
						$wish .= ', <i>' . htmlentities($artist['name']) . '</i>';
					}
				}
				$wish .= '</td>';
				$wish .= '</tr>';
			}
		}
		$wish .= '</table>';
	}
?>

<html>
	<head>
		<meta http-equiv="refresh" content="15; URL=wish5.php<?php if (isset($_GET['dark'])) { echo '?dark'; } ?>" />
	</head>
	<body<?php if (isset($_GET['dark'])) { echo ' style="color: white"'; } ?>>
		<div align="center" style="white-space: nowrap;">
		<b>Demn&auml;chst:</b><br>
		<?php
			echo $wish;
		?>
		</div>
	</body>
</html>