<?php
	if ($_FILES) {

		//moves uploaded file to permanent folder
		$filename = $_FILES['file']['tmp_name'];
		$destination = $_FILES['file']['name'];
		move_uploaded_file($filename, $destination);

		//save information
		$link=mysql_connect('localhost', 'kriz001','kea660587#');
		mysql_select_db('kriz001', $link);

		$username = $_POST['username'];
		$title = $_POST['title'];
		$description = $_POST['description'];
		$location = $_POST['location'];

		$sql = "INSERT INTO gallery (id, username, imagename, title, description, date, location) VALUES ('', '$username', '$destination', '$title', '$description', 'NOW()', $location)";

		$result = mysql_query($sql);

	}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gallery</title>
</head>
<body>
    <form action = <?php $_SERVER['PHP_SELF']; ?> method="post" enctype = 'multipart/form-data'>
    	User Name <input type="text" name="username"><br />
    	Image Title <input type="text" name="title"><br />
    	Image Description <textarea  name="description" cols=30 rows=10>
    </textarea><br />
    	Location <input type="text" name="location"><br />
    	Choose your file <input type="file" name="filename"> <br/>
		<input type="submit" value="Submit">

	</form>
</body>
</html>