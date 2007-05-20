<?php
include_once("config.php");
include_once("php/parseXml.php");
include_once("php/basename_ex.php");
include_once("php/dirname_ex.php");

/*
$recur don't effect at $type == "name"
*/
function getPathInfo($fpath, $type, $recur=false) {
	global $CONF;
	$dpath = dirname_ex($fpath);
	if (($dpath == ".") || ($dpath == $CONF["path"]["root"]))
		return null;
	if ($recur)
		$res = getPathInfo($dpath, $type, $recur);

/* php bug: basename don't work with chinese
	$fname = basename($fpath);
//*/
	$fname = basename_ex($fpath);
	$fconf = $dpath."/.config.xml";
	if (!file_exists($fconf)) {
		if ($type == "name")
			return $fname;
		else
			return $res;
	}

	list($index, $vals) = parseXml($fconf);

	foreach ($index["item"] as $i) {
		if ($vals[$i]["attributes"]["path"] != $fname)
			continue;

		$i++;
		while (isset($vals[$i]) && ($vals[$i]["type"] != "close")) {
			if ($vals[$i]["tag"] != $type) {
				$i++;
				continue;
			}

			if ($recur) {
				if (!isset($res))
					$res = array();
				if (isset($vals[$i]["value"]))
					array_push($res, $vals[$i]["value"]);
				else
					array_push($res, "");
				return $res;
			} else {
				if (isset($vals[$i]["value"]))
					return $vals[$i]["value"];
				else
					return "";
			}
		}
	}

	if ($type == "name")
		return $fname;
	else
		return $res;
}

?>
