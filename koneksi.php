<?php
$host = "localhost";
$user = "root";
$pass = "12345678";
$dbnm = "pw2";

$conn = mysqli_connect($host, $user, $pass, $dbnm);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    echo "Koneksi berhasil!";
}
?>
