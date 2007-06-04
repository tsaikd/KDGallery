<?php
include_once("config.php");
include_once("php/transPath.php");
include_once("php/getPathInfo.php");
include_once("php/getDir.php");
include_once("php/basename_ex.php");
include_once("php/showDirLink.php");

function showFileInfo($vpath) {
	global $CONF;
	global $LANG;

	$fpath = transPathV2R($vpath);
	if (!is_file($fpath))
		return;
	$vdpath = dirname($vpath);
	$dpath = dirname($fpath);
	$pw = getPathInfo($fpath, "password", true);
	if (isset($pw))
		$farray = array();
	else
		$farray = getDir($dpath, 0x02);
	$fname = basename_ex($vpath);
	$k = array_search($fname, $farray);

	$totalPage = count($farray);

	// show Dir Link
	logecho("<div class='jsData'>");
	showDirLink($vpath);
	logecho("</div>");

	// show page number info
	logecho("<div class='jsData'>");
	logecho("<div>$totalPage</div>");
	logecho("<div>".($k+1)."</div>");
	logecho("</div>");

	// show relative pages info
	logecho("<div class='jsData'>");
	if (($k > 0) && isset($farray[0]))
		logecho("<div>".$vdpath."/".$farray[0]."</div>");
	else
		logecho("<div></div>");
	if (isset($farray[$k-1]))
		logecho("<div>".$vdpath."/".$farray[$k-1]."</div>");
	else
		logecho("<div></div>");
	if (isset($farray[$k+1]))
		logecho("<div>".$vdpath."/".$farray[$k+1]."</div>");
	else
		logecho("<div></div>");
	if (isset($farray[$totalPage-1]))
		logecho("<div>".$vdpath."/".$farray[$totalPage-1]."</div>");
	else
		logecho("<div></div>");
	logecho("</div>");
}

?>
