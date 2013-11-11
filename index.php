<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gallery</title>
</head>
<body>
    <form action = <?php $_SERVER['PHP_SELF'] ?> method="post" enctype = 'multipart/form-data'>
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