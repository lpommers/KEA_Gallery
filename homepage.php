<?php
	$link = mysqli_connect('localhost', 'kriz0001', 'kea660587#', 'kriz0001');

	if (mysqli_connect_errno()) {
		die("you didn't connect");
	}

	$query = 'SELECT * ';
	$query .= 'FROM gallery';

	$result = mysqli_query($link, $query);

	if (!$result) {
		die('You were not able to query the database');
	}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>

	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width" />
	<title>Upload your Picture !!</title>
	<link href="style.css" type="text/css" rel="stylesheet"/>
	<link href='http://fonts.googleapis.com/css?family=Rambla' rel='stylesheet' type='text/css'>

</head>

<body>
	<header>
	</header>

	<nav id="navigation">
		<ul>
			<li><a href="upload.php">Upload</a></li>
		</ul>
	</nav>

	<h1>Check out this baller image gallery:</h1>
	<div id='photos'>
	<?php
		//starts a while loop to go through every row in the database table
		while ($row = mysqli_fetch_array($result)) {
	?>


	<a href="<?php echo $row['imagename']; ?> "><img src="<?php echo $row['imagename']; ?>" alt="woo!"></a>

	<?php
		//closes the while loop.
		}
	 ?>
	</div>
	<br />
	<?php
	 	// step 4release returned data
	 	mysqli_free_result($result);
	  ?>
<body/>
</html>
<?php
	//step 5 - close the connection to mysql
	mysqli_close($link);

 ?>