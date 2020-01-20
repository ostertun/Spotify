<?php
	
	require_once('site/server/const.php');
	
?>

<html>
	
	<head>
		<title><?php echo PARTY_NAME; ?></title>
		<script>
			function resizeIframe(obj) {
				obj.style.height = 0;
				obj.style.height = (obj.contentWindow.document.body.scrollHeight + 10) + 'px';
			}
		</script>
		<meta http-equiv="refresh" content="600; URL=display.php" />
	</head>
	
	<body style="background: black; color: white;">
		<table border="0" style="width: 100%;">
			<tr>
				<td><div align="center"><b><?php echo WELCOME_TEXT; ?></b></div></td>
				<td style="width: 50%;" rowspan="3"><div align="center"><img style="/*height: 20vh;*/ width: 100%; box-shadow: 0 0 5px 2px white;" src="spcode.svg" /></div></td>
			</tr>
			<tr>
				<td><div align="center">W&uuml;nsch Dir was unter https://party.ostertun.net/<br>Party-Code: <?php echo PARTY_CODE; ?></div></td>
			</tr>
			<tr>
				<td><div align="center">Oder f&uuml;ge Deinen Wunsch einfach dieser Playlist hinzu:</div></td>
			</tr>
		</table>
		<hr>
		<iframe src="/api/currentinfo.php?dark" scrolling="no" style="border: 0; width: calc(100% - 4px);" onload="resizeIframe(this)"></iframe>
		<iframe src="/api/wish5.php?dark" scrolling="no" style="border: 0; width: calc(100% - 4px);" onload="resizeIframe(this)"></iframe>
	</body>
	
</html>