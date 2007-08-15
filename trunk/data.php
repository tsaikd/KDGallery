<?php
include_once("config.php");

$ftype = $_REQUEST["ftype"];
switch ($ftype) {
case "css":
case "js":
	include_once("php/indexHeader.php");
	if ($ftype == "css")
		header('Content-type: text/css');
	else
		header('Content-type: text/javascript');
	getCacheIndex($ftype);
	break;
case "dirInfo":
	header('Content-type: text/html; charset=utf-8');

	include_once("php/urlescape.php");
	$fpath = urlunescape($_REQUEST["fpath"]);
	include_once("php/showDirInfo.php");
	showDirInfo($fpath);
	break;
case "fileInfo":
	header('Content-type: text/html; charset=utf-8');

	include_once("php/urlescape.php");
	$fpath = urlunescape($_REQUEST["fpath"]);
	include_once("php/showFileInfo.php");
	showFileInfo($fpath);
	break;
case "dataContents":
	header('Content-type: text/html; charset=utf-8');

	include_once("php/urlescape.php");
	$fpath = urlunescape($_REQUEST["fpath"]);
	$page = isset($_REQUEST["page"]) ? (int)$_REQUEST["page"] : 1;

	include_once("php/transPath.php");
	if (!is_dir(transPathV2R($fpath))) {
		echo("invalid dir");
		break;
	}

	include_once("php/showDataContents.php");
	showDataContents($fpath, $page);
	break;
case "picPage":
	header('Content-type: text/html; charset=utf-8');

	include_once("php/urlescape.php");
	$fpath = urlunescape($_REQUEST["fpath"]);

	include_once("php/transPath.php");
	if (!is_file(transPathV2R($fpath))) {
		echo("Invalid file path '$fpath'");
		break;
	}

	include_once("php/showDataPicture.php");
	showDataPicture($fpath);
	break;
case "picSize":
	include_once("php/showPicSize.php");
	include_once("php/urlescape.php");
	$fpath = urlunescape($_REQUEST["fpath"]);
	$w = urlunescape($_REQUEST["w"]);
	$h = urlunescape($_REQUEST["h"]);
	showPicSize($fpath, $w, $h);
	break;
case "image":
	include_once("php/showImage.php");
	include_once("php/urlescape.php");
	$fpath = urlunescape($_REQUEST["fpath"]);
	$w = urlunescape($_REQUEST["w"]);
	$h = urlunescape($_REQUEST["h"]);
	if ("icon/" == substr($fpath, 0, 5))
		showImage($fpath, $w, $h, IMAGETYPE_PNG);
	else
		showImage($fpath, $w, $h);
	break;
default:
	header('Content-type: text/html; charset=utf-8');
	echo "<html>type('$ftype'): Not implement</html>";
	break;
}

?>
