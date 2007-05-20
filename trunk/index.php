<?php

header('Content-type: text/html; charset=utf-8');

if (!file_exists("config.php")) {
	echo "Please setup your config file first!\n";
	echo "See 'config.php.example' for more information.\n";
	exit;
}
include_once("config.php");
if ($CONF["version"] < 1)
	die($LANG["message"]["confTooOld"]);

# Check server state
include_once("php/check_necessary_dir.php");
check_necessary_dir("cache", 0x07);
check_necessary_dir("data", 0x01);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?=$CONF["title"]?></title>
		<base href="<?=$CONF["link"]?>">
<?php if (file_exists("favicon.ico")) : ?>
		<link rel="SHORTCUT ICON" type="image/x-icon" href="favicon.ico">
<?php endif ?>
		<link rel="stylesheet" type="text/css" href="data.php?ftype=css">
		<script type="text/javascript" src="data.php?ftype=js"></script>
		<script type="text/javascript">
var isMSIE = /*@cc_on!@*/false;

lang = {};
lang.msg = {};
lang.msg.loading = "<?=$LANG["msg"]["loading"]?>";

conf = {};
conf.init = function() {
	getDataContents("data", 1);
}
		</script>
	</head>
	<body>
		<div id="headerArea">
			<a onfocus='this.blur()' id='headerTitle' href="<?=$CONF["link"]?>"><?=$CONF["title"]?></a>
		</div>
		<div id="showArea"></div>
<?php
if ($CONF["extraFooter"])
	foreach ($CONF["extraFooter"] as $f)
		include($f);
?>
		<script type="text/javascript">
			if (conf.init)
				conf.init();
		</script>
	</body>
</html>

