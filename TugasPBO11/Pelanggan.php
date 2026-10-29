<?php
class Pelanggan {
    private $idPelanggan;
    private $nama;
    private $email;
    private $alamat;

    public function __construct($idPelanggan, $nama, $email, $alamat) {
        $this->idPelanggan = $idPelanggan;
        $this->nama = $nama;
        $this->email = $email;
        $this->alamat = $alamat;
    }

    public function buatPesanan($nomorPesanan): Pesanan {
        return new Pesanan($nomorPesanan, date('Y-m-d'));
    }

    public function ubahAlamat($alamatBaru): void {
        $this->alamat = $alamatBaru;
    }

    public function getDataPelanggan() {
        return "ID: {$this->idPelanggan}, Nama: {$this->nama}, Email: {$this->email}, Alamat: {$this->alamat}";
    }
}
?>