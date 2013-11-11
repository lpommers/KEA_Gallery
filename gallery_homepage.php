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

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title> Image Gallery</title>
</head>
<body>
	<h1>Here's our image gallery</h1>
	<pre>
	<?php
		while ($row = mysqli_fetch_array($result)) {

	?>

		<img src="<?php echo $row['imagename']; ?>" alt="why isn't this working">
	<?php
		}
	 ?>
	</pre>

	<?php
	 	// step 4release returned data
	 	mysqli_free_result($result);
	  ?>
</body>
</html>

<?php
	//step 5 - close the connection to mysql
	mysqli_close($connection);

 ?>