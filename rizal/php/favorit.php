<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Wishlist</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      background-color: rgba(223,223,225,255);
    }

    button {
      background-color: #4eb5de;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .navbar {
      background: rgba(240,240,241,255);
      padding: 20px 0;
      border-bottom: 1px solid #ccc;
      text-align: center;
    }

    .judul-navbar {
      font-size: 30px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .subnav {
      display: flex;
      justify-content: center;
    }

    .subnav ul {
      display: flex;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .subnav ul li {
      margin: 0 15px;
    }

    .subnav ul li a {
      color: black;
      text-decoration: none;
    }

    .subnav ul li a:hover {
      text-decoration: underline;
    }

    .search-container {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      margin-top: 80px;
    }

    .search-container input[type="text"] {
      width: 400px;
      height: 12px;
      padding: 12px;
      font-size: 16px;
      border: 2px solid #000;
      border-radius: 4px;
      color: #000;
    }

    .filter-wrapper {
      position: relative;
      display: inline-block;
      margin-left: 10px;
    }

    #filter-panel {
      display: none;
      position: absolute;
      top: 100%; /* tepat di bawah tombol */
      left: 0;
      width: 300px;
      background-color: rgba(255, 255, 255, 0.95);
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
      padding: 15px;
      border-radius: 8px;
      z-index: 2000;
    }

    #filter-panel.show {
      display: block;
    }

    .filter-group {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 100px;
    }

    .filter-section {
      flex: 1 1 220px;
      background-color:  #4eb5de;
      padding: 10px;
      border-radius: 6px;
      width: 280px; /* agar muat di panel */
      box-sizing: border-box;
    }

    .filter-section p {
      font-weight: bold;
      color: #145555;
      margin-bottom: 10px;
    }

    label {
      display: block;
      margin: 4px 0;
      color: white;
    }

    .garis-bawah {
      width: 50%;
      margin: 10px auto;
      border: 1px solid #000;
    }




    /* produk */
    .product-container {
      width: 50%;
      margin: 0 auto;
    }

    .product-card {
      display: flex;
      background-color: #ffffff;
      color: rgb(0, 0, 0);
      margin-top: 20px;
      padding: 10px;
      border-radius: 8px;
    }

    .product-info {
      margin-left: 20px;
      flex: 1;
    }

    .product-info h2 {
      margin: 0 0 5px 0;
    }

    .product-info p {
      margin: 5px 0;
    }

    .product-info del {
      color: #ffffff;
    }

    .product-info .discount {
      color: #00ff00;
      font-weight: bold;
    }

    .product-info button {
      background-color:  #4eb5de;
      color: rgb(0, 0, 0);
      padding: 8px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }


    .produk-gambar {
    width: 100%;
    max-width: 320px; 
    height: auto;
    display: block;
    margin: 10px auto;
}


/*if tidak ada prudok */
.empty-message {
  text-align: center;
  margin: 40px auto;
  font-size: 18px;
  color: #555;
  max-width: 400px;
  line-height: 1.5;
}
.empty-message p {
  margin: 8px 0;
}
</style>
</head>
<body>
<!-- Header -->
<header class="navbar">
  <div class="judul-navbar"><strong>WISHLIST</strong></div>
  <div class="subnav">
    <ul>
      <li><a href="index.php">Toko</a></li>
      <li><a href="keranjang.php">Keranjang</a></li>
    </ul>
  </div>
</header>
<!-- Search -->
<div class="search-container">
  <input type="text" id="searchInput" placeholder="Cari di wishlist..." onkeyup="filterWishlist()">



  <div class="filter-wrapper">
    <button id="toggle-button">Opsi ▼</button>
    <div id="filter-panel" class="hidden">
      <div class="filter-group">
        <div class="filter-section">
          <p>Kategori</p>
          <label><input type="radio" name="lihat" value="all" checked> Semua</label>
          <label><input type="radio" name="lihat" value="oli"> Oli</label>
          <label><input type="radio" name="lihat" value="ban"> Ban</label>
          <label><input type="radio" name="lihat" value="gear"> Gear</label>

          <p>Diskon</p>
          <label><input type="radio" name="diskon" value="asc" checked> harga mulai dari termurah </label>
          <label><input type="radio" name="diskon" value="desc"> harga mulai dari termahal</label>
        </div>
      </div>
    </div>
  </div>
</div>



<hr class="garis-bawah" />
<!-- PRODUK -->
<div class="product-container" id="product-list">
<?php
$favorit = $koneksi->query("SELECT produk.* FROM produk JOIN favorit ON produk.id = favorit.produk_id");
if ($favorit->num_rows === 0): ?>
  <div class="empty-message">
    <p><strong>Wishlist-mu kosong.</strong></p>
    <p>Isi wishlist dengan menelusuri toko dan menggunakan tombol “hati”.</p>
  </div>
<?php else:
  while ($row = $favorit->fetch_assoc()):
?>
  <div class="product-card" data-judul="<?= strtolower($row['judul']) ?>">
    <div class="product-info">
      <h2><?= $row['judul'] ?></h2>
      <?php if ($row['gambar']): ?>
        <img src="gambar/<?= $row['gambar'] ?>" alt="<?= $row['judul'] ?>" class="produk-gambar">
      <?php endif; ?>
      <p><strong>Deskripsi:</strong> <?= $row['deskripsi'] ?></p>
      <p><strong>Kategori:</strong> <?= $row['kategori'] ?></p>
      <span style="font-size: 18px; font-weight: bold;">Rp <?= number_format($row['harga'], 0, ',', '.') ?></span>
      <br />
      <a href="tambah_keranjang.php?id=<?= $row['id'] ?>"><button>Masuk Keranjang</button></a>
      <a href="hapus_favorit.php?id=<?= $row['id'] ?>"><button style="background:red; color:white;">Hapus</button></a>
    </div>
  </div>
<?php endwhile; endif; ?>
</div>

<script>
function filterWishlist() {
  const keyword = document.getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('.product-card').forEach(card => {
    const judul = card.getAttribute('data-judul');
    card.style.display = judul.includes(keyword) ? '' : 'none';
  });
}




  // Event toggle filter panel
  const toggleBtn = document.getElementById('toggle-button');
const filterPanel = document.getElementById('filter-panel');
  toggleBtn.addEventListener('click', () => {
    filterPanel.classList.toggle('show');
  });

   // Event render ulang saat filter berubah
  document.querySelectorAll('input[name="lihat"], input[name="diskon"]').forEach(input => {
    input.addEventListener('change', renderProducts);
  });

  // Render awal
  renderProducts();

</script>

</body>
</html>
