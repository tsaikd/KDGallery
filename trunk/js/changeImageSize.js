function changeImageSize(url) {
	var obj = document.getElementById("mainPic");
	if (!obj)
		return;
	obj.src = url;
}

