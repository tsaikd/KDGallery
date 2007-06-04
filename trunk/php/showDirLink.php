<?php
include_once("config.php");
include_once("php/transPath.php");
include_once("php/getPathInfo.php");
include_once("php/urlescape.php");

function showDirLink($vpath) {
	global $LANG;

	$dirLink = explode("/", $vpath);
	$first = array_shift($dirLink);
	$last = array_pop($dirLink);
	logecho("<a class='toolbarMsg' href='javascript: leaveDir(1)'>".$LANG["dataTree"]["home"]."</a>");

	$k = 0;
	$bufpath = "data";
	foreach ($dirLink as $k => $f) {
		$bufpath = "data";
		for ($i=0 ; $i<=$k ; $i++)
			$bufpath .= "/".$dirLink[$i];
		$f = getPathInfo(transPathV2R($bufpath), "name");
		logecho("<span class='toolbarMsg'>&gt;</span><a class='toolbarMsg' href='javascript: leaveDir(".($k+2).")'>$f</a>");
	}

	if (isset($last)) {
		$bufpath .= "/".$last;
		$fpath = transPathV2R($bufpath);
		$f = getPathInfo($fpath, "name");
		logecho("<span class='toolbarMsg'>&gt;</span>");
		if (is_dir($fpath))
			logecho("<a id='pagelink' class='toolbarMsg' title='".$LANG["dataTree"]["permalink"]."' href='?fpath=".urlescape($vpath)."'>$f</a>");
		else
			logecho("<span class='toolbarMsg'>$f</span>");
	}
}

?>
