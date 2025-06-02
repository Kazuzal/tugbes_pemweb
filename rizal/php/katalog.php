<?php
session_start();
include "file koneksi.php";

// Pastikan sudah login
if (!isset($_SESSION['uid'])) {
    header("Location: index.php");
    exit();
}

$uid = $_SESSION['uid'];
$query = mysqli_query($conn, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shopee Header Clone</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <style>
     * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      text-align: center;
    }
    .header {
      background: rgba(240,240,241,255);
      padding-top: 20px; 
      border-bottom: 1px solid #ccc;
    }
    .header .container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      gap: 20px;
    }
    .search-bar {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
    }
    .search-bar input {
      width: 700px;
      height: 40px;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      padding: 8px 12px;
      background: rgba(223,223,225,255);
    }
    .search-bar button {
      width: 40px;
      height: 40px;
      font-size: 24px;
      background: transparent;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .cart-btn {
      position: relative;
      background: transparent;
      border: none;
      cursor: pointer;
      padding: 4px;
      font-size: 28px;
    }
    .cart-btn .material-symbols-outlined {
      font-size: 28px;
    }
    .material-symbols-outlined {
      font-family: 'Material Symbols Outlined';
      font-size: 24px;
      letter-spacing: normal;
      display: inline-block;
      white-space: nowrap;
    }
    .subnav {
      display: flex;
      justify-content: center;
    }
    .subnav ul {
      display: flex;
      list-style: none;
      overflow-x: auto;
    }
    .subnav ul li {
      margin: 0 12px;
    }
    .subnav ul li a {
      display: block;
      padding: 10px 0;
      color: #000;
      text-decoration: none;
      font-size: 14px;
      white-space: nowrap;
    }
    .subnav ul li a:hover {
      text-decoration: underline;
    }
    .menu-bawah {
      position: relative;
      top: 40px;
      width: 100%;
      z-index: 998;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 40px;
      padding: 0;
    }
    .menu-item img {
      width: 70px;
      transition: transform 0.3s ease;
    }
    .menu-item img:hover {
      transform: scale(1.1);
      cursor: pointer;
    }
    .content-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }
    .kotak-content {
      background-color: #ffffff;
      max-width: 300px;
      height: 300px;
      margin: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      position: relative;
      overflow-y: auto;
      scrollbar-width: none;
      border-radius: 15px;
    }
    .kotak-content::-webkit-scrollbar {
      display: none;
    }
    .judul-1 {
      background-color: #4eb5de;
      color: #000;
      padding: 12px 16px;
      font-size: 16px;
      font-weight: bold;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      border-bottom: 1px solid #ccc;
    }
    .isi-konten {
      padding: 16px;
      font-size: 14px;
      color: black;
      word-wrap: break-word;
      overflow-wrap: break-word;
      white-space: normal;
    }
    .isi-konten p {
      margin: 6px 0;
    }
    .tombol-aksi {
      position: absolute;
      top: 10px;
      right: 10px;
      display: flex;
      gap: 10px;
    }
    .tombol-aksi button {
      background-color: transparent;
      border: none;
      cursor: pointer;
      font-size: 18px;
    }
    .tombol-aksi button:hover {
      transform: scale(1.2);
    }


.harga-nominal {
  color: blue;  
  font-weight: bold;
}


    .barisan-2 {
      background: #fff;
      padding: 40px;
      text-align: center;
    }
    .slider-container {
      position: relative;
      width: 450px;
      height: 267px;
      overflow: hidden;
      margin: 0 auto 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .slides {
      display: flex;
      transition: transform 0.5s ease-in-out;
    }
    .slides a {
      flex-shrink: 0;
      width: 450px;
      height: 267px;
    }
    .slides img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      display: block;
    }
    .prev, .next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0,0,0,0.5);
      color: #fff;
      border: none;
      padding: 8px;
      cursor: pointer;
      opacity: 0;
      transition: opacity .3s;
    }
    .slider-container:hover .prev,
    .slider-container:hover .next {
      opacity: 1;
    }
    .prev { left: 10px; }
    .next { right: 10px; }
    .gambar-produk {
      width: 100%;
      max-height: 150px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #ffffff;
    }
    .gambar-produk img {
      max-width: 100%;
      max-height: 150px;
      height: auto;
      width: auto;
      object-fit: contain;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="container">
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Ban Tubeless">
        <button class="search-btn" onclick="filterKonten()">
          <span class="material-symbols-outlined"  style="color:blue" >search</span>
        </button>
        <a href="<?php echo $isLoggedIn ? 'keranjang.php' : 'login.php'; ?>" class="cart-btn">
          <span class="material-symbols-outlined" style="color:blue ">shopping_cart</span>
        </a>
      </div>
    </div>
    <nav class="subnav">
      <ul>
        <li><a href="<?php echo $isLoggedIn ? 'favorit.php' : 'login.php'; ?>">wishlist</a></li>
        <li><a href="#">vouchel</a></li>
      </ul>
    </nav>
  </header>

  
  <!-- Slider & Menu -->
  <div class="barisan-2">
    <div class="slider-container">
      <button class="prev" onclick="slideBack()">❮</button>
      <div class="slides">
        <a href="#"><img src="iklan1.jpg" alt="Iklan 1"></a>
       
      </div>
      <button class="next" onclick="slideForward()">❯</button>
    </div>

    <!-- Menu Bawah -->
    <div class="menu-bawah">
      <div class="menu-item">
        <img src="gambar_oli.png" alt="oli" onclick="showContent('oli')">
        <p class="menu-text">Oli</p>
      </div>
      <div class="menu-item">
        <img src="gambar_gear.png" alt="gear" onclick="showContent('gear')">
        <p class="menu-text">Gear</p>
      </div>
      <div class="menu-item">
        <img src="gambar_ban.png" alt="ban" onclick="showContent('ban')">
        <p class="menu-text">Ban</p>
      </div>
    </div>
  </div>

  <!-- Konten Produk -->
  <div class="content-warna">
    <div id="content-container" class="content-container">
    </div>
  </div>


  <script>
    const produkData = {
      oli: [
        { judul: "Oli Mesin SAE 10W-40", deskripsi: "Oli berkualitas tinggi.", harga: 150000 }
      ],
      gear: [
        { judul: "Gear Set Standard", deskripsi: "Gear set kuat.", harga: 250000 }
      ],
      ban: [
        { judul: "Ban Tubeless", deskripsi: "Ban nyaman.", harga: 350000, gambar: "ban tubeless.png" }
      ]
    };

    const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;

    function buatKonten(data) {
      const c = document.getElementById('content-container');
      c.innerHTML = '';
      data.forEach(item => {
        const box = document.createElement('div');
        box.className = 'kotak-content';

        const gambarHTML = item.gambar
          ? `<div class="gambar-produk"><img src="${item.gambar}" alt="${item.judul}" /></div>`
          : '';

        box.innerHTML = `
          <div class="tombol-aksi">
            <button onclick="tambahFavorit(event)" title="Tambah ke Favorit">
              <span class="material-symbols-outlined" style="color:blue;">favorite</span>
            </button>
            <button onclick="tambahKeranjang(event)" title="Tambah ke Keranjang">
              <span class="material-symbols-outlined" style="color:blue;">add_shopping_cart</span>
            </button>
          </div>
          <div class="judul-1">${item.judul}</div>
          ${gambarHTML}
          <div class="isi-konten"><p>${item.deskripsi}</p></div>
          <div class="harga-produk">
            <p><strong>Harga:</strong> <span class="harga-nominal">${item.harga.toLocaleString('id-ID')}</span></p>
          </div>
        `;

        c.appendChild(box);
      });
    }

    function tambahFavorit(e) {
      e.stopPropagation();
      if (!isLoggedIn) {
        alert("Silakan login terlebih dahulu untuk menambahkan ke favorit.");
        window.location.href = 'login.php';
        return;
      }
      alert("Ditambahkan ke favorit!");
    }

    function tambahKeranjang(e) {
      e.stopPropagation();
      if (!isLoggedIn) {
        alert("Silakan login terlebih dahulu untuk menambahkan ke keranjang.");
        window.location.href = 'login.php';
        return;
      }
      const title = e.target.closest('.kotak-content').querySelector('.judul-1').innerText;
      alert()`${title} ditambahkan ke keranjang!\`);
    }

    function showContent(cat) {
      if (produkData[cat]) buatKonten(produkData[cat]);
    }

    function filterKonten() {
      const txt = document.getElementById('searchInput').value.toLowerCase();
      document.querySelectorAll('.kotak-content').forEach(k => {
        const jud = k.querySelector('.judul-1').innerText.toLowerCase();
        k.style.display = jud.includes(txt) ? '' : 'none';
      });
    }

    window.showContent = showContent;
    window.filterKonten = filterKonten;
    showContent('oli');
  </script>
</body>
</html>
