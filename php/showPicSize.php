<?php
include_once("config.php");
include_once("php/transPath.php");
include_once("php/getPathInfo.php");
include_once("php/imageSize.php");

function showPicSize($vpath, $w, $h) {
	$chk = true;
	$fpath = transPathV2R($vpath);

	while (1) {
		if (!file_exists($fpath)) {
			$chk = false;
			break;
		}

		$pw = getPathInfo($fpath, "password", true);
		if (isset($pw)) {
			$chk = false;
			break;
		}

		if (!isset($w))
			$w = 0;
		if (!isset($h))
			$h = 0;
		if (!isValidSize($w, $h)) {
			$chk = false;
			break;
		}

		if (is_dir($fpath)) {
			$chk = false;
			break;
		}

		$x = @getimagesize($fpath);
		if (!$x) {
			$chk = false;
			break;
		}

		break;
	}

	if ($chk) {
		$sw = $x[0];
		$sh = $x[1];

		if (!$w || !$h || ($w>=$sw && $h>=$sh)) {
			echo $sw."x".$sh;
		} else {
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

			echo $w."x".$h;
		}
	} else {
		echo "0x0";
	}

	return $chk;
}
?>
