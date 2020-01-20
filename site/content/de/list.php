<?php
	
	require_once(dirname(__FILE__) . '/../../../api/access.php');
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/users/cagrrj/playlists/" . PL_WISH . "/tracks?limit=50");
	$response = curl_exec_access_token($ch);
	
	$wish = '';
	if (isset($response['error'])) {
		$wish = 'Error ' . $response['error']['status'] . ': ' . $response['error']['message'];
	} else {
		$wish = '<div class="overflow"><table border="0">';
		if (isset($response['items'])) {
			foreach ($response['items'] as $key => $value) {
				$link = LINK_PRE . 'action/black_lock_tra/' . $value['track']['id'];
				if ($key % 2 == 0) {
					$wish .= '<tr bgcolor="#bbbbbb">';
				} else {
					$wish .= '<tr bgcolor="#dddddd">';
				}
				$wish .= '<td style="padding: 5px 8px 5px 8px;"><div align="right"><b>' . ($key + 1) . '.</b></div></td>';
				$wish .= '<td style="padding: 5px 8px 5px 8px;">' . htmlentities(utf8_decode($value['track']['name'])) . '</td>';
				$wish .= '<td style="padding: 5px 8px 5px 8px;">';
				$first = true;
				foreach($value['track']['artists'] as $artist) {
					if ($first) {
						$wish .= '<i>' . htmlentities(utf8_decode($artist['name'])) . '</i>';
						$first = false;
					} else {
						$wish .= ', <i>' . htmlentities(utf8_decode($artist['name'])) . '</i>';
					}
				}
				$wish .= '</td>';
				if ($isAdmin) {
					$wish .= '<td style="padding: 5px 8px 5px 8px;"><form action="' . $link . '" method="post"><button>Sperren</button></form></td>';
				}
				$wish .= '</tr>';
			}
		}
		$wish .= '</table></div>';
	}
?>

<div align="center" style="white-space: nowrap;">
<b>Wunschliste (Top 50):</b><br>
<?php
	echo $wish;
?>
</div>