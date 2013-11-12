<?php
	//connect to the database
	$link=mysql_connect('localhost', 'kriz0001','kea660587#');
	mysql_select_db('kriz0001', $link);

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


			//adds the file information to the database
			$username = $_POST['username'];
			$title = $_POST['title'];
			$description = $_POST['description'];
			$location = $_POST['location'];

			$sql = "INSERT INTO gallery (id, username, imagename, title, description, date, location) VALUES ('', '$username', '$destination', '$title', '$description', NOW(), '$location')";

			//just a test to see if you were able to query the database
			$result = mysql_query($sql);
			$out = '';

			echo $out;
		}
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width" />
	<title>Gallery</title>
	<link rel="stylesheet" href="style.css">
	<link href='http://fonts.googleapis.com/css?family=Rambla' rel='stylesheet' type='text/css'>
</head>
<body>

	<?php
	// should print out all the error messages if there are any
	if ($validate==false) {

		foreach ($error_msg as $value) {
			echo $value;
			// echo "<script>window.alert('$value'); </script>";
			//eventually - i would like to have the error be a pop-up maybe
		}
	}
	 ?>

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
    	Choose your file: <input type="file" name="filename"> <br/>
    	<p>Please only use .jpg, .gif, or .png files - and don't go over 2mb or a monster will get you!!!</p>
		<input type="submit" value="Submit">

	</form>
</body>
</html>