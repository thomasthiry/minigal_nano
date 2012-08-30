<?php
function createthumb($filename, $size, $output_image=true) {

	if (preg_match("/.jpg$|.jpeg$/i", $filename)) {
		$extension = 'jpg';
	}
	if (preg_match("/.gif$/i", $filename)) {
		$extension = 'gif';
	}
	if (preg_match("/.png$/i", $filename)) {
		$extension = 'png';
	}

	// Display error image if file isn't found
	if (!is_file($filename) && $output_image) {
		header('Content-type: image/jpeg');
		$errorimage = ImageCreateFromJPEG('images/questionmark.jpg');
		ImageJPEG($errorimage,null,90);
		exit;
	}
	
	// Display error image if file exists, but can't be opened
	if ((substr(decoct(fileperms($filename)), -1, strlen(fileperms($filename))) < 4 OR substr(decoct(fileperms($filename)), -3,1) < 4) && $output_image) {
		header('Content-type: image/jpeg');
		$errorimage = ImageCreateFromJPEG('images/cannotopen.jpg');
		ImageJPEG($errorimage,null,90);
		exit;
	}
	
	// Create the directory '/thumbs' if it doesn't exist
	if (!is_dir('thumbs'))
		mkdir('thumbs');
	
	// Check if the thumb already exists, if so send it instead.
	$thumb_path = 'thumbs/'.md5_file($filename).'.'.$extension;
	if (file_exists($thumb_path) && $output_image) {
		readfile($thumb_path);
		exit;
	}
	
	// Define variables
	$target = "";
	$xoord = 0;
	$yoord = 0;

    if ($size == "") $size = 120; 
       $imgsize = GetImageSize($filename);
       $width = $imgsize[0];
       $height = $imgsize[1];
      if ($width > $height) { // If the width is greater than the height it’s a horizontal picture
        $xoord = ceil(($width-$height)/2);
        $width = $height;      // Then we read a square frame that  equals the width
      } else {
        $yoord = ceil(($height-$width)/2);
        $height = $width;
      }

    // Rotate JPG pictures
    if (preg_match("/.jpg$|.jpeg$/i", $filename)) {
		if (function_exists('exif_read_data') && function_exists('imagerotate')) {
			$exif = exif_read_data($filename);
			$ort = $exif['IFD0']['Orientation'];
			$degrees = 0;
		    switch($ort)
		    {
		        case 6: // 90 rotate right
		            $degrees = 270;
		        break;
		        case 8:    // 90 rotate left
		            $degrees = 90;
		        break;
		    }
			if ($degrees != 0)	$target = imagerotate($target, $degrees, 0);
		}
	}
	
	$target = ImageCreatetruecolor($size,$size);
	if ($extension == 'jpg') $source = ImageCreateFromJPEG($filename);
	if ($extension == 'gif') $source = ImageCreateFromGIF($filename);
	if ($extension == 'png') $source = ImageCreateFromPNG($filename);
	imagecopyresampled($target,$source,0,0,$xoord,$yoord,$size,$size,$width,$height);
	imagedestroy($source);

	if ($extension == 'jpg') {
		// Save the thumb in a file
		ImageJPEG($target,$thumb_path,90);
		// Ouput file to client
		if ($output_image) {
			ImageJPEG($target,null,90);
		}
	}
	if ($extension == 'gif') {
		ImageGIF($target,$thumb_path,90);
		if ($output_image) {
			ImageGIF($target,null,90);
		}
	}
	if ($extension == 'png') {
		ImageJPEG($target,$thumb_path,90); // Using ImageJPEG on purpose
		if ($output_image) {
			ImageJPEG($target,null,90);
		}
	}	
	imagedestroy($target);
}
?>