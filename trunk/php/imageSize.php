<?php
include_once("config.php");
include_once("php/transPath.php");
include_once("php/urlescape.php");

function isValidSize($w, $h) {
	global $CONF;
	return in_array($w."x".$h, $CONF["func"]["image"]["validSize"]);
}

/*
$size = "width"x"height" (ex: "640x480")
*/
function getImageUrl($vpath, $size) {
	global $CONF;
	if (!in_array($size, $CONF["func"]["image"]["validSize"]))
		return false;
	list($w, $h) = sscanf($size, "%dx%d");
	return "data.php?ftype=image&w=$w&h=$h&fpath=".urlescape($vpath);
}

function getErrorImageUrl($type, $size) {
	global $CONF;
	if (!in_array($size, $CONF["func"]["image"]["validSize"]))
		return false;
	list($w, $h) = sscanf($size, "%dx%d");
	return "data.php?ftype=image&w=$w&h=$h&fpath=icon/$type.png";
}

?>
