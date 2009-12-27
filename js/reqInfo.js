function reqDirInfo(fpath, pages) {
	var ajax = createAjax();
	ajax.open("POST", "data.php", false);
	ajax.setRequestHeader("Content-Type", 
		"application/x-www-form-urlencoded; charset=utf-8");
	ajax.send("ftype=dirInfo&fpath="+URLencode(fpath)+"&pages="+pages);

	var node = document.createElement("div");
	node.innerHTML = ajax.responseText;
	return node;
}

function reqFileInfo(fpath) {
	var ajax = createAjax();
	ajax.open("POST", "data.php", false);
	ajax.setRequestHeader("Content-Type", 
		"application/x-www-form-urlencoded; charset=utf-8");
	ajax.send("ftype=fileInfo&fpath="+URLencode(fpath));

	var node = document.createElement("div");
	node.innerHTML = ajax.responseText;
	return node;
}

