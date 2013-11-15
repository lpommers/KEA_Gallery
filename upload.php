 <?php
	/**
	 * [$link = a variable that connects to our database - if it does not there is an error and the whole page fails]
	 */
	$link=mysqli_connect('localhost', 'kriz0001','kea660587#', 'kriz0001')  or die("Error " . mysqli_error($link));

	/**
	 * this brings in our make_thumbs function that will be used to create our small thumbnail images
	 */
	require_once("functions.php");

	/**
	 * [$validate description = a default value that is set to true. We will use this to make sure the uploaded file meets our requirements. If it does not we will set this value to false]
	 * [$error_msg = We will use this to hold all of our error messages regarding size,type, or if it is already on the server. It is displayed later in the html]
	 */
	$validate = true;
	$error_msg = '';

	//checks to see if we have been given a file by the user. If so, we will move it to the server, put the info into the database and create a thumbnail
	if ($_FILES == true) {

		/**
		 * just some testing stuff that we will get rid of when everything is right
		 */
		print_r($_FILES);
		echo $full_destination;
		echo "before size check...validate: ".$validate."<br>";

		//checks the file size of the image - if it is bigger than 2mb, we set $validate to false and add an error message to our $error_msg string
		if($_FILES['image']['size']>2000000){
			$validate = false;
			$error_msg[] .= "The file is too big - haha!";
		}

		//checks the type of the image - if it is not .jpg, .gif, or .png we will set $validate to false and update our $error_msg with a wrong type message
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

		//checks if the file is already on the server - if it is - validate is set to false and we update our error message
		if (file_exists("userimages/fullimages/" . $_FILES['image']['name'])) {
			$validate = false;
			$error_msg[] .= " this file already exists on the server";
		}

		//now we check our $validate value. We only want to continue if it passed all our requirement tests - so if it was set to false at any point we won't continue beyond this point
		if($validate == true){

			echo "getting ready to upload...<br>";

			//temp name
			/**
			 * [$filename is just a name we give for the tmp_name that php is creating before the file is uploaded ]
			 */
			$filename = $_FILES['image']['tmp_name'];

			//creates a variable that holds a url path for our full size images
			$full_destination = "userimages/fullimages/" . $_FILES['image']['name'];

			//creates a variable that holds a url for our thumbnail images
			$thumbs_destination = "userimages/thumbimages/" . $_FILES['image']['name'];

			//a variable that holds just the name of the image
			$imagename = $_FILES['image']['name'];

			//moves the uploaded file ($filename) to our server at our full destination path ($full_destination)
			move_uploaded_file($filename, $full_destination);

			echo "getting ready to stuff in database...<br>";

			//gets the user input from our form text fields using POST method. We create variables to hold the user input from each 'name' that we gave when creating the form input field
			$username = mysqli_real_escape_string($link, $_POST['username']);
			$title = mysqli_real_escape_string($link, $_POST['title']);
			$description = mysqli_real_escape_string($link, $_POST['description']);
			$location = mysqli_real_escape_string($link,$_POST['location'] );


			//we get ready to talk to our database. We get ready to INSERT some VALUES into our 'gallery' table. We want to input the variables we just created on lines 81-84 into the table
			$sql = "INSERT INTO gallery (id, username, imagename, title, description, date, location) VALUES ('', '$username', '$imagename', '$title', '$description', NOW(), '$location')";
			echo $sql;


			//here we actually talk to the database - we say which database we want to talk to with $link (our connection) and what we want to say to our database with $sql (what we are actually going to input into our 'gallery' table)
			$result = mysqli_query($link, $sql);
			$out = '';

			echo $out;

			/**
			 * this calls the function that we created that will take the just uploaded image and create a small thumbnail version of that image. the two arguments it takes are:
			 *
			 * @{$full_destination} = the url path to the image we want to make a copy of
			 * @{$thumbs_destination} = a url path to the new thumbnail image  we are creating
			 */
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

 	<h3>
 		<p class="red" id ='errors'>

 		<?php
		// here is where we will print our any of the error messages to the user if there have been any.
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