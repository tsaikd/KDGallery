<?php
function getFileType($fpath) {
	if (function_exists("mime_content_type"))
		return mime_content_type($fpath);

	$t = trim(exec('file -bi '.escapeshellarg($fpath)));
	$t = explode(";", $t);
	return $t[0];
}
?>
