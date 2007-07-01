function hotkey(e) {
	var k = e.keyCode;

	switch (k) {
	case 90: // z
		if (e.altKey || e.ctrlKey || e.shiftKey)
			return;
		isPicMode() ? chPic(-2) : chDir(-2);
		break;
	case 88: // x
		if (e.altKey || e.ctrlKey || e.shiftKey)
			return;
		isPicMode() ? chPic(-1) : chDir(-1);
		break;
	case 67: // c
		if (e.altKey || e.ctrlKey || e.shiftKey)
			return;
		isPicMode() ? chPic(1) : chDir(1);
		break;
	case 86: // v
		if (e.altKey || e.ctrlKey || e.shiftKey)
			return;
		isPicMode() ? chPic(2) : chDir(2);
		break;
	case 66: // b
		if (e.altKey || e.ctrlKey || e.shiftKey)
			return;
		var cdlv = parseInt(getInfo("cdlv"));
		leaveDir(cdlv-1);
		break;
	}
//alert(k);
}

