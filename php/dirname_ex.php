<?php
function dirname_ex($path) {
	$dpath = explode("/", $path);
	array_pop($dpath);
	if (count($dpath))
		return implode("/", $dpath);
	else
		return ".";
}
?>
