<?php

function make_thumb($src, $dest){

	//this grabs the original file that we want to make a smaller version of - the switch here just makes sure we have the right file type
	switch ($_FILES['image']['type']) {
		case 'image/jpeg':
			$sourceimg = imagecreatefromjpeg($src);
			break;
		case 'image/gif':
			$sourceimg = imagecreatefromgif($src);
			break;
		case 'image/png':
			$sourceimg = imagecreatefrompng($src);
			break;
		default:
			echo "we've got some problems here";
			break;
	}

	//determines the width and height of the source image
	$width = imagesx($sourceimg);
	$height = imagesy($sourceimg);

	//determines the width and hieght of our new thumbnail
	$newHeight = ($height / 2);
	$newWidth = ($width / 2);

	//creates a temporary new image with our new dimensions
	$tempImg =imagecreatetruecolor($newWidth, $newHeight);

	//this copies the photo itself - what it actally looks like
	imagecopyresampled($tempImg, $sourceimg, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

	//we put the new thumbnail into the same filetype as the original image. We also move the thumbnail to its own folder
	switch ($_FILES['image']['type']) {
		case 'image/jpeg':
			imagejpeg($tempImg, $dest);
			break;
		case 'image/gif':
			imagegif($tempImg, $dest);
			break;
		case 'image/png':
			imagepng($tempImg, $dest);
			break;
		default:
			echo "we've got some more problems here";
			break;
	}
}
?>