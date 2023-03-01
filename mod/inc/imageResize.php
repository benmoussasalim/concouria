<?php

function resizeImage($imageSrc, $serverPath, $absolutePath) {
	$pathinfo = pathinfo($imageSrc);
	
	if (!file_exists($serverPath."resized_".$pathinfo['basename'])) {
		$im = new Imagick(str_replace(' ', '%20', $imageSrc));


		$im->trimImage(10000);

		$im->writeImage($serverPath."resized_".$pathinfo['basename']);
	}

	return $absolutePath."resized_".$pathinfo['basename'];
}