<html>
    <body>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>
    <link rel="stylesheet" href="style.css">
</head>

    <form action="submit.php" method="post" enctype="multipart/form-data">
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name"><br>

        <label for="class">Kelas:</label>
        <input type="text" id="class" name="class"><br>

        <label for="absent_number">Nomor Absen:</label>
        <input type="text" id="absent_number" name="absent_number"><br>

        <label for="photo">Foto:</label>
        <input type="file" id="photo" name="photo"><br>

        <input type="submit" value="Submit">
    </form>

    </body>
</html>