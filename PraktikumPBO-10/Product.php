<?php

require_once __DIR__ . '/DatabaseConnection.php';

class Product
{
    public $id = null;
    public $nama;
    public $harga;
    public $stok;

    public function __construct(string $nama = "", float $harga = 0, int $stok = 0)
    {
        $this->nama = $nama;
        $this->harga = $harga;
        $this->stok = $stok;
    }

    private static function db(): PDO
    {
        return DatabaseConnection::getInstance()->getConnection();
    }

    // CREATE
    public function save(): bool
    {
        $stmt = self::db()->prepare(
            "INSERT INTO produk (nama, harga, stok) VALUES (:nama, :harga, :stok)"
        );
        $ok = $stmt->execute([
            ':nama'  => $this->nama,
            ':harga' => $this->harga,
            ':stok'  => $this->stok,
        ]);
        $this->id = (int) self::db()->lastInsertId();
        return $ok;
    }

    // READ semua
    public static function findAll(): array
    {
        return self::db()->query("SELECT * FROM produk ORDER BY id DESC")->fetchAll();
    }

    // READ satu
    public static function findById(int $id): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM produk WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    // UPDATE
    public function update(int $id): bool
    {
        $stmt = self::db()->prepare(
            "UPDATE produk SET nama = :nama, harga = :harga, stok = :stok WHERE id = :id"
        );
        return $stmt->execute([
            ':nama'  => $this->nama,
            ':harga' => $this->harga,
            ':stok'  => $this->stok,
            ':id'    => $id,
        ]);
    }

    // DELETE
    public static function delete(int $id): bool
    {
        $stmt = self::db()->prepare("DELETE FROM produk WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}