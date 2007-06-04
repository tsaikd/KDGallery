function updateToolBar() {
	var buf;
	var obj;

	if (isMSIE) { // delay for some unknown bugs in IE ...=.=
		for (var i=0 ; i<document.images.length ; i++) {
			obj = document.images[i];
			if (!obj.complete) {
				setTimeout("updateToolBar();", 200);
				return;
			}
		}
	}

	var fpath = getInfo("pwd");
	var pages = getInfo("pages");
	var node = reqDirInfo(fpath, pages);
	if (node.childNodes.length < 2) {
		alert(fpath+"\nreqDirInfo failed:\n"+node.innerHTML);
		return;
	}

	obj = document.getElementById("toolbar_dirLink");
	obj.innerHTML = node.childNodes[0].innerHTML;

	setInfo("totalPage", node.childNodes[1].childNodes[0].innerHTML);
	obj = document.getElementById("toolbar_totalPage");
	obj.innerHTML = node.childNodes[1].childNodes[1].innerHTML;

	var totalPage = parseInt(getInfo("totalPage"));
	var cpnum = parseInt(getInfo("cpnum"));
	var pageFunc = "pageDir";

	// update pagelink
	obj = document.getElementById("pagelink");
	if (obj) {
		buf = obj.href;
		buf += "&cpnum="+cpnum;
		obj.href = buf;
	}

	// set toolbar_prev
	buf = "";
	if (cpnum > 1) {
		buf += "<a class='toolbarMsg' href='javascript: "+pageFunc+"(1);'>";
		buf += lang.picToolBar.firstPage;
		buf += "</a>";
		buf += "<a class='toolbarMsg' href='javascript: "+pageFunc+"("+(cpnum-1)+");'>";
		buf += lang.picToolBar.prevPage;
		buf += "</a>";
	} else {
		buf += "<span class='toolbarMsg'>";
		buf += lang.picToolBar.firstPage;
		buf += "</span>";
		buf += "<span class='toolbarMsg'>";
		buf += lang.picToolBar.prevPage;
		buf += "</span>";
	}
	obj = document.getElementById("toolbar_prev");
	obj.innerHTML = buf;

	// set toolbar_next
	buf = "";
	if (cpnum < totalPage) {
		buf += "<a class='toolbarMsg' href='javascript: "+pageFunc+"("+(cpnum+1)+");'>";
		buf += lang.picToolBar.nextPage;
		buf += "</a>";
		buf += "<a class='toolbarMsg' href='javascript: "+pageFunc+"("+totalPage+");'>";
		buf += lang.picToolBar.lastPage;
		buf += "</a>";
	} else {
		buf += "<span class='toolbarMsg'>";
		buf += lang.picToolBar.nextPage;
		buf += "</span>";
		buf += "<span class='toolbarMsg'>";
		buf += lang.picToolBar.lastPage;
		buf += "</span>";
	}
	obj = document.getElementById("toolbar_next");
	obj.innerHTML = buf;

	buf = "";
	for (var i=-5 ; i<=5 ; i++) {
		var num = i + cpnum;
		if (i == 0) {
			buf += "<span class='toolbarMsg'>" + num + "</span>";
		} else if ((num >= 1) && (num <= totalPage)) {
			buf += "<a class='toolbarMsg' href='javascript: "+pageFunc+"("+num+");'>"+num+"</a>";
		}
	}
	obj = document.getElementById("toolbar_pageNum");
	obj.innerHTML = buf;
}

function updatePicToolBar(fpath) {
	var buf;
	var obj;
	var node = reqFileInfo(fpath);
	if (node.childNodes.length < 3) {
		alert("reqFileInfo failed:\n" + node.innerHTML);
		return;
	}

	obj = document.getElementById("toolbar_dirLink");
	obj.innerHTML = node.childNodes[0].innerHTML;

	var totalPage = node.childNodes[1].childNodes[0].innerHTML;
	var cpnum = node.childNodes[1].childNodes[1].innerHTML;

	var first = node.childNodes[2].childNodes[0].innerHTML;
	var prev = node.childNodes[2].childNodes[1].innerHTML;
	var next = node.childNodes[2].childNodes[2].innerHTML;
	var last = node.childNodes[2].childNodes[3].innerHTML;

	obj = document.getElementById("toolbar_totalPage");
	obj = obj.getElementsByTagName("span")[0];
	obj = obj.getElementsByTagName("span")[0];
	obj.innerHTML = totalPage;

	// set toolbar_prev
	buf = "";
	if (first.length) {
		buf += "<a class='toolbarMsg' href='javascript: showPicPage(\""+first+"\");'>";
		buf += lang.picToolBar.firstPage;
		buf += "</a>";
		buf += "<a class='toolbarMsg' href='javascript: showPicPage(\""+prev+"\");'>";
		buf += lang.picToolBar.prevPage;
		buf += "</a>";
	} else {
		buf += "<span class='toolbarMsg'>";
		buf += lang.picToolBar.firstPage;
		buf += "</span>";
		buf += "<span class='toolbarMsg'>";
		buf += lang.picToolBar.prevPage;
		buf += "</span>";
	}
	obj = document.getElementById("toolbar_prev");
	obj.innerHTML = buf;

	// set toolbar_next
	buf = "";
	if (last.length) {
		buf += "<a class='toolbarMsg' href='javascript: showPicPage(\""+next+"\");'>";
		buf += lang.picToolBar.nextPage;
		buf += "</a>";
		buf += "<a class='toolbarMsg' href='javascript: showPicPage(\""+last+"\");'>";
		buf += lang.picToolBar.lastPage;
		buf += "</a>";
	} else {
		buf += "<span class='toolbarMsg'>";
		buf += lang.picToolBar.nextPage;
		buf += "</span>";
		buf += "<span class='toolbarMsg'>";
		buf += lang.picToolBar.lastPage;
		buf += "</span>";
	}
	obj = document.getElementById("toolbar_next");
	obj.innerHTML = buf;

	buf = "<span class='toolbarMsg'>" + cpnum + "</span>";
	obj = document.getElementById("toolbar_pageNum");
	obj.innerHTML = buf;
}

