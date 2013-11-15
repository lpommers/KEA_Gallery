 <?php
	//connect to the database
	$link=mysqli_connect('localhost', 'kriz0001','kea660587#', 'kriz0001')  or die("Error " . mysqli_error($link));

	require_once("functions.php");


	//set some defaults for the validation and error messages
	$validate = true;
	$error_msg = '';

	//checks to see if we have been given a file by the user
	if ($_FILES) {


		print_r($_FILES);
		echo $full_destination;
		echo "before size check...validate: ".$validate."<br>";

		//checks the file size of the image - sets validate to false if it is too large
		if($_FILES['image']['size']>2000000){
		$validate = false;
		$error_msg[] .= "The file is too big - haha!";
		}

		//checks the type of the image - sets to false if the wrong type
		switch ($_FILES['image']['type']) {
			case 'image/jpeg':
				$validate = true;
				break;
			case 'image/gif':
				$validate = true;
				break;
			case 'image/png':
				$validate = true;
				break;
			default:
				$validate = false;
				$error_msg[] .= 'Wrong file type, amigo';
				break;
		}
		echo "after type check...validate: ".$validate."<br>";

		//checks if the file is already on the server - if it is - validate is set to false
		if (file_exists("userimages/fullimages/" . $_FILES['image']['name'])) {
			$validate = false;
			$error_msg[] .= " this file already exists on the server";
		}

		//if those two conditions are met, the file is uploaded to both the server and database
		if($validate == true){

			echo "getting ready to upload...<br>";

			//temp name
			$filename = $_FILES['image']['tmp_name'];
			//sets a url for our full size images
			$full_destination = "userimages/fullimages/" . $_FILES['image']['name'];
			//sets a url for our thumbnail images
			$thumbs_destination = "userimages/thumbimages/" . $_FILES['image']['name'];
			//the permanent name of the img
			$imagename = $_FILES['image']['name'];

			//moves files to the full images subfolder
			move_uploaded_file($filename, $full_destination);

			echo "getting ready to stuff in database...<br>";
			//escapes special characters - prevents sql injection issues
			$username = mysqli_real_escape_string($link, $_POST['username']);
			$title = mysqli_real_escape_string($link, $_POST['title']);
			$description = mysqli_real_escape_string($link, $_POST['description']);
			$location = mysqli_real_escape_string($link,$_POST['location'] );


			//gets ready to insert information into the database
			$sql = "INSERT INTO gallery (id, username, imagename, title, description, date, location) VALUES ('', '$username', '$imagename', '$title', '$description', NOW(), '$location')";
			echo $sql;
			//actually puts the informationg into the database
			$result = mysqli_query($link, $sql);
			$out = '';

			echo $out;

			//calls the method which will make our thumbnail and put it in the right folder on our server
			make_thumb($full_destination, $thumbs_destination);
		}
	}

 ?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gallery</title>
	<link rel="stylesheet" href="style.css">
	<link href='http://fonts.googleapis.com/css?family=Rambla:400,700' rel='stylesheet' type='text/css'>
 </head>

<body>
	<header>
		<img id ='logo' src="photogallery.png" alt="">
	</header>
  <nav id="navigation">
 		<ul>
			<li><a href="homepage.php">Gallery</a></li>
		</ul>
 	</nav>

 	<h3 id = 'errors'>

 		<?php
		// should print out all the error messages if there are any
		if ($validate==false) {

			foreach ($error_msg as $value) {
				echo $value;

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
    		<p class="red"> // Please only use .jpg, .gif, or .png files. </p>
    		<p class="red"> // Don't go over 2MB per image or a monster will get you!!!</p>
			<input type="submit" value="Submit" id='submit'>

	</form>
</body>
</html>