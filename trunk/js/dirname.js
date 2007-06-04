function dirname(path) {
	path = path.split("/");
	path.pop();
	return path.join("/");
}

