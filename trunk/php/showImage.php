<?php
include_once("config.php");
include_once("php/transPath.php");
include_once("php/imageSize.php");
include_once("php/getPathInfo.php");

function showErrorImage($type, $w, $h) {
	$vpath = "icon/$type.png";
	$fpath = transPathV2R($vpath);
	if (!file_exists($fpath)) {
		$vpath = "icon/question.png";
		$fpath = transPathV2R($vpath);

		if (!file_exists($fpath))
			return;
	}

	return showImage($fpath, $w, $h, IMAGETYPE_PNG);
}

function showImage($vpath, $w, $h, $ctype=IMAGETYPE_JPEG) {
	$fpath = transPathV2R($vpath);
	if (!file_exists($fpath))
		return showErrorImage("file_not_exists", $w, $h);
	$pw = getPathInfo($fpath, "password", true);
	if (isset($pw))
		return showErrorImage("password_protect", $w, $h);
	if (!isset($w))
		$w = 0;
	if (!isset($h))
		$h = 0;
	if (!isValidSize($w, $h))
		return showErrorImage("invalid_size", 200, 200);

	if (is_dir($fpath))
		return showErrorImage("path_is_dir", $w, $h);
	else
		$img = $fpath;

	$fname = basename_ex($img);

	global $CONF;
	if ($CONF["cache"]["enable"] && $CONF["cache"]["image"]["enable"]) {
		$cpath = sprintf("%s/%s_%d_%d.cache"
			, $CONF["path"]["cache"]
			, transPathV2Id($vpath)
			, $w
			, $h
		);

		if (file_exists($cpath)) {
			$ftime = filectime($cpath);
			header('Last-Modified: '.date(DATE_RFC2822, $ftime));
			header('Expires: '.date(DATE_RFC2822, $ftime+86400));
			header('Content-Disposition: filename="'.$w.'x'.$h.'_'.$fname.'"');
			header("Content-type: ".image_type_to_mime_type($ctype));
			readfile($cpath);
			return;
		}
	}

	$x = @getimagesize($img);
	if (!$x)
		return showErrorImage("unknown_image_type", $w, $h);
	$sw = $x[0];
	$sh = $x[1];
	$mime = $x["mime"];

	if (!$w || !$h || ($w>=$sw && $h>=$sh)) {
		$ftime = filectime($img);
		header('Last-Modified: '.date(DATE_RFC2822, $ftime));
		header('Expires: '.date(DATE_RFC2822, $ftime+86400));
		header('Content-Disposition: filename="'.$fname.'"');
		header("Content-type: ".$mime);
		readfile($img);
		return;
	}

	// get the smaller resulting image dimension
	$hx = (100 / ($sw / $w)) * 0.01;
	$hx = @round($sh * $hx);

	$wx = (100 / ($sh / $h)) * 0.01;
	$wx = @round($sw * $wx);

	if ($hx < $h) {
		$percent = (100 / ($sw / $w)) * 0.01;
		$h = @round($sh * $percent);
	} else {
		$percent = (100 / ($sh / $h)) * 0.01;
		$w = @round($sw * $percent);
	}

	$im = @ImageCreateFromJPEG($img) or // Read JPEG Image
	$im = @ImageCreateFromPNG($img) or // or PNG Image
	$im = @ImageCreateFromGIF($img) or // or GIF Image
	$im = false; // If image is not JPEG, PNG, or GIF
	$ftime = filectime($img);
	header('Last-Modified: '.date(DATE_RFC2822, $ftime));
	header('Expires: '.date(DATE_RFC2822, $ftime+86400));
	header('Content-Disposition: filename="'.$w.'x'.$h.'_'.$fname.'"');
	if (!$im) {
		return showErrorImage("image_create_failed", $w, $h);
		// We get errors from PHP's ImageCreate functions...
		// So let's echo back the contents of the actual image.
		header("Content-type: ".$mime);
		readfile($img);
	} else {
		// Create the resized image destination
		$thumb = ImageCreateTrueColor($w, $h);

		// Setup Transparent
		if ($ctype == IMAGETYPE_PNG) {
/* ref: http://alexle.net/archives/131
			$background = ImageColorAllocate($thumb, 0, 0, 0);
			ImageColorTransparent($thumb, $background);
//*/
			ImageAlphaBlending($thumb, false);
			ImageSaveAlpha($thumb, true);
		}

		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled($thumb, $im, 0, 0, 0, 0, $w, $h, $sw, $sh);
		// Output resized image
		header("Content-type: ".image_type_to_mime_type($ctype));

		if ($ctype == IMAGETYPE_PNG) {
			ImagePNG($thumb);
			if (isset($cpath)) {
				ImagePNG($thumb, $cpath);
				addCacheInfo($cpath);
			}
		} else {
			ImageJPEG($thumb);
			if (isset($cpath)) {
				ImageJPEG($thumb, $cpath, 50);
				addCacheInfo($cpath);
			}
		}
/*
		@ImageJPEG($thumb);
		if (isset($cpath))
			@ImageJPEG($thumb, $cpath);
//*/
	}
}
?>
