<?php
	
	$logmsg = array();
	
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
	
	if (isset($_REQUEST['track'])) {
		define('ACTION', 'wish');
		$request = array($_REQUEST['track']);
		require_once(dirname(__FILE__) . '/../site/server/action.php');
		echo serialize($logmsg);
	} else {
		echo 'No track given';
	}
	
?>