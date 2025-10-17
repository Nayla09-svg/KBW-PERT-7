<?php
include "koneksi.php";

if (isset($_GET['id'])) {
    $id_berita = $_GET['id'];
} else {
    die("Error. No ID Selected!");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Berita Lengkap</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php">Halaman Depan</a> |
    <a href="arsip_berita.php">Arsip Berita</a> |
    <a href="input_berita.php">Input Berita</a>
    <br><br>

    <h2>Berita Lengkap</h2>

    <?php
    $query = "
        SELECT A.id_berita, B.nm_kategori, A.judul, A.isi, 
               A.pengirim, A.tanggal
        FROM berita A
        JOIN kategori B ON A.id_kategori = B.id_kategori
        WHERE A.id_berita = '$id_berita'
    ";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $hasil = $result->fetch_assoc();

        $id_berita = htmlspecialchars($hasil['id_berita']);
        $kategori = htmlspecialchars($hasil['nm_kategori']);
        $judul = nl2br(htmlspecialchars($hasil['judul']));
        $pengirim = htmlspecialchars($hasil['pengirim']);
        $tanggal = htmlspecialchars($hasil['tanggal']);

        echo "<font size='5' color='blue'><b>$judul</b></font><br>";
        echo "<small>Dikirimkan oleh <b>$pengirim</b>, pada <b>$tanggal</b></small>";
        echo "<p><b>Kategori:</b> $kategori</p>";
        echo "<p>$hasil[isi]</p>";
    } else {
        echo "Berita tidak ditemukan.";
    }

    $conn->close();
    ?>

    <br><br>
    <p><b>Uji Coba:</b></p>
    <a href='berita_lengkap.php?id=4'>Lihat Berita dengan ID 4</a><br>
    <a href='berita_lengkap.php?id=2'>Lihat Berita dengan ID 2</a>
</body>
</html>
