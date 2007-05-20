<?php
/*
$name:
	"css"
	"js"
*/
function getCacheIndex($name) {
	global $CONF;

	$cInfo = array();
	$cInfo["enable"] = $CONF["cache"][$name]["enable"];
	$cInfo["cachePath"] = $CONF["path"]["cache"]."/".$name.".cache";
	$cInfo["bSendHeader"] = true;
	if ($name == "css")
		$cInfo["showDataProc"] = "showCssData";
	else if ($name == "js")
		$cInfo["showDataProc"] = "showJsData";
	else
		return;

	return getGenCache($cInfo);
}

function showCssData($cInfo) {
	include_once("php/getDir.php");

	$path = "css";
	$farray = getDir($path);
	foreach ($farray as $f) {
		if (strtolower(substr($f, -4)) != ".css")
			continue;
		logecho(file_get_contents("$path/$f"));
	}
}

function showJsData($cInfo) {
	include_once("php/getDir.php");

	$path = "js";
	$farray = getDir($path);
	foreach ($farray as $f) {
		if (strtolower(substr($f, -3)) != ".js")
			continue;
		logecho(file_get_contents("$path/$f"));
	}
}

?>
