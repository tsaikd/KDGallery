<?php
include_once("config.php");
include_once("php/transPath.php");
include_once("php/getPathInfo.php");
include_once("php/getDir.php");
include_once("php/imageSize.php");

function showDataPicture($vpath) {
	global $CONF;
	global $LANG;

	$fpath = transPathV2R($vpath);
	$picValidSize = $CONF["func"]["image"]["validSize"];

	$fname = basename($vpath);
	$vdpath = dirname($vpath);
	$dpath = dirname($fpath);
	$pw = getPathInfo($dpath, "password", true);
	if (isset($pw))
		$farray = array();
	else
		$farray = getDir($dpath, 0x02);
	$total = count($farray);
	$k = array_search($fname, $farray);

	// show toolbar
	logecho("<div class='picOtherSize'>");
	logecho("<a class='toolbarMsg' href='javascript:;' onclick='javascript: toggleObj(this.nextSibling, \"inline\");'>".$LANG["picToolBar"]["otherSize"]."</a>");
	logecho("<span class='picOtherSizeSpan'>");
	foreach ($picValidSize as $s) {
		if ($s == "0x0") {
			logecho("<a class='toolbarMsg' target='_blank' href='".getImageUrl($vpath, $s)."'>");
			logecho($LANG["picToolBar"]["origPic"]);
		} else {
			logecho("<a class='toolbarMsg' href='javascript: changeImageSize(\"".getImageUrl($vpath, $s)."\")'>");
			logecho($s);
		}
		logecho("</a>");
	}
	logecho("</span>");
	logecho("</div>");

	if (!is_file($fpath)) {
		logecho($LANG["dataPic"]["notFile"]);
		return;
	}

	// show picture
	logecho("<div id='dataPic'>");
	showDataImage($vpath);
	logecho("</div>");
}

function showDataImage($vpath) {
	global $CONF;
	global $LANG;

	$fpath = transPathV2R($vpath);
	if (!is_file($fpath)) {
		logecho($LANG["dataPic"]["notFile"]);
		return;
	}

	$w = $CONF["func"]["image"]["showPicWidth"];
	$h = $CONF["func"]["image"]["showPicHeight"];
	$fname = getPathInfo($fpath, "name");
	$pw = getPathInfo($fpath, "password", true);

	if (isset($pw))
		logecho("<img id='mainPic' src='".getErrorImageUrl("password_protect", $w."x".$h)."' />");
	else
		logecho("<img id='mainPic' src='".getImageUrl($vpath, $w."x".$h)."' />");
	logecho("<div class='picName'>$fname</div>");
}

?>
