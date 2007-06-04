<?php
include_once("config.php");
include_once("php/transPath.php");
include_once("php/getPathInfo.php");
include_once("php/getDir.php");
include_once("php/imageSize.php");

function showDataContents($vpath, $page) {
	global $LANG;
	global $CONF;

	$dpath = transPathV2R($vpath);
	$pw = getPathInfo($dpath, "password", true);
	if (isset($pw))
		$farray = array();
	else
		$farray = getDir($dpath, 0x53);

	$c = 0;
	$numPerLine = $CONF["func"]["image"]["dirPicPerLine"];
	$numPerPage = $CONF["func"]["image"]["dirLinePerPage"];
	$clb = ($page-1)*$numPerLine*$numPerPage;
	$crb = $page*$numPerLine*$numPerPage;
	$w = $CONF["func"]["image"]["dirPicWidth"];
	$h = $CONF["func"]["image"]["dirPicHeight"];
	$tdWidth = sprintf("%d%%", (int)(100/$numPerLine));
	$trHeight = $h + 20;

	if (isset($pw)) {
		$name = getPathInfo("$dpath", "name");
		logecho("<table class='dirContents' align='center' width='100%'>");
		logecho("<tr><td>");
		logecho("<img src='".getErrorImageUrl("password_protect", $w."x".$h)."' />");
		logecho("<br />".$name);
		logecho("</td></tr>");
		logecho("</table>");
		return;
	}

	if (!count($farray)) {
		logecho("<table class='dirContents' align='center' width='100%'>");
		logecho("<tr><td>");
		logecho("<img src='".getErrorImageUrl("empty_dir", $w."x".$h)."' />");
		logecho("<br />".$LANG["dataTree"]["noAlbum"]);
		logecho("</td></tr>");
		logecho("</table>");
		return;
	}

	// show contents
	logecho("<table class='dirContents' align='center' width='100%'>");
	foreach ($farray as $f) {
		if ($c < $clb) {
			$c++;
			continue;
		}
		if ($c % $numPerLine == 0)
			logecho("<tr height='$trHeight'>");
		logecho("<td width='$tdWidth'>");
		$name = getPathInfo("$dpath/$f", "name");
		if (is_dir("$dpath/$f")) {
			logecho("<a class='treeDir' href='javascript: enterDir(\"$f\")'>");
		} else {
			logecho("<a class='treeFile' href='javascript: showPicPage(\"$vpath/$f\")'>");
		}
		$pw = getPathInfo("$dpath/$f", "password", true);
		if (isset($pw))
			logecho("<img src='".getErrorImageUrl("password_protect", $w."x".$h)."' />");
		else
			logecho("<img src='".getImageUrl("$vpath/$f", $w."x".$h)."' />");
		logecho("<br />");
		logecho($name);
		logecho("</a>");
		logecho("</td>");
		$c++;
		if ($c % $numPerLine == 0)
			logecho("</tr>");
		if ($c >= $crb)
			break;
	}
	logecho("</table>");
}

?>
