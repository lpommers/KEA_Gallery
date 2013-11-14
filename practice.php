<?php
    if ($_FILES) {

        //moves uploaded file to permanent folder
        $filename = $_FILES['filename']['tmp_name'];
        $destination = $_FILES['filename']['name'];
        move_uploaded_file($filename, $destination);

        //save information
        $link=mysql_connect('localhost', 'kriz0001','kea660587#');
        mysql_select_db('kriz0001', $link);

        $username = $_POST['username'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $location = $_POST['location'];

        $sql = "INSERT INTO gallery (id, username, imagename, title, description, date, location) VALUES ('', '$username', '$destination', '$title', '$description', NOW(), '$location')";

        $result = mysql_query($sql);
        $out = '';
            if ($result) {
        $out .= 'Data has been inserted';
    }else{
        $out .= 'Data was NOT inserted';
        $out .= mysql_error();

    }
    echo $out;
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <link rel="stylesheet" href="style.css">
    <link href='http://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
</head>
<body>
    <h1>Upload Your Image here!</h1>

    <label for="#form_fields"></label>
    <form id='form_fields' action = 'practice.php' method="post" enctype = 'multipart/form-data'>
        User Name: <input type="text" name="username"><br />
        Image Title: <input type="text" name="title"><br />
        Image Description:<br /> <textarea  name="description" cols=40 rows=5>
            </textarea><br />
        Where did you take this photo? <input type="text" name="location"><br />
        Choose your file: <input type="file" name="filename"> <br/>
        <input type="submit" value="Submit">

    </form>
</body>
</html>