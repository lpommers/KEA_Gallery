<?php
	$link = mysqli_connect('localhost', 'kriz0001', 'kea660587#', 'kriz0001');

	if (mysqli_connect_errno()) {
		die("you didn't connect");
	}

	$variable = $_GET['imagename'];

	echo $variable;

	$query = 'SELECT * ';
	$query .= 'FROM gallery';
	$query .= " WHERE imagename='$variable'";

	$result = mysqli_query($link, $query);

	$row = mysqli_fetch_array($result);

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
	<nav id="navigation">
		<ul>
			<li><a href="homepage.php">Gallery</a></li>
		</ul>
	</nav>

	<h1>Here's your full size image</h1>
	<div id = 'full_wrapper'>

		<p class = 'full_text'> <?php echo $row['title']; ?> </p>
		<img id='image_full' src="<?php echo $_GET['fullimage']; ?>" alt="">
		<p class = 'full_text'>Description:  <?php echo $row['description']; ?> </p>
		<p class = 'full_text'>Location: <?php echo $row['location']; ?> </p>


	</div>
</body>
</html>

