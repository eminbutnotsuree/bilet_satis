<?php
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/../bilet_satis.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>