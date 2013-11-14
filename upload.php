<?php
	//connect to the database
	$link=mysqli_connect('localhost', 'kriz0001','kea660587#', 'kriz0001')  or die("Error " . mysqli_error($link));

	function makeThumb($src, $dest){

		//this grabs the original file that we want to make another from - the switch just makes sure we have the right file type
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

		//determines the width and hieght of the new thumbnail
		$newHeight = ($height / 2);
		$newWidth = ($width / 2);

		//creates a temporary new image with our new dimensions
		$tempImg =imagecreatetruecolor($newWidth, $newHeight);

		//this copies the photo itself
		imagecopyresampled($tempImg, $sourceimg, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

		//we put the new thumbnail into the same filetype as the original image. We move the thumbnail to its own folder
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


	//set some defaults
	$validate = true;
	$error_msg = '';

	//only does everything if we have been given a file to upload by the user
	if ($_FILES) {
		print_r($_FILES);
		echo "before size check...validate: ".$validate."<br>";
		//checks the file size of the image
		if($_FILES['image']['size']>2000000)
	{
		$validate = false;
		$error_msg[] .= "The file is too big - haha!";
	}

		switch ($_FILES['image']['type']) {
			case 'image/jpeg':
			case 'image/gif':
			case 'image/png':
				$validate = true;
				break;
			default:
				$validate = false;
				$error_msg[] .= 'Wrong file type, amigo';
				break;
		}
		echo "after type check...validate: ".$validate."<br>";

		//if those two conditions are met, the file is uploaded to both the server and database
		if($validate){

			echo "getting ready to upload...<br>";

			$filename = $_FILES['image']['tmp_name'];

			$full_destination = "userimages/fullimages/" . $_FILES['image']['name'];
			$thumbs_destination = "userimages/thumbimages/" . $_FILES['image']['name'];
			$imagename = $_FILES['image']['name'];

			//moves files to the full images subfolder
			move_uploaded_file($filename, $full_destination);


			//escapes special characters - prevents sql injection issues
			echo "getting ready to stuff in database...<br>";

			$username = mysqli_real_escape_string($link, $_POST['username']);
			$title = mysqli_real_escape_string($link, $_POST['title']);
			$description = mysqli_real_escape_string($link, $_POST['description']);
			$location = mysqli_real_escape_string($link,$_POST['location'] );


			//gets ready to insert information into the database
			$sql = "INSERT INTO gallery (id, username, imagename, title, description, date, location) VALUES ('', '$username', '$imagename', '$title', '$description', NOW(), '$location')";
			echo $sql;
			//puts the data into the database
			$result = mysqli_query($link, $sql);
			$out = '';

			echo $out;

			makeThumb($full_destination, $thumbs_destination);
		}
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gallery</title>
	<link rel="stylesheet" href="style.css">
	<link href='http://fonts.googleapis.com/css?family=Rambla:400,700' rel='stylesheet' type='text/css'>
</head>
<body>

	<nav id="navigation">
		<ul>
			<li><a href="homepage.php">Gallery</a></li>
		</ul>
	</nav>

	<h3>	<?php
		// should print out all the error messages if there are any
		if ($validate==false) {

			foreach ($error_msg as $value) {
				echo $value;
				// echo "<script>window.alert('$value'); </script>";
				//eventually - i would like to have the error be a pop-up maybe
			}
		}
		 ?>
</h3>

	<!-- the actual form -->
    <form action = 'upload.php' method="post" enctype = 'multipart/form-data'>
    	User Name: <input type="text" name="username"><br />
    	Image Title: <input type="text" name="title"><br />
    	Image Description:<br /> <textarea  name="description" cols=30 rows=10>
   			 </textarea><br />
    	Location: <input type="text" name="location"><br />
    	Choose your file: <input type="file" name="image" id="file_choose"> <br/>
    	<p>// Please only use .jpg, .gif, or .png files. </p>
    	<p>// Don't go over 2MB per image or a monster will get you!!!</p>
			<input type="submit" value="Submit" id='submit'>

	</form>

</body>
</html>