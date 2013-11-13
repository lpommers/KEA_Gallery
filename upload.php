<?php
	//connect to the database
	$link=mysqli_connect('localhost', 'kriz0001','kea660587#', 'kriz0001')  or die("Error " . mysqli_error($link));


	//set some defaults
	$validate = true;
	$error_msg = '';

	//only does everything if we have been given a file to upload by the user
	if ($_FILES) {

		//checks the file size of the image
		if ($_FILES['filename']['size'] > 2000000) {
			echo "too big!";
			$error_msg[] = "File is too large! Scale it down a bit there, cowboy!";
			$validate = false;
		}

		//checks the filetype of the image - only jpg, gif, and png are acceptable
		switch ($_FILES['filename']['type']) {
			case 'image/jpeg':
			case 'image/gif':
			case 'image/png':
				$validate = true;
				break;
			default:
				$validate = false;
				$error_msg[] = 'Wrong file type, amigo';
				break;
		}

		//if those two conditions are met, the file is uploaded to both the server and database
		if($validate == true){
			//moves uploaded file to permanent folder
			$filename = $_FILES['filename']['tmp_name'];
			$destination = "userimages/" . $_FILES['filename']['name'];
			move_uploaded_file($filename, $destination);


			//escapes special characters - prevents sql injection issues
			$username = mysqli_real_escape_string($link, $_POST['username']);
			$title = mysqli_real_escape_string($link, $_POST['title']);
			$description = mysqli_real_escape_string($link, $_POST['description']);
			$location = mysqli_real_escape_string($link,$_POST['location'] );


			//gets ready to insert information into the database
			$sql = "INSERT INTO gallery (id, username, imagename, title, description, date, location) VALUES ('', '$username', '$destination', '$title', '$description', NOW(), '$location')";

			//puts the data into the database
			$result = mysqli_query($link, $sql);
			$out = '';

			echo $out;
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

	<h2>	<?php
		// should print out all the error messages if there are any
		if ($validate==false) {

			foreach ($error_msg as $value) {
				echo $value;
				// echo "<script>window.alert('$value'); </script>";
				//eventually - i would like to have the error be a pop-up maybe
			}
		}
		 ?>
</h2>
	<!-- prints out the file information -->
	 <pre>
	 	<?php
	 		print_r($_FILES);
	 	 ?>
	 </pre>

	<!-- the actual form -->
    <form action = 'upload.php' method="post" enctype = 'multipart/form-data'>
    	User Name: <input type="text" name="username"><br />
    	Image Title: <input type="text" name="title"><br />
    	Image Description:<br /> <textarea  name="description" cols=30 rows=10>
   			 </textarea><br />
    	Location: <input type="text" name="location"><br />
    	Choose your file: <input type="file" name="filename" id='file_choose'> <br/>
    	<p>// Please only use .jpg, .gif, or .png files. </p>
    	<p>// Don't go over 2MB per image or a monster will get you!!!</p>
			<input type="submit" value="Submit" id='submit'>

	</form>

</body>
</html>