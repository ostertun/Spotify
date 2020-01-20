<p>
	<b><?php echo WELCOME_TEXT; ?></b>
</p>

<p>
	Hier kannst Du Dir Songs w&uuml;nschen, sehen, was gerade l&auml;uft und was auf der Wunschliste steht.
</p>

<iframe src="<?php echo SERVER_ADDR; ?>/api/current.php" scrolling="no" style="border: 0;" onload="resizeIframe(this)"></iframe>
<iframe src="<?php echo SERVER_ADDR; ?>/api/wish5.php" scrolling="no" style="border: 0;" onload="resizeIframe(this)"></iframe>