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


		<img id='image_full' src="<?php echo $_GET['imagename']; ?>" alt="">



	</div>
</body>
</html>

