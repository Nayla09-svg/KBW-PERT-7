<?php
include "koneksi.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error. No Id Selected!");
}

$id_berita = $_GET['id'];

$stmt = $conn->prepare("
    SELECT A.id_berita,
           A.id_kategori, A.judul,
           A.headline, A.isi,
           A.pengirim, A.tanggal,
           B.nm_kategori
    FROM berita A
    JOIN kategori B ON
    A.id_kategori = B.id_kategori
    WHERE A.id_berita = ?
");
$stmt->bind_param("i", $id_berita);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Data tidak ditemukan");
}

$hasil = $result->fetch_assoc();
$id_kategori = $hasil['id_kategori'];
$judul = $hasil['judul'];
$headline = $hasil['headline'];
$isi = $hasil['isi'];
$pengirim = $hasil['pengirim'];

if (isset($_POST['edit'])) {
    $judul_input = strip_tags($_POST['judul']);
    $kategori_input = $_POST['kategori'];
    $headline_input = strip_tags($_POST['headline']);
    $isi_input = $_POST['isi'];
    $pengirim_input = strip_tags($_POST['pengirim']);

    $update_stmt = $conn->prepare("
        UPDATE berita SET
        id_kategori = ?,
        judul = ?,
        headline = ?,
        isi = ?,
        pengirim = ?
        WHERE id_berita = ?
    ");
    $update_stmt->bind_param("issssi", $kategori_input, $judul_input, $headline_input, $isi_input, $pengirim_input, $id_berita);

    if ($update_stmt->execute()) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='arsip_berita.php';</script>";
    } else {
        echo "<p>Error updating data.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Berita</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php">Halaman Depan</a> |
    <a href="arsip_berita.php">Arsip Berita</a> |
    <a href="input_berita.php">Input Berita</a>
    <br><br>

    <?php if (isset($pesan)) echo $pesan; ?>

    <form action="" method="POST" name="input">
        <table cellpadding="0" cellspacing="0" border="0" width="70%">
            <tr>
                <td colspan="2"><h2>Edit Berita</h2></td>
            </tr>
            <tr>
                <td width="200">Judul Berita</td>
                <td>
                    <input type="text" name="judul" size="30" 
                    value="<?php echo htmlspecialchars($judul); ?>">
                </td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>
                    <select name="kategori">
                        <?php
                        $kategori_result = $conn->query("SELECT id_kategori, nm_kategori FROM kategori ORDER BY nm_kategori");
                        while ($row = $kategori_result->fetch_assoc()) {
                            $selected = ($row['id_kategori'] == $id_kategori) ? "selected" : "";
                            echo "<option value='{$row['id_kategori']}' $selected>{$row['nm_kategori']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Headline</td>
                <td><textarea name="headline" cols="50" rows="4"><?php echo htmlspecialchars($headline); ?></textarea></td>
            </tr>
            <tr>
                <td>Isi Berita</td>
                <td><textarea name="isi" cols="50" rows="10"><?php echo htmlspecialchars($isi); ?></textarea></td>
            </tr>
            <tr>
                <td>Pengirim</td>
                <td><input type="text" name="pengirim" size="20" 
                    value="<?php echo htmlspecialchars($pengirim); ?>"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" name="id_berita" value="<?php echo $id_berita; ?>">
                    <input type="submit" name="input" value="Edit Berita">
                    <input type="reset" name="input2" value="Cancel">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>