<?php
	require("config_default.php");
	include("config.php");

	$thumbs_dir = 'thumbs';
	
	// Empty /thumbs folder
	foreach (scandir($thumbs_dir) as $item) {
		if ($item == '.' || $item == '..') continue;
		unlink($thumbs_dir.DIRECTORY_SEPARATOR.$item);
	}
	
	// Build thumbs
	$file_names = scanFileNameRecursivly('photos');
	foreach ($file_names as $file_name) {
		fopen();
		//echo '<img src="createthumb.php?filename='.$file_name.'&amp;size='.$thumb_size.'">';
	}
	
function scanFileNameRecursivly($path = '', &$name = array() )
{
	$lists = @scandir($path);
	if(!empty($lists)) {
		foreach($lists as $f) { 
			if(is_dir($path.DIRECTORY_SEPARATOR.$f) && $f != ".." && $f != ".") {
				scanFileNameRecursivly($path.DIRECTORY_SEPARATOR.$f, $name); 
			}
			else {
				 $name[] = $path.DIRECTORY_SEPARATOR.$f;
			}
		}
	}
	return $name;
}

?>