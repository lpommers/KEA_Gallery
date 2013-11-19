<?php
	//here we connect to the database and set it to a variable called $link
	$link = mysqli_connect('localhost', 'kriz0001', 'kea660587#', 'kriz0001');

	//if there is an error connecting to the database - an error is immediately returned to the user and the php dies - it will go no further
	if (mysqli_connect_errno()) {
		die("you didn't connect");
	}

	//just like in our uploads file - we get ready to talk to the database. We don't actually talk to the datebase. we create a variable called $query that says we want to SELECT ALL the data from ALL the columns in our gallery
	$query = 'SELECT ';
	$query .= 'FROM gallery';

	//here is where we actually talk to the database. say which database we want to talk to (our $link database) and we tell it what to say with our $query variable which says to SELECT ALL the data from ALL the columns in our gallery table
	$result = mysqli_query($link, $query);

	//if we aren't able to talk to the database the user gets an error and the php dies
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
	<link href='http://fonts.googleapis.com/css?family=Rambla:400,700' rel='stylesheet' type='text/css'>

</head>

<body>
	<header>
		<img id ='logo' src="photogallery.png" alt="">
		
	</header>

	<nav id="navigation">
		<ul>
			<li><a href="upload.php">Upload</a></li>
		</ul>
	</nav>
	<h1>Check out this baller image gallery:</h1>
	<h2>Click on image to see the full size.</h2>
	<div id='photos'>
	<?php
		//we open php and create a loop that will run ONLY while there are still rows of information we haven't done anything with.
		while ($row = mysqli_fetch_array($result)) {
		//we close php to set up our html tags, but will reopen it soon
	?>

		<!-- first we create a <a> tag that links (where it goes) to our full view page. We send the image name along with that link with the GET method.. It sends the imagename to the full image page so it can display the right image once it gets there. then we grab the specific image we want to display in the hompage gallery from the thumbimages folder and display it -->
	<a href="fullimage.php?imagename=<?php echo $row['imagename']; ?> "><img src="userimages/thumbimages/<?php echo $row['imagename']; ?>" alt="woo!"></a>


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