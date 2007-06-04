function getInfo(name) {
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
	conf.info[name] = data;
/*
	var id = "info_"+name;
	var obj = document.getElementById(id);
	if (obj)
		obj.innerHTML = data;
//*/
}

