<?php
	
	/*
		
		Logging Support & Error Handling
		--------------------------------
		
	*/
	
	function sendLog($type, $tag, $message) {
		file_put_contents(__DIR__ . '/log.txt', date('Y-m-d H:i:s') . "\t" . $type . "\t" . $tag . "\t" . $message, FILE_APPEND);
	}
	
	function logE($tag, $msg) {
		sendLog('error', $tag, $msg);
	}
	
	function logW($tag, $msg) {
		sendLog('warning', $tag, $msg);
	}
	
	function LogI($tag, $msg) {
		sendLog('info', $tag, $msg);
	}
	
	function myErrorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
		$type = '';
		switch ($errno) {
			case E_ERROR:
				$type = 'Error';
				break;
			case E_WARNING:
				$type = 'Warning';
				break;
			case E_PARSE:
				$type = 'Parse Error';
				break;
			case E_NOTICE:
				$type = 'Notice';
				break;
			case E_CORE_ERROR:
				$type = 'Core Error';
				break;
			case E_CORE_WARNING:
				$type = 'Core Warning';
				break;
			case E_COMPILE_ERROR:
				$type = 'Compile Error';
				break;
			case E_COMPILE_WARNING:
				$type = 'Compile Warning';
				break;
			case E_USER_ERROR:
				$type = 'User Error';
				break;
			case E_USER_WARNING:
				$type = 'User Warning';
				break;
			case E_USER_NOTICE:
				$type = 'User Notice';
				break;
			case E_STRICT:
				$type = 'Strict';
				break;
			case E_RECOVERABLE_ERROR:
				$type = 'Recoverable Error';
				break;
			case E_DEPRECATED:
				$type = 'Deprecated';
				break;
			case E_USER_DEPRECATED:
				$type = 'User Deprecated';
				break;
			default:
				$type = 'Unknown Error (Code ' . $errno . ')';
				break;
		}
		logE($type, $errstr . ' in ' . $errfile . ' on line ' . $errline);
		return false;
	}
	$alter_error_handler = set_error_handler('myErrorHandler');
	
?>