<?php
	require('config_default.php');
	include('config.php');
	require('functions.php');

	$path_to_scan = "photos/";
	if (isset($_GET['path'])) {
		$path_to_scan .= $_GET['path']; // TODO: remove '..'
	}
	else {
		// If global scan, we can empty the thumbs folder
		foreach (scandir($thumbs_dir) as $item) {
			if ($item == '.' || $item == '..') continue;
			unlink($thumbs_dir.DIRECTORY_SEPARATOR.$item);
		}
	}

	// Build thumbs
	$file_names = scanFileNameRecursivly($path_to_scan);
	foreach ($file_names as $file_name) {
		if ($file_name[strlen($file_name)-1] != '.') {
			//echo $file_name.'<br>';
			createthumb($file_name, $thumb_size, false);
			echo '.';
			flush();
			ob_flush();
		}
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