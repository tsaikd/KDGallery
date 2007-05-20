<?php
function basename_ex($path) {
/* php bug: basename don't work with chinese
    return basename($path);
//*/
	return array_pop(explode("/", $path));
}
?>
