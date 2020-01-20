<?php
	
	/*
	 * Call this script every minute
	 */
	
	function call() {
		include(__DIR__ . '/doWishlistUpdate.php');
	}
	
	call();
	sleep(9);
	call();
	sleep(9);
	call();
	sleep(9);
	call();
	sleep(9);
	call();
	sleep(9);
	call();
	
?>