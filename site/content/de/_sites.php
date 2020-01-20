<?php
	
	$nav = array(
		array(0, 'W&uuml;nsch Dir was!', 'wish'),
		array(0, 'Wunschliste', 'list')
	);
	
	if ($isAdmin) {
		array_push($nav, array(0, 'Blacklist', 'blacklist'));
	} else {
		array_push($nav, array(0, 'Admin', 'entercode'));
	}
	
	$headings = array(
		'entercode'   => array(0, 'Partycode eingeben'),
		'wish'        => array(0, 'W&uuml;nsch Dir was!'),
		'list'        => array(0, 'Wunschliste')
	);
	
	if ($isAdmin) {
		$headings['blacklist'] = array(0, 'Blacklist');
	}
	
	$modules = array(
		array(
			array(),  // show only on this sites
			array(''),  // do not show on this sites
			0, // min. perm to show
			'module_current' // function name of module (see below)
		)
	);
	
	function module_current($site) {
		echo '<iframe src="/api/current.php" scrolling="no" style="border: 0;" onload="resizeIframe(this)"></iframe>';
	}
	
?>