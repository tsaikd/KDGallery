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

				if (isMSIE) {
					var obj;
					for (var i=0 ; i<showObj.childNodes.length ; i++) {
						obj = showObj.childNodes[i];
						if (obj.nodeName == "TABLE") {
							if (obj.width == "100%")
								obj.width = "";
						}
					}
				}
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

