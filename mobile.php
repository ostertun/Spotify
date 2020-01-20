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
		
		<link rel="stylesheet" type="text/css" href="<?php echo SERVER_ADDR; ?>const/client/mobile.css">
		<?php
			if (file_exists('site/client/style.css')) {
				echo '<link rel="stylesheet" type="text/css" href="' . SERVER_ADDR . 'site/client/style.css">';
			}
		?>
		<meta name=viewport content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
		
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
				
				var allcheckboxs = document.getElementsByClassName('menu_chbox');
				var x = 0;
				for(x = 0; x < allcheckboxs.length; x++){
		
					allcheckboxs[x].onclick = function() {
						var checkboxs = document.getElementsByName(this.getAttribute("name"));
						var y = 0;
						for (y = 0; y < checkboxs.length; y++){
							if (checkboxs[y].getAttribute("id") != this.getAttribute("id")) {
								checkboxs[y].checked = false;
								
								var checkboxs2 = document.getElementsByName(checkboxs[y].getAttribute("id"));
								var z = 0;
								for (z = 0; z < checkboxs2.length; z++){
									checkboxs2[z].checked = false;
								}
							}
						}
					};
				}
				
				var menuShown = false;
				document.getElementById('hamburger').onclick = function() {
					
					if (menuShown) {
						// Höhe Head = Top-Position content wenn menu eingeklappt
						var position = jQuery('#head').height();
						
						// Inhalt hochschieben -> Menu verschwindet
						jQuery('#site').animate({"top": [position.toString(), 'easeOutExpo']}, {
							duration: 700
						});
						
						menuShown = false;
					} else {
						// Höhe Head + Menu = Top-Position content wenn menu ausgeklappt
						var position = jQuery('#head').height() + jQuery('#nav').height();
						
						// Inhalt runterschieben -> Menu erscheint
						jQuery('#site').animate({"top": [position.toString(), 'easeOutExpo']}, {
							duration: 700
						});
						
						menuShown = true;
					}
					
				}
				
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
					<?php echo STRING_WEBSITE_NAME; ?>
				</a>
			</div>
			
			<div id="hamburger">
				<div></div>
				<div></div>
				<div></div>
			</div>
			
		</div>
		
		<div id="nav">
			<ul>
			<?php
				function navoutput($nav, $parent) {
					$i = 0;
					foreach ($nav as $entry) {
						$i ++;
						if (is_string($entry[2])) {
							echo '<li><a href="' . LINK_PRE . $entry[2] . '">' . $entry[1] . '</a></li>';
						} else {
							echo '<li><input type="checkbox" name="' . $parent . '" id="' . $parent . '_' . $i . '" class="menu_chbox">';
							echo '<label for="' . $parent . '_' . $i . '"><a>' . $entry[1] . '</a></label><ul>';
							navoutput($entry[2], $parent . '_' . $i);
							echo '</ul></li>';
						}
					}
				}
				
				navoutput($nav, 'menu');
			?>
				<li><a href="<?php echo LINK_PRE; ?>imprint"><?php echo STRING_IMPRINT_SHORT; ?></a></li>
				<li><input type="checkbox" name="menu" id="menu_lang" class="menu_chbox">
					<label for="menu_lang"><a>Language</a></label><ul>
						<?php
							foreach ($languages as $key => $value) {
								echo '<li><a href="' . SERVER_ADDR . $key . '/' . $site . '/' . implode('/', $request) . '">' . $value . '</a></li>';
							}
						?>
					</ul>
				</li>
				<li><a href="javascript:changeBrowser('d');"><?php echo STRING_DESKTOP_VERSION; ?></a></li>
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
					</td>
					<td id="footright">
						<?php
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