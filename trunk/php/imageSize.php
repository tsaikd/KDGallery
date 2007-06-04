<?php
include_once("config.php");
include_once("php/transPath.php");
include_once("php/urlescape.php");
include_once("php/getDir.php");

function isPicFile($fpath) {
	if (!is_file($fpath))
		return false;
	if (eregi('\.(jpg|gif|png|jpeg)$', $fpath))
		return true;
	else
		return false;
}

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
	$fpath = transPathV2R($vpath);
	if (is_dir($fpath)) {
		$dapath = array("/");
		while ($vdpath = array_shift($dapath)) {
			$dpath = transPathV2R($vpath.$vdpath);
			$farray = getDir($dpath);
			foreach ($farray as $f) {
				if (isPicFile("$dpath/$f"))
					return getImageUrl("$vpath$vdpath/$f", $size);
				array_push($dapath, "$vdpath/$f");
			}
		}

		return getErrorImageUrl("path_is_dir", $size);
	}

	return "data.php?ftype=image&w=$w&h=$h&fpath=".urlescape($vpath);
}

function getErrorImageUrl($type, $size) {
	global $CONF;
	if (!in_array($size, $CONF["func"]["image"]["validSize"]))
		return false;
	list($w, $h) = sscanf($size, "%dx%d");
	$fpath = transPathV2R("icon/$type.png");
	if (!is_file($fpath))
		$type = "question";
	return "data.php?ftype=image&w=$w&h=$h&fpath=icon/$type.png";
}

?>
