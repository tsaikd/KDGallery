<?php
include_once("config.php");

function showMsgHtml($msg) {
	global $LANG;
	echo "<html>";
	echo "<h1>".$LANG["message"]["success"]."</h1>";
	echo "<h2>".$msg."</h2>";
	echo "</html>";
}

function showErrorHtml($msg) {
	global $LANG;
	echo "<html>";
	echo "<h1>".$LANG["message"]["error"]."</h1>";
	echo "<h2>".$msg."</h2>";
	echo "</html>";
}

function showDirLink($vpath) {
	global $LANG;
	$dirLink = explode("/", $vpath);
	foreach ($dirLink as $k => $f) {
		if ($k == 0) {
			logecho("<a class='toolbarBtn' href='javascript: getDataContents(\"data\", 1)'>".$LANG["dataTree"]["home"]."</a>");
		} else {
			$bufpath = "data";
			for ($i=1 ; $i<=$k ; $i++)
				$bufpath .= "/".$dirLink[$i];
			$f = getPathInfo(transPathV2R($bufpath), "name");
			logecho(" &gt; <a class='toolbarBtn' href='javascript: getDataContents(\"$bufpath\", 1)'>$f</a>");
		}
	}
}

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

	// show toolbar
	$totalPage = ceil(count($farray) / ($numPerLine*$numPerPage));
	logecho("<table class='dirToolBar' align='center' width='100%'>");
	logecho("<tr><td colspan='3' class='dirLink'>");
	showDirLink($vpath);
	logecho("</td><td>");
	logecho("<span class='toolbarMsg'>".sprintf($LANG["picToolBar"]["fTotalPage"], $totalPage)."</span>");
	logecho("</td></tr>");
	logecho("<tr><td>");
	if ($page > 1) {
		logecho("<a class='toolbarBtn' href='javascript: getDataContents(\"$vpath\", 1)'>".$LANG["picToolBar"]["firstPage"]."</a>");
		logecho("<a class='toolbarBtn' href='javascript: getDataContents(\"$vpath\", ".($page-1).")'>".$LANG["picToolBar"]["prevPage"]."</a>");
	} else {
		logecho("<span class='toolbarMsg'>".$LANG["picToolBar"]["firstPage"]."</span>");
		logecho("<span class='toolbarMsg'>".$LANG["picToolBar"]["prevPage"]."</span>");
	}
	logecho("</td><td width='400' colspan='2'>");
	logecho("<span class='toolbarMsg'>");
	for ($i=-5 ; $i<=5 ; $i++) {
		if (($page+$i > 0) && ($page+$i <= $totalPage)) {
			if ($i == 0)
				logecho("<span class='toolbarMsg'>$page</span>");
			else
				logecho("<a class='toolbarMsg' href='javascript: getDataContents(\"$vpath\", ".($page+$i).")'>".($page+$i)."</a>");
		}
	}
	logecho("</span>");
	logecho("</td><td>");
	if ($page < $totalPage) {
		logecho("<a class='toolbarBtn' href='javascript: getDataContents(\"$vpath\", ".($page+1).")'>".$LANG["picToolBar"]["nextPage"]."</a>");
		logecho("<a class='toolbarBtn' href='javascript: getDataContents(\"$vpath\", $totalPage)'>".$LANG["picToolBar"]["lastPage"]."</a>");
	} else {
		logecho("<span class='toolbarMsg'>".$LANG["picToolBar"]["nextPage"]."</span>");
		logecho("<span class='toolbarMsg'>".$LANG["picToolBar"]["lastPage"]."</span>");
	}
	logecho("</td></tr>");
	logecho("</table>");

	if (!count($farray)) {
		logecho("<div>");
		logecho($LANG["dataTree"]["noAlbum"]);
		logecho("</div>");
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
			logecho("<a class='treeDir' href='javascript: getDataContents(\"$vpath/$f\", 1)'>");
		} else {
			logecho("<a class='treeFile' href='javascript: getDataContents(\"$vpath/$f\", 1)'>");
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

function showDataPicture($vpath) {
	global $CONF;
	global $LANG;

	$fpath = transPathV2R($vpath);
	$picValidSize = $CONF["func"]["image"]["validSize"];

	include_once("php/getDir.php");
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
	logecho("<div class='dirLink'>");
	showDirLink($vpath);
	logecho("</div>");
	logecho("<table class='dirToolBar' width='400' align='center'>");
	logecho("<tr><td>");
	if ($k > 0) {
		logecho("<a class='toolbarBtn' href='javascript: getDataContents(\"$vdpath/".$farray[$k-1]."\")'>".$LANG["picToolBar"]["prevPage"]."</a>");
	} else {
		logecho("<span class='toolbarBtn'>".$LANG["picToolBar"]["prevPage"]."</span>");
	}
	logecho("</td><td>");
	logecho("<span id='toolbarPicNum' class='toolbarMsg'>".($k+1)."</span>");
	logecho("<span class='toolbarMsg'>/</span>");
	logecho("<span class='toolbarMsg'>$total</span>");
	logecho("</td><td>");
	if ($k < ($total-1)) {
		logecho("<a class='toolbarBtn' href='javascript: getDataContents(\"$vdpath/".$farray[$k+1]."\")'>".$LANG["picToolBar"]["nextPage"]."</a>");
	} else {
		logecho("<span class='toolbarBtn'>".$LANG["picToolBar"]["nextPage"]."</span>");
	}
	logecho("</td></tr>");
	logecho("</table>");
	logecho("<div class='picOtherSize'>");
	logecho("<a class='toolbarBtn' href='javascript:;' onclick='javascript: toogleObj(this.nextSibling, \"inline\");'>".$LANG["picToolBar"]["otherSize"]."</a>");
	logecho("<span style='display: none;'>");
	foreach ($picValidSize as $s) {
		logecho("<a class='toolbarBtn' href='javascript: changeImageSize(\"".getImageUrl($vpath, $s)."\")'>");
		if ($s == "0x0") {
			logecho($LANG["picToolBar"]["origPic"]);
		} else {
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
case "dataContents":
	include_once("php/transPath.php");
	include_once("php/getDir.php");
	include_once("php/getPathInfo.php");
	include_once("php/imageSize.php");
	header('Content-type: text/html; charset=utf-8');

	include_once("php/urlescape.php");
	$fpath = urlunescape($_REQUEST["fpath"]);
	if (is_file(transPathV2R($fpath))) {
		showDataPicture($fpath);
	} else {
		if (isset($_REQUEST["page"]))
			$page = (int)$_REQUEST["page"];
		else
			$page = 1;
		showDataContents($fpath, $page);
	}
	break;
case "image":
	include_once("php/showImage.php");
	include_once("php/urlescape.php");
	$fpath = urlunescape($_REQUEST["fpath"]);
	if ("icon/" == substr($fpath, 0, 5))
		showImage($fpath, $_REQUEST["w"], $_REQUEST["h"], IMAGETYPE_PNG);
	else
		showImage($fpath, $_REQUEST["w"], $_REQUEST["h"]);
	break;
default:
	header('Content-type: text/html; charset=utf-8');
	echo "<html>type('$ftype'): Not implement</html>";
	break;
}

?>
