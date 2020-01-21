<?php
	
	/**
	 * Script to get a spotify web api refresh token
	 *
	 * Author: Lukas Westholt
	 */
	
	$redirect_uri = strtok("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", '?');
	if (isset($_GET['send']) && $_GET['send'] == "true") {
		require_once(__DIR__ . '/../api/access.php');
		
		function sanitize($s) {
			return htmlspecialchars($s);
		}
		$scope = implode(" ", array_map('sanitize', array_keys($_POST)));
		
		$newURL = "https://accounts.spotify.com/authorize?client_id=" . rawurlencode(CLIENT_ID);
		$newURL .= "&response_type=code";
		$newURL .= "&redirect_uri=" . rawurlencode($redirect_uri);
		$newURL .= "&scope=" . rawurlencode($scope);
		header('Location: '.$newURL);
		exit;
	}
	if (isset($_GET['code'])) {
		require_once(__DIR__ . '/../api/access.php');
		$code = $_GET['code'];
		$authentication = base64_encode(CLIENT_ID . ":" . CLIENT_SECRET);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://accounts.spotify.com/api/token");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		
		$headers = array(
		'Content-Type:application/x-www-form-urlencoded',
		'Authorization: Basic '. $authentication
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=authorization_code&code=' . $code . '&redirect_uri=' . $redirect_uri);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);		
		
		$response = json_decode($output, true);
		foreach($response as $key => $value) {
			echo $key . " = " . $value . "<br>";
		}
	} else {
		require_once(__DIR__ . '/form.php');
		exit;
	}
	
?>