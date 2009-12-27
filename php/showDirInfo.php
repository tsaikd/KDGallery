<?php
include_once("config.php");
include_once("php/transPath.php");
include_once("php/getPathInfo.php");
include_once("php/getDir.php");
include_once("php/showDirLink.php");

function showDirInfo($vpath) {
	global $CONF;
	global $LANG;

	$dpath = transPathV2R($vpath);
	if (!is_dir($dpath))
		return;
	$pw = getPathInfo($dpath, "password", true);
	if (isset($pw))
		$farray = array();
	else
		$farray = getDir($dpath, 0x03);

	$numPerLine = $CONF["func"]["image"]["dirPicPerLine"];
	$numPerPage = $CONF["func"]["image"]["dirLinePerPage"];
	$totalPage = ceil(count($farray) / ($numPerLine*$numPerPage));

	// show Dir Link
	logecho("<div class='jsData'>");
	showDirLink($vpath);
	logecho("</div>");

	// show total page info
	logecho("<div class='jsData'>");
	logecho("<div>$totalPage</div>");
	logecho("<div>");
	logecho("<span class='toolbarMsg'>");
	logecho(sprintf($LANG["picToolBar"]["fTotalPage"],
		"<span>".$totalPage."</span>"));
	logecho("</span>");
	logecho("</div>");
	logecho("</div>");
}

?>
