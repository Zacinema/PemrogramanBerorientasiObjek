<?php
require_once 'Produk.php';
require_once 'Pelanggan.php';
require_once 'DetailPesanan.php';
require_once 'Pesanan.php';

echo "<h2>Simulasi Sistem Penjualan Toko Online (Kelompok 3)</h2>";

// 1. Inisialisasi Data Produk
$produk1 = new Produk("P001", "Laptop ASUS", 7500000, 10);
$produk2 = new Produk("P002", "Mouse Wireless", 150000, 25);

// 2. Inisialisasi Data Pelanggan
$pelanggan1 = new Pelanggan("C001", "Hizbullah", "hizbullah@gmail.com", "Jl. Jenderal Ahmad Yani, Pontianak");

echo "<b>Data Pelanggan:</b><br>";
echo $pelanggan1->getDataPelanggan() . "<br><br>";

// 3. Pelanggan membuat pesanan baru
$pesananBaru = $pelanggan1->buatPesanan("ORD-20261029-001");

// 4. Menambahkan produk ke pesanan
$pesananBaru->tambahProduk($produk1, 1); 
$pesananBaru->tambahProduk($produk2, 2); 

// 5. Mengubah status pesanan
$pesananBaru->ubahStatus("Diproses");

// 6. Menampilkan informasi pesanan
echo $pesananBaru->getInfoPesanan();
?>