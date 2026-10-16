<?php
require_once 'DatabaseConnection.php';

class Catatan {
    private $id;
    private $judul;
    private $isi;
    private $db;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    public function setJudul($judul) {
        $this->judul = $judul;
        return $this;
    }

    public function setIsi($isi) {
        $this->judul = $judul;
        return $this;
    }

    public function save() {
        $sql = "INSERT INTO catatan (judul, isi) VALUES (:judul, :isi)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'judul' => $this->judul,
            'isi' => $this->isi
        ]);
    }

    public static function getAll(){
        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM catatan ORDER BY id DESC");
        return $stmt->fetchAll;
    }

    public static function fedById($id) {
        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM catatan WHERE id = :id");
        return $stmt->execute([
            'id' => $id
        ]);
    }    
}