function setDir(fpath, cpnum) {
	var pages = "1";
	var buf = fpath.split("/");
	if (cpnum == null)
		cpnum = 1;

	if (buf.length > 1) {
		for (var i=1 ; i<buf.length-1 ; i++)
			pages += ",1";
		pages += ","+cpnum;
	} else {
		pages = cpnum;
	}

	setInfo("pwd", fpath);
	setInfo("pages", pages);
	setInfo("cpnum", cpnum);

	getDataContentsSync(fpath, cpnum);
}

function enterDir(name) {
	var fpath = getInfo("pwd") + "/" + name;
	var pages = getInfo("pages") + ",1";

	setInfo("pwd", fpath);
	setInfo("pages", pages);
	setInfo("cpnum", "1");

	getDataContents(fpath, 1);
}

function leaveDir(level) {
	if (level < 1)
		level = 1;
	var fpath = getInfo("pwd");
	var aPage = getInfo("pages").split(",");
	var buf = fpath.split("/");
	var pages = aPage[0];
	fpath = "data";
	for (var i=1 ; i<level ; i++) {
		fpath += "/" + buf[i];
		pages += "," + aPage[i];
	}

	setInfo("pwd", fpath);
	setInfo("pages", pages);
	var cpnum = parseInt(aPage[level-1]);
	setInfo("cpnum", cpnum);

	getDataContents(fpath, cpnum);
}

function pageDir(page) {
	var fpath = getInfo("pwd");
	var pages = getInfo("pages").split(",");

	pages[pages.length-1] = page;
	pages = pages.join(",");

	setInfo("pages", pages)
	setInfo("cpnum", page)

	getDataContents(fpath, page);
}

// num == -2 : first page if possible
// num == -1 : prev page if possible
// num == 1  : next page if possible
// num == 2  : last page if possible
function chDir(num) {
	var cpnum = parseInt(getInfo("cpnum"));
	var totalPage = parseInt(getInfo("totalPage"));

	switch (num) {
	case -2:
		if (cpnum <= 1)
			return;
		pageDir(1);
		break;
	case -1:
		if (cpnum <= 1)
			return;
		pageDir(cpnum-1);
		break;
	case 1:
		if (cpnum >= totalPage)
			return;
		pageDir(cpnum+1);
		break;
	case 2:
		if (cpnum >= totalPage)
			return;
		pageDir(totalPage);
		break;
	default:
		alert("chDir(): Invalid page number");
		break;
	}
}

// num == -2 : first pic if possible
// num == -1 : prev pic if possible
// num == 1  : next pic if possible
// num == 2  : last pic if possible
function chPic(num) {
	var obj;

	switch (num) {
	case -2:
		obj = document.getElementById("toolbar_prev").firstChild;
		break;
	case -1:
		obj = document.getElementById("toolbar_prev").lastChild;
		break;
	case 1:
		obj = document.getElementById("toolbar_next").firstChild;
		break;
	case 2:
		obj = document.getElementById("toolbar_next").lastChild;
		break;
	default:
		alert("chPic(): Invalid pic number");
		return;
	}

	var path = unescape(obj.href);
	eval(path);
}

