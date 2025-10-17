<?php
    //memasukan file config
    include("config.php");
 
    //url untuk lihat data
    $url="http://localhost/PPL-NABILA/rest-api/tampil_data.php";
 
    //menyimpan hasil dalam variabel
    $data=http_request_get($url); //
 
    //konversi data json ke array
    // Periksa apakah $data adalah string yang valid sebelum decoding (PENTING)
    if ($data === false || $data === "") { //
        $hasil = []; // Set $hasil ke array kosong jika gagal
        $error_message = "Gagal mengambil data dari API."; //
    } else {
        $hasil=json_decode($data,true); //
        // Periksa apakah $hasil bernilai null setelah decoding (jika format JSON salah)
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($hasil)) { //
            $hasil = []; // Set $hasil ke array kosong jika JSON invalid
            $error_message = "Data dari API tidak valid (JSON error: " . json_last_error_msg() . ")."; //
        }
    }
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Tampil Data dengan cURL</title>
</head>
<body>
    <h1>Data Pengurus dengan RestAPI</h1>
    <?php 
    // Tampilkan pesan error jika ada
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>"; //
    }
    // Pastikan $hasil adalah array sebelum loop
    if (is_array($hasil)) { //
    ?>
    <table border="2">
        <tr>
            <th>ID</th>
            <th>NAMA</th>
            <th>ALAMAT</th>
            <th>GENDER</th>
            <th>GAJI</th>
            <th>AKSI</th>
        </tr>
        <?php foreach($hasil as $row) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['alamat']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo $row['gaji']; ?></td>
            <td>
                <a href="edit_data.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="hapus_data.php?id=<?php echo $row['id']; ?>">Hapus</a>
            </td>
        </tr>
        <?php }  ?>
    </table>
    <?php 
    } // Akhir dari if (is_array($hasil))
    ?>
 
</body>
</html>