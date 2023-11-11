<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBAH DATA SISWA</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>UBAH DATA SISWA</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rds";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $nomor = $_GET["id"];

        $sql = "SELECT * FROM students WHERE nomor = $nomor";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nama = $row["name"];
            $kelas = $row["class"];
            $absen = $row["absent_number"];
            $foto = $row["photo"];
        } else {
            echo "Data not found.";
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomor = $_POST["nomor"];
        $nama = $_POST["nama"];
        $kelas = $_POST["kelas"];
        $absen = $_POST["absen"];

        // Untuk mengelola file foto yang diunggah
        if ($_FILES["foto"]["error"] == 0) {
            $target_dir = "uploads/"; // Direktori tempat menyimpan file foto
            $target_file = $target_dir . basename($_FILES["foto"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Periksa apakah file gambar atau bukan
            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File bukan gambar.";
                $uploadOk = 0;
            }

            // Periksa apakah file sudah ada
            if (file_exists($target_file)) {
                echo "Maaf, file sudah ada.";
                $uploadOk = 0;
            }

            // Batasi ukuran file
            if ($_FILES["foto"]["size"] > 500000) {
                echo "Maaf, ukuran file terlalu besar.";
                $uploadOk = 0;
            }

            // Hanya izinkan format gambar tertentu
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.";
                $uploadOk = 0;
            }

            // Jika semua valid, upload file
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                    $foto = $target_file;
                } else {
                    echo "Maaf, terjadi kesalahan saat mengunggah file.";
                }
            }
        }

        // Update data ke database
        $sql = "UPDATE students SET name='$nama', class='$kelas', absent_number='$absen', photo='$foto' WHERE nomor=$nomor";

        if ($conn->query($sql) === TRUE) {
            echo "Data updated successfully. <a href='index.php?id=$nomor'>Back to Profile</a>";
        } else {
            echo "Error updating data: " . $conn->error;
        }
    }

    $conn->close();
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <input type="hidden" name="nomor" value="<?php echo $nomor; ?>">

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>" required>

        <label for="kelas">Kelas:</label>
        <input type="text" id="kelas" name="kelas" value="<?php echo $kelas; ?>" required>

        <label for="absen">Nomor Absen:</label>
        <input type="text" id="absen" name="absen" value="<?php echo $absen; ?>" required>

        <label for="foto">Foto:</label>
        <input type="file" name="foto" id="foto">

        <input type="submit" value="Ubah Data">
    </form>
</body>

</html>
