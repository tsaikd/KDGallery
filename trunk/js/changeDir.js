function setDir(fpath, cpnum) {
	var pages = "1";
	var buf = fpath.split("/");
	if (cpnum == null)
		cpnum = 1;

	for (var i=1 ; i<buf.length-1 ; i++)
		pages += ",1";
	pages += ","+cpnum;

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

