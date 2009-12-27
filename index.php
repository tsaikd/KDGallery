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

lang.picToolBar = {};
lang.picToolBar.prevPage = "<?=$LANG["picToolBar"]["prevPage"]?>";
lang.picToolBar.nextPage = "<?=$LANG["picToolBar"]["nextPage"]?>";
lang.picToolBar.firstPage = "<?=$LANG["picToolBar"]["firstPage"]?>";
lang.picToolBar.lastPage = "<?=$LANG["picToolBar"]["lastPage"]?>";

conf = {};
conf.info = {};
conf.info["pwd"] = "data";
conf.info["pages"] = "1";
conf.info["cpnum"] = 1;
conf.info["totalPage"] = 1;

conf.init = function() {
	var fpath = unescape("<?=$_REQUEST["fpath"]?>");
	var picpath = unescape("<?=$_REQUEST["picpath"]?>");
	var cpnum = "<?=$_REQUEST["cpnum"]?>";

	if (picpath != "")
		fpath = dirname(picpath);
	if (fpath == "")
		fpath = "data";
	if (cpnum == "")
		cpnum = "1";

	setDir(fpath, cpnum);
	if (picpath != "")
		showPicPage(picpath);

	if (isMSIE) {
		var obj = document.getElementById("toolbar");
		obj.width = "";
	}
}
		</script>
	</head>
	<body onkeydown="hotkey(event)">
		<div id="headerArea">
			<a onfocus='this.blur()' id='headerTitle' href="<?=$CONF["link"]?>"><?=$CONF["title"]?></a>
		</div>
		<table id='toolbar' align='center' width='100%'>
		<tr><td colspan='3' id='toolbar_dirLink' class='dirLink'>
		</td><td id='toolbar_totalPage'>
		</td></tr>
		<tr><td id='toolbar_prev'>
		</td><td width='400' colspan='2' id='toolbar_pageNum'>
		</td><td id='toolbar_next'>
		</td></tr>
		</table>
		<div id="showArea"></div>
<?php if (0) : ?>
		<div id="info" class="jsData">
			<div id="info_pwd">data</div>
			<div id="info_pages">1</div>
			<div id="info_cpnum">1</div>
			<div id="info_totalPage">1</div>
		</div>
<?php endif ?>
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

