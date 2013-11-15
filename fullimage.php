<?php
	//here we connect to our database -- we do this on every page
	$link = mysqli_connect('localhost', 'kriz0001', 'kea660587#', 'kriz0001');

	//if we don't connect - an error is returned
	if (mysqli_connect_errno()) {
		die("you didn't connect");
	}

	//here we go up to the url and get the information that comes up directly after the "imagename=" in the url. we set it to a variable called imagename
	$imagename = $_GET['imagename'];

	//here we get ready to talk to our database. We say we want to collect all the column information (id, title, description, ect.) for one specific row - and that row is the one that we have been given in the url
	$query = 'SELECT * ';
	$query .= 'FROM gallery';
	$query .= " WHERE imagename='$imagename'";

	//we actually talk to the database - which database? - out $link database, and what do we say - we say the information in our $query variable - which says to get all the information for one specific role
	$result = mysqli_query($link, $query);

	//this creates an array of all that row information
	$row = mysqli_fetch_array($result);

	//if we cannot make a query to the database - we get an error
	if (!$result) {
		die('You were not able to query the database');
	}

?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width" />
	<title>Full Screen image</title>
	<link href="style.css" type="text/css" rel="stylesheet"/>
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

	<h1>Here's your full size image</h1>
	<div id = 'full_wrapper'>

	 <!-- now we just grab the information we want and display it where we want -->
		<p class = 'full_text'> <?php echo $row['title']; ?> </p>
		<img id='image_full' src="userimages/fullimages/<?php echo $_GET['imagename']; ?>" alt="">
		<p class = 'full_text'>Description:  <?php echo $row['description']; ?> </p>
		<p class = 'full_text'>Location: <?php echo $row['location']; ?> </p>


	</div>
</body>
</html>

