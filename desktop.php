<?php
	
	require_once('const/server/includer.php');
	
?>

<!DOCTYPE html>

<html lang="<?php echo LANG; ?>">
	
	<head>
		<?php
			require_once('server/server/pre.html');
		?>
		
		<meta charset="utf-8" />
		
		<?php
			$sitename = '';
			if ($site == '') {
				// Keine Seite angegeben -> Startseite
				$sitename = STRING_TITLE_HOME;
			} else if ($site == 'imprint') {
				$sitename = STRING_IMPRINT_SHORT;
			} else {
				// Seite angegeben
				if (isset($headings[$site])) {
					// Seite existiert
					// Seitentitel anzeigen
					$sitename = $headings[$site][1];
				} else {
					// Seite existiert nicht
					$sitename = STRING_TITLE_404;
				}
			}
			echo '<title>' . $sitename . ' - ' . STRING_WEBSITE_NAME . '</title>';
		?>
		<link rel="icon" href="<?php echo SERVER_ADDR . 'site'; ?>/client/icon.png" type="image/png" />
		
		<link rel="stylesheet" type="text/css" href="<?php echo SERVER_ADDR; ?>const/client/desktop.css">
		<?php
			if (file_exists('site/client/style.css')) {
				echo '<link rel="stylesheet" type="text/css" href="' . SERVER_ADDR . 'site/client/style.css">';
			}
		?>
		
		<script type="text/javascript" src="<?php echo JQUERY_URL1; ?>"></script>
		<script type="text/javascript" src="<?php echo JQUERY_URL2; ?>"></script>
		
		<script type="text/javascript">
			
			// onClick for browser change
			function changeBrowser(browser) {
				var d = new Date();
				d.setTime(d.getTime() + (30*24*60*60*1000));
				document.cookie = "device=" + browser + "; expires=" + d.toUTCString() + "; path=/;";
				location.reload();
			}
			
			popupcnt = 0;
			
			function create_popup(text, color, dur) {
				popupcnt ++;
				var id = popupcnt;
				popup = document.createElement("div");
				popup.id = "popup" + id;
				popup.innerHTML = text;
				popup.classList.add('popup');
				popup.style.background = color;
				popup.style.boxShadow = "0 0 10px " + color;
				document.getElementById("popups").appendChild(popup);
				jQuery('#popup' + id).animate({ 'opacity': 1 }, 1000, function() {
					setTimeout(function() {
						jQuery('#popup' + id).animate({ 'height': 0, 'padding-top': 0, 'padding-bottom': 0, 'margin-bottom': 0, 'opacity': 0 }, 1000);
					}, dur);
				});
			}
			
			function resizeIframe(obj) {
				obj.style.height = 0;
				obj.style.height = (obj.contentWindow.document.body.scrollHeight + 10) + 'px';
			}
			
			window.onload = function () {
				
				<?php
					
					$cnt = 0;
					
					if (FIRSTVISIT == true) {
						echo 'setTimeout(function() {';
						echo 'create_popup("' . STRING_COOKIES . '", "#0077ff", 10000);';
						echo '}, ' . $cnt . '000);';
						$cnt ++;
					}
					
					foreach ($logmsg as $value) {
						switch ($value[0]) {
							case 0:
								$color = '#ff0000';
								break;
							case 1:
								$color = '#00ff00';
								break;
							case 2:
								$color = '#0077ff';
								break;
							default:
								$color = '#ffffff';
								break;
						}
						
						echo 'setTimeout(function() {';
						echo 'create_popup("' . htmlentities($value[1], ENT_COMPAT, 'UTF-8') . '", "' . $color . '", 3000);';
						echo '}, ' . $cnt . '000);';
						
						$cnt ++;
					}
					
				?>
				
			}
			
		</script>
		
	</head>
	
	<body>
		
		<div id="head">
			
			<div id="headicon">
				<a href="<?php echo LINK_PRE; ?>">
					<?php
						$files = glob('site/client/icon.*', GLOB_NOSORT);
						if (($files !== false) and (count($files) > 0)) {
							echo '<img src="' . SERVER_ADDR . $files[0] . '" />';
						}
					?>
				</a>
			</div>
			
			<div id="header">
				<a href="<?php echo LINK_PRE; ?>" style="text-decoration: none; color: #ffffff;">
					<?php echo STRING_WEBSITE_NAME . '<br>' . $sitename; ?>
				</a>
			</div>
			
			<div id="headright">
				<?php
					
					if (file_exists('site/content/' . LANG . '/contact.php')) {
						echo '<a style="text-decoration: none; color: #ffffff;" href="' . LINK_PRE . 'contact">' . STRING_CONTACT . '</a> | ';
					}
					
					echo '<a style="text-decoration: none; color: #ffffff;" href="' . LINK_PRE . 'imprint">' . STRING_IMPRINT_SHORT . '</a>';
					
				?>
			</div>
			
		</div>
		
		<div id="nav">
			<ul>
			<?php
				function navoutput($nav) {
					foreach ($nav as $entry) {
						if (is_string($entry[2])) {
							echo '<li><a href="' . LINK_PRE . $entry[2] . '">' . $entry[1] . '</a></li>';
						} else {
							echo '<li><a>' . $entry[1] . '</a><ul>';
							navoutput($entry[2]);
							echo '</ul></li>';
						}
					}
				}
				
				navoutput($nav);
			?>
			</ul>
		</div>
		
		<div id="site">
			
			<div id="content">
				
				<?php
					if ($site == '') {
						// Keine Seite angegeben -> Startseite
						include('site/content/' . LANG . '/index.php');
					} else if ($site == 'imprint') {
						include('const/server/imprint/' . LANG . '.php');
					} else {
						// Seite angegeben
						if (isset($headings[$site])) {
							// Seite sollte existiert
							if (file_exists('site/content/' . LANG . '/' . $site . '.php')) {
								include('site/content/' . LANG . '/' . $site . '.php');
							} else {
								include('site/content/' . LANG . '/404i.php');
							}
						} else {
							// Seite existiert nicht
							include('site/content/' . LANG . '/404.php');
						}
					}
				?>
				
			</div>
			
			<div id="modules">
				
				<?php
					
					foreach ($modules as $module) {
						if ((count($module[0]) > 0) and !in_array($site, $module[0])) { continue; }
						if ((count($module[1]) > 0) and in_array($site, $module[1])) { continue; }
						echo '<div class="module">';
						$module[3]($site);
						echo '</div>';
					}
					
				?>
				
			</div>
			
		</div>
		
		<div id="foot">
			
			<div id="footer">
				
				<table id="foottable" border="0"><tr>
					<td id="footleft">
						<a href="javascript:changeBrowser('m');"><?php echo STRING_MOBILE_VERSION; ?></a>
						<?php
							foreach ($languages as $key => $value) {
								echo ' | <a href="' . SERVER_ADDR . $key . '/' . $site . '/' . implode('/', $request) . '">' . $value . '</a>';
							}
						?>
					</td>
					<td id="footright">
						<?php
							echo '<a href="' . LINK_PRE . 'imprint">' . STRING_IMPRINT . '</a>';
							echo ' | ';
							echo STRING_COPY;
						?>
					</td>
				</tr></table>
				
			</div>
			
		</div>
		
		<div id="popups">
		</div>
		
	</body>
	
</html>