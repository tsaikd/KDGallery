function getInfo(name) {
	if (name == "cdlv") { // current directory level
		var pages = getInfo("pages").split(",");
		var offset = isPicMode() ? 1 : 0;
		return pages.length + offset;
	}
	return conf.info[name];
/*
	var id = "info_"+name;
	var obj = document.getElementById(id);
	if (!obj)
		return "";
	return obj.innerHTML;
//*/
}

function setInfo(name, data) {
	if (name == "cdlv") {
		alert("please use leaveDir() and enterDir() instead");
		return;
	}
	conf.info[name] = data;
/*
	var id = "info_"+name;
	var obj = document.getElementById(id);
	if (obj)
		obj.innerHTML = data;
//*/
}

function isPicMode() {
	if (document.getElementById("mainPic"))
		return true;
	else
		return false;
}

