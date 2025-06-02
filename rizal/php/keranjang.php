<?php
include 'file koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT k.id AS keranjang_id, p.nama_produk AS nama, p.harga, p.gambar, k.jumlah
          FROM keranjang k
          JOIN produk p ON k.produk_id = p.id
          WHERE k.user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$items = [];
$total_items = 0;
$total_price = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $subtotal = $row['harga'] * $row['jumlah'];
    $items[] = $row + ['subtotal' => $subtotal];
    $total_items += $row['jumlah'];
    $total_price += $subtotal;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Keranjang Belanja</title>
    <!-- ... CSS kamu dari keranjang.html tetap sama, boleh ditempel langsung di sini ... -->
    <style>
             body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-bottom: 100px;
            background-color:rgba(247,247,247,255)
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            background-color: white;
        }


        /* Header tabel style */
        th {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-left: none;
            border-right: none;
            background-color: rgba(38,114,162,255);
            color: white;
        }

        .cart-footer {
            position: fixed;
            bottom: 0;
            width: 98%;
            background: white;
            padding: 10px;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
        }

        .cart-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            max-width: 1200px;
        }

        .cart-actions {
            display: flex;
            gap: 10px;
        }

        /* Tombol dengan latar biru dan tulisan putih */
        .cart-actions button,
        .fitur-checkout button {
            background-color: rgba(78, 181, 222, 1);
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }

        .cart-actions button:hover,
        .fitur-checkout button:hover {
            background-color: rgba(60, 140, 180, 1);
        }

        .cart-summary,
        .total-harga p {
            font-weight: bold;
        }

        /* Warna angka Total Produk */
        .cart-summary span {
            color: rgba(78, 181, 222, 1);
        }

        /* Total Harga tulisan hitam, angkanya biru */
        .total-harga p {
            color: black;
            font-weight: bold;
        }
        .total-harga p span {
            color: rgba(78, 181, 222, 1);
        }

        .fitur-checkout {
            display: flex;
            justify-content: flex-end;
        }

        .produk-gambar {
            width: 100%;
            max-width: 320px;
            height: auto;
            display: block;
            margin: 10px auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgb(255, 255, 255);
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {
            height: 30px;
            margin-right: 10px;
        }
        .logo-text {    
            color: #000000;
            font-size: 18px;
        }
        .img-right {
            width: 40px;
            padding-right: 20px;
        }
        .search-bar {
            display: flex;
            align-items: center;
        }
        .search-bar input {
            padding: 5px;
            border: 1px solid #d4cac7;
            border-radius: 4px 0 0 4px;
            outline: none;
        }
        .search-bar button {
            padding: 5px 10px;
            border: none;
            background-color: #cfc4c0;
            color: white;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        /* Styling icon favorit */
        .favorit-icon span.material-symbols-outlined {
            color: blue;
            font-size: 36px;
            cursor: pointer;
            user-select: none;
        }
        /* Pesan kosong keranjang */
        .empty-message {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="logo">
        <img src="icon-logo.png" alt="start">
        <div class="logo-text">
            <span>Start</span> | <span>Keranjang Belanja</span>
        </div>
    </div>

    <div class="favorit-icon">
        <a href="favorit.php">
            <span class="material-symbols-outlined">favorite</span>
        </a>
    </div>
</div>

<table id="cart-table">
    <thead>
        <tr>
            <th><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"></th>
            <th>Produk</th>
            <th>Harga Satuan</th>
            <th>Kuantitas</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody id="cart-body">
        <?php if (count($items) === 0): ?>
            <tr>
                <td colspan="5" class="empty-message">
                    Keranjang-mu kosong. Isi keranjang dengan menelusuri toko dan menggunakan tombol “tambahkan ke keranjang“.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($items as $index => $item): ?>
                <tr>
                    <td><input type="checkbox" class="item-checkbox" data-id="<?= $item['keranjang_id'] ?>"></td>
                    <td>
                        <div class="produk-container">
                            <strong><?= htmlspecialchars($item['nama']) ?></strong><br>
                            <img src="<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama']) ?>" class="produk-gambar">
                        </div>
                    </td>
                    <td>IDR <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td><?= $item['jumlah'] ?></td>
                    <td>IDR <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="cart-footer">
    <div class="cart-container">
        <div class="cart-actions">
            <button onclick="removeSelected()">Hapus</button>
            <button onclick="addToFavorites()">Tambah ke Favorit</button>
        </div>
        <div class="cart-summary">
            <p>Total Produk: <span id="total-items"><?= $total_items ?></span></p>
        </div>
        <div class="total-harga">
            <p>Total Harga: IDR <span id="total-price"><?= number_format($total_price, 0, ',', '.') ?></span></p>
        </div>
        <div class="fitur-checkout">
            <a href="checkout.php"><button type="button">Checkout</button></a>
        </div>
    </div>
</div>

<script>
    function toggleSelectAll(checkbox) {
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = checkbox.checked);
    }

    function removeSelected() {
        const selected = document.querySelectorAll(".item-checkbox:checked");
        if (selected.length === 0) {
            alert("Pilih produk yang ingin dihapus.");
            return;
        }

        selected.forEach(cb => {
            const id = cb.getAttribute("data-id");
            window.location.href = "hapus_keranjang.php?id=" + encodeURIComponent(id);
        });
    }

    function addToFavorites() {
        alert("Produk ditambahkan ke favorit (simulasi)");
    }
</script>

<!-- Google Material Symbols -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</body>
</html>
