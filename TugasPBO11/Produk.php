<?php
class Produk {
    private $kodeProduk;
    private $namaProduk;
    private $harga;
    private $stok;

    public function __construct($kodeProduk, $namaProduk, $harga, $stok) {
        $this->kodeProduk = $kodeProduk;
        $this->namaProduk = $namaProduk;
        $this->harga = $harga;
        $this->stok = $stok;
    }

    public function cekStok($jumlah) {
        return $this->stok >= $jumlah;
    }

    public function kurangiStok($jumlah) {
        if ($this->cekStok($jumlah)) {
            $this->stok -= $jumlah;
        }
    }

    public function getHarga() {
        return $this->harga;
    }

    public function getNamaProduk() {
        return $this->namaProduk;
    }
}
?>