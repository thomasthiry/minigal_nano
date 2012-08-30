<?php
/*
MINIGAL NANO
- A PHP/HTML/CSS based image gallery script

This script and included files are subject to licensing from Creative Commons (http://creativecommons.org/licenses/by-sa/2.5/)
You may use, edit and redistribute this script, as long as you pay tribute to the original author by NOT removing the linkback to www.minigal.dk ("Powered by MiniGal Nano x.x.x")

MiniGal Nano is created by Thomas Rybak

Copyright 2010 by Thomas Rybak
Support: www.minigal.dk
Community: www.minigal.dk/forum

Please enjoy this free script!


USAGE EXAMPLE:
File: createthumb.php
Example: <img src="createthumb.php?filename=photo.jpg&amp;width=100&amp;height=100">
Example: <img src="createthumb.php?filename=photo.jpg&amp;size=100">
*/
//	error_reporting(E_ALL);

require('functions.php');

if (preg_match("/.jpg$|.jpeg$/i", $_GET['filename'])) {
	header('Content-type: image/jpeg');
}
if (preg_match("/.gif$/i", $_GET['filename'])) {
	header('Content-type: image/gif');
}
if (preg_match("/.png$/i", $_GET['filename'])) {
	header('Content-type: image/png');
}

createthumb($_GET['filename'], $_GET['size']);




?>