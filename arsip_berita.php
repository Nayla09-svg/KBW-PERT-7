<?php
include "koneksi.php";
?>
<html>
<head>
    <title>Arsip Berita</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function tanya() {
            return confirm("Apakah Anda yakin akan menghapus berita ini?");
        }
    </script>
</head>
<body>
    <a href="index.php">Halaman Depan</a> |
    <a href="arsip_berita.php">Arsip Berita</a> |
    <a href="input_berita.php">Input Berita</a>
    <br><br>

    <h2>Arsip Berita</h2>
    <ol>
    <?php
    $query = "
        SELECT A.id_berita, B.nm_kategori, A.judul, A.pengirim, A.tanggal
        FROM berita A
        JOIN kategori B ON A.id_kategori = B.id_kategori
        ORDER BY A.id_berita DESC
    ";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($hasil = $result->fetch_assoc()) {
            $id_berita = $hasil['id_berita'];
            $kategori = stripslashes($hasil['nm_kategori']);
            $judul = stripslashes($hasil['judul']);
            $pengirim = stripslashes($hasil['pengirim']);
            $tanggal = stripslashes($hasil['tanggal']);

            echo "<li>
                <a href='berita_lengkap.php?id=$id_berita'>$judul</a><br>
                <small>
                    Berita dikirimkan oleh <b>$pengirim</b> pada tanggal <b>$tanggal</b>
                    dalam kategori <b>$kategori</b><br>
                    <b>Action:</b>
                    <a href='edit_berita.php?id=$id_berita'>Edit</a> |
                    <a href='delete_berita.php?id=$id_berita' onClick='return tanya()'>Delete</a>
                </small>
            </li><br><br>";
        }
    } else {
        echo "<p>Belum ada berita yang ditambahkan.</p>";
    }

    $conn->close();
    ?>
    </ol>
</body>
</html>

<link rel="stylesheet" href="style.css">
