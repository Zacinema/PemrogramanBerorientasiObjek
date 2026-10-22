<?php

class DatabaseConnection
{
    private static $instance = null;
    private $pdo;

    // Konfigurasi koneksi (sesuaikan dengan XAMPP/Laragon Anda)
    private const DSN      = "mysql:host=localhost;dbname=materi_pdo;charset=utf8mb4";
    private const USERNAME = "root";
    private const PASSWORD = "";

    // Constructor private: objek tidak bisa dibuat dengan `new` dari luar class
    private function __construct()
    {
        $this->pdo = new PDO(self::DSN, self::USERNAME, self::PASSWORD, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    // Mencegah objek di-clone
    private function __clone() {}

    // Satu-satunya pintu untuk mendapatkan koneksi (Singleton)
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}