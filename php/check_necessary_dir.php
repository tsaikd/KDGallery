<?php
/*
flag:
	0x01: read
	0x02: write
	0x04: try to create if not exists
	0x08: $cname is a local path
*/
function check_necessary_dir($cname, $flag) {
	global $CONF;
	global $LANG;

	if ($flag & 0x08)
		$path = $cname;
	else
		$path = $CONF["path"][$cname];

	if ($flag & 0x04) {
		if (!file_exists($path)) {
			include_once("php/mkdir_ex.php");

			@mkdir_ex($path) or
				die("'".$cname."' ".$LANG["message"]["cannotmake"].", ".$LANG["message"]["checkconf"]);
		}
	}

	if ($flag & 0x01) {
		is_readable($path) or
			die("'".$cname."' ".$LANG["message"]["cannotread"].", ".$LANG["message"]["checkconf"]);
	}

	if ($flag & 0x02) {
		is_writable($path) or
			die("'".$cname."' ".$LANG["message"]["cannotwrite"].", ".$LANG["message"]["checkconf"]);
	}
}

?>
