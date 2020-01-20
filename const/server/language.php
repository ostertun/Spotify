<?php
	
	$languages = array();
	
	$dir = 'site/content';
	if (is_dir($dir))
	{
		if ($handle = opendir($dir))
		{
			while (($file = readdir($handle)) !== false)
			{
				if ((filetype($dir . '/' . $file) == 'dir') and ($file != '.') and ($file != '..')) {
					if (isset($LANGUAGE_NAMES[$file])) {
						$languages[$file] = $LANGUAGE_NAMES[$file];
					} else {
						$languages[$file] = $file;
					}
				}
			}
			
			closedir($handle);
		}
	}
	
?>