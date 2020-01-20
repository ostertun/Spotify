<?php
	
	require_once(dirname(__FILE__) . '/access.php');
	
	if (isset($_GET['PL'])) {
		switch ($_GET['PL']) {
			case 'WISH':  echo PL_WISH;  break;
			case 'WDW':   echo PL_WDW;   break;
			case 'SAVED': echo PL_SAVED; break;
			case 'POOL':  echo PL_POOL;  break;
		}
	}
	
?>