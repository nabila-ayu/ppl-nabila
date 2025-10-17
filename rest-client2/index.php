<?php
//load config.php - Asumsi file ini berisi fungsi http_request_get()
include("config/config.php");
 
$api_key="5877e01441c44a8d8a1a9a63d7aed720";
$url="https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=".$api_key;
$data=http_request_get($url);
$hasil=json_decode($data,true);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rest Client dengan cURL</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .container { margin-top: 75px; }
        .error-box { 
            background-color: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
            padding: 15px; 
            border-radius: 5px; 
        }

        /* === Tambahan: ubah background navbar jadi pink soft === */
        .navbar {
            background-color: #ffcce5 !important; /* pink soft */
        }

        /* Ubah warna teks agar tetap terbaca di background pink */
        .navbar .nav-link, 
        .navbar .navbar-brand {
            color: #000 !important; /* hitam */
        }

        .navbar .nav-link:hover {
            color: #ff66a3 !important; /* sedikit lebih terang saat hover */
        }
    </style>
</head>
<body>
 
<nav class="navbar fixed-top navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="#">RestClient</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">News</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="row">
 
<?php 
if (is_array($hasil) && isset($hasil['status']) && $hasil['status'] == 'ok' && isset($hasil['articles'])) {
    foreach ($hasil['articles'] as $row) { 
?>
        <div class="col-md-4" style="margin-top: 10px; margin-bottom: 10px;">
            <div class="card" style="width: 100%;">
              <img src="<?php echo $row['urlToImage'] ?? 'placeholder.jpg'; ?>" class="card-img-top" height="180px" alt="Gambar Berita">
              <div class="card-body">
                <p class="card-text">
                    <i>Oleh <?php echo htmlspecialchars($row['author'] ?? 'N/A'); ?></i> 
                    <br>
                    <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                </p>
                <p class="text-right"><a href="<?php echo htmlspecialchars($row['url']); ?>" target="_blank">Selengkapnya..</a></p>
              </div>
            </div>
        </div>
<?php 
    } 
} else {
    echo '<div class="col-12">';
    echo '<div class="error-box">';
    echo '<h3>Error Mengambil Data API</h3>';
    if (isset($hasil['status']) && $hasil['status'] == 'error') {
        echo '<p><strong>Pesan API:</strong> ' . htmlspecialchars($hasil['message'] ?? 'Kesalahan tak teridentifikasi.') . '</p>';
        echo '<p>Pastikan API Key Anda valid dan kuota harian belum habis.</p>';
    } else {
        echo '<p>Gagal mengkonversi JSON atau response API tidak valid. (Kemungkinan error di fungsi http_request_get)</p>';
    }
    echo '</div>';
    echo '</div>';
}
?>
 
    </div>
</div>
 
<script src="js/jquery-3.4.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
