<?php
class DetailPesanan {
    private $jumlah;
    private $subtotal;
    private $produk;

    public function __construct(Produk $produk, $jumlah) {
        $this->produk = $produk;
        $this->jumlah = $jumlah;
        $this->subtotal = $this->hitungSubtotal();
    }

    public function hitungSubtotal() {
        return $this->produk->getHarga() * $this->jumlah;
    }

    public function getJumlah() {
        return $this->jumlah;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function getProduk() {
        return $this->produk;
    }
}
?>