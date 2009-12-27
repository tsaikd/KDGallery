<?php
include_once("config.php");

function transPathV2R($path) {
	global $CONF;

	$pinfo = explode("/", $path);
	$f = array_shift($pinfo);

	switch ($f) {
	case "data":
		array_unshift($pinfo, $CONF["path"]["data"]);
		break;
	case "icon":
		array_unshift($pinfo, "icon");
		break;
	default:
		return "";
	}

	return implode("/", $pinfo);
}

function transPathR2V($path, $type) {
	global $CONF;

	switch ($type) {
	case "auto":
		$res = transPathR2V($path, "data");
		if ($res != "")
			return $res;
		return "";
	case "data":
		$chkpath = $CONF["path"]["data"];
		$vpath = "data";
		break;
	default:
		return "";
	}

	$chklen = strlen($chkpath);
	if (0 != strncmp($path, $chkpath, $chklen))
		return "";

	return $vpath.substr($path, $chklen);
}

function transPathV2Id($vpath) {
	$path = $vpath;
	$path = str_replace("/", "__", $path);
	$path = str_replace(".", "____", $path);
	return $path;
}

function transPathId2V($id) {
	$res = $id;
	$res = str_replace("____", ".", $res);
	$res = str_replace("__", "/", $res);
	return $res;
}

?>
