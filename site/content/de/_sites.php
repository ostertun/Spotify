<?php
	
	$nav = array(
		array(0, 'W&uuml;nsch Dir Was!', 'wish'),
		array(0, 'Wunschliste', 'list'),
		array(0, 'Bisher gespielt', '../played')
	);
	
	if ($isAdmin) {
		array_push($nav, array(0, 'Blacklist', 'blacklist'));
	} else {
		array_push($nav, array(0, 'Admin', 'entercode'));
	}
	
	$headings = array(
		'entercode'   => array(0, 'Partycode eingeben'),
		'wish'        => array(0, 'W&uuml;nsch Dir was!'),
		'list'        => array(0, 'Wunschliste'),
		'played'      => array(0, 'Bisher gespielte Songs')
	);
	
	if ($isAdmin) {
		$headings['blacklist'] = array(0, 'Blacklist');
	}
	
	$modules = array(
		array(
			array(),  // show only on this sites
			array(/*''*/),  // do not show on this sites
			0, // min. perm to show
			'module_current' // function name of module (see below)
		)
	);
	
	function module_current($site) {
		echo '<iframe src="' . SERVER_ADDR . '/api/currentImage.php" scrolling="no" style="border: 0;" onload="resizeIframe(this)"></iframe>';
	}
	
?>
