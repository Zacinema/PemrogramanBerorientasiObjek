<?php
class Pesanan {
    private $tanggalPesanan;
    private $nomorPesanan;
    private $statusPesanan;
    private $detailPesanan = [];

    public function __construct($nomorPesanan, $tanggalPesanan) {
        $this->nomorPesanan = $nomorPesanan;
        $this->tanggalPesanan = $tanggalPesanan;
        $this->statusPesanan = "Pending";
    }

    public function tambahProduk(Produk $produk, $jumlah) {
        if ($produk->cekStok($jumlah)) {
            // Mengurangi stok produk saat ditambahkan ke pesanan
            $produk->kurangiStok($jumlah);
            $this->detailPesanan[] = new DetailPesanan($produk, $jumlah);
        } else {
            echo "Stok tidak cukup untuk produk: " . $produk->getNamaProduk() . "<br>";
        }
    }

    public function hitungTotal() {
        $total = 0;
        foreach ($this->detailPesanan as $detail) {
            $total += $detail->getSubtotal();
        }
        return $total;
    }

    public function ubahStatus($status) {
        $this->statusPesanan = $status;
    }

    public function getInfoPesanan() {
        $info = "Nomor Pesanan: {$this->nomorPesanan} | Tanggal: {$this->tanggalPesanan} | Status: {$this->statusPesanan}<br>";
        $info .= "Rincian Belanja:<br>";
        foreach ($this->detailPesanan as $detail) {
            $info .= "- {$detail->getProduk()->getNamaProduk()} ({$detail->getJumlah()}x) @ Rp " . number_format($detail->getProduk()->getHarga(), 0, ',', '.') . " = Subtotal: Rp " . number_format($detail->getSubtotal(), 0, ',', '.') . "<br>";
        }
        $info .= "Total Pembayaran: Rp " . number_format($this->hitungTotal(), 0, ',', '.') . "<br>";
        return $info;
    }
}
?>