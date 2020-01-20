<?php
	
	date_default_timezone_set('Europe/Berlin');
	
	$LANGUAGE_NAMES = array(
		'de' => 'Deutsch',
		'en' => 'English',
		'es' => 'Espanol',
		'fr' => 'Francais',
		'it' => 'Italiano',
		'nl' => 'Nederlands',
		'pl' => 'Polsk',
		'da' => 'Dansk'
	);
	
	require_once('server/server/const.php');
	require_once('const/server/log.php');
	
	$sitefound = false;
	if (isset($_GET['request'])) {
		$request = explode('/', $_GET['request']);
		if (($request != false) and (count($request) >= 1)) {
			if (isset($LANGUAGE_NAMES[$request[0]])) {
				$lang = array_shift($request);
			}
			if (count($request) >= 1) {
				if (!isset($lang) or (!file_exists('site/content/' . $lang))) {
					$dir = 'site/content';
					if (is_dir($dir)) {
						if ($handle = opendir($dir)) {
							while (($file = readdir($handle)) !== false) {
								if ((filetype($dir . '/' . $file) == 'dir') and ($file != '.') and ($file != '..')) {
									if (isset($LANGUAGE_NAMES[$file])) {
										header('Location: ' . SERVER_ADDR . $file);
										exit;
									}
								}
							}
							closedir($handle);
						}
					}
				} else {
					define('LANG', $lang);
					unset($lang);
					if (count($request) >= 1) {
						$site = array_shift($request);
					} else {
						$site = '';
					}
					$sitefound = true;
				}
			} else {
				define('LANG', $lang);
				unset($lang);
				$site = '';
				$sitefound = true;
			}
		}
	}
	if (!$sitefound) {
		header('Location: ' . SERVER_ADDR . 'de');
		exit;
	}
	
	if (!isset($_COOKIE['firstvisit'])) {
		define('FIRSTVISIT', true);
	} else {
		define('FIRSTVISIT', false);
	}
	setcookie('firstvisit', 'no', time() + 30 * 24 * 60 * 60, '/');
	
	define('LINK_PRE', SERVER_ADDR . LANG . '/');
	
	if (isset($_GET['logmsg'])) {
		$logmsg = unserialize($_GET['logmsg']);
	} else {
		$logmsg = array();
	}
	
	function fail($msg) {
		global $logmsg;
		array_push($logmsg, array(0, $msg));
	}
	
	function success($msg) {
		global $logmsg;
		array_push($logmsg, array(1, $msg));
	}
	
	function info($msg) {
		global $logmsg;
		array_push($logmsg, array(2, $msg));
	}
	
	require_once('const/server/language.php');
	require_once('const/server/strings/' . LANG . '.php');
	
	require_once('site/server/const.php');
	require_once('site/server/functions.php');
	
	if ((($site != 'entercode') and (($site != 'action') or ($request[0] != 'entercode'))) and ((!isset($_COOKIE['partycode'])) or (($_COOKIE['partycode'] != PARTY_CODE) and ($_COOKIE['partycode'] != ADMIN_CODE)))) {
		header('Location: ' . SERVER_ADDR . 'de/entercode');
		exit;
	}
	$isAdmin = ((isset($_COOKIE['partycode'])) and ($_COOKIE['partycode'] == ADMIN_CODE));
	
	require_once('site/content/' . LANG . '/_sites.php');
	require_once('site/content/' . LANG . '/_strings.php');
	
	session_start();
	
	if ($site == 'action') {
		define('ACTION', array_shift($request));
		$getstr = '';
		
		$redirect = '';
		include('const/server/action.php');
		
		if ($redirect === null) {
			$redirect = '';
			include('site/server/action.php');
		}
		
		if ($redirect === null) {
			$redirect = '';
			fail(STRING_INVALID_REQUEST);
		}
		
		header('Location: ' . LINK_PRE . $redirect . '?logmsg=' . serialize($logmsg) . '&' . $getstr);
		exit;
	}
	
?>