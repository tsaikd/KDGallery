function getDataContents(fpath, page) {
	var showObj = document.getElementById("showArea");
	if (page == undefined)
		page = 1;

	var ajax = createAjax();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 1) {
			showObj.innerHTML = "<div class='loading'>"+lang.msg.loading+"<\/div>";
		} else if (ajax.readyState == 4) {
			if (ajax.status == 200) {
				showObj.innerHTML = ajax.responseText;
				updateToolBar();
			} else {
				alert('There was a problem with the request.');
			}
		}
	}
	ajax.open("POST", "data.php", true);
	ajax.setRequestHeader("Content-Type", 
		"application/x-www-form-urlencoded; charset=utf-8");
	ajax.send("ftype=dataContents&fpath="+URLencode(fpath)+"&page="+page);
}

function getDataContentsSync(fpath, page) {
	var showObj = document.getElementById("showArea");
	if (page == undefined)
		page = 1;

	var ajax = createAjax();
	ajax.open("POST", "data.php", false);
	ajax.setRequestHeader("Content-Type", 
		"application/x-www-form-urlencoded; charset=utf-8");
	ajax.send("ftype=dataContents&fpath="+URLencode(fpath)+"&page="+page);

	showObj.innerHTML = ajax.responseText;
	updateToolBar();
}

