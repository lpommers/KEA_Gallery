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
</head>
<body>
    <form action = 'practice.php' method="post" enctype = 'multipart/form-data'>
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