function showPicPage(fpath) {
	var showObj = document.getElementById("showArea");

	var ajax = createAjax();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 1) {
			showObj.innerHTML = "<div class='loading'>"+lang.msg.loading+"<\/div>";
		} else if (ajax.readyState == 4) {
			if (ajax.status == 200) {
				showObj.innerHTML = ajax.responseText;

				updatePicToolBar(fpath);
			} else {
				alert('There was a problem with the request.');
			}
		}
	}
	ajax.open("POST", "data.php", true);
	ajax.setRequestHeader("Content-Type", 
		"application/x-www-form-urlencoded; charset=utf-8");
	ajax.send("ftype=picPage&fpath="+URLencode(fpath));
}

