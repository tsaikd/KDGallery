<?php
/*
$flag
	0x01: get dir list
	0x02: get file list
	0x10: revert sort dir
	0x20: revert sort file
	0x00: sort regular
	0x40: sort to {dir, file}
*/
function getDir($path, $flag=0x03) {
	$aRes = array();

	if (!is_dir($path))
		return $aRes;

	$d = dir($path);
	while ($f = $d->read()) {
		if ($f[0] == ".")
			continue;
		array_push($aRes, $f);
	}
	$d->close();

	if (($flag & 0x03) != 0x03) {
		foreach ($aRes as $k => $f) {
			if (!($flag & 0x01)) {
				if (is_dir("$path/$f")) {
					unset($aRes[$k]);
					continue;
				}
			}
			if (!($flag & 0x02)) {
				if (is_file("$path/$f")) {
					unset($aRes[$k]);
					continue;
				}
			}
		}
	}

	sort($aRes);

	if ($flag & 0x40) {
		$oldRes = $aRes;
		$aRes = array();
		foreach ($oldRes as $k => $f) {
			if (is_dir("$path/$f")) {
				if ($flag & 0x10)
					array_unshift($aRes, $f);
				else
					array_push($aRes, $f);
				unset($oldRes[$k]);
				continue;
			}
		}
		foreach ($oldRes as $f) {
			if ($flag & 0x20)
				array_unshift($aRes, $f);
			else
				array_push($aRes, $f);
		}
		unset($oldRes);
	}

	return $aRes;
}
?>
