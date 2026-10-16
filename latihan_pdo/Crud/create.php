<?php
require_once '../Catatan.php'; // Sesuaikan path lokasi file Catatan.php

$c = new Catatan();
$hasil = $c->setJudul("Kedua")
           ->setIsi("Belajar Koneksi Database dengan PDO")
           ->save();

echo $hasil ? "Berhasil disimpan" : "Gagal";