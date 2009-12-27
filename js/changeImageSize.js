function changeImageSize(url, textarea) {
	var obj = document.getElementById("mainPic");
	if (obj) {
		obj.src = url;
	}

	obj = document.getElementById("picLink");
	if (obj) {
		obj.value = textarea;
	}

}

