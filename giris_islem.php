<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit();
}

try {
    $db = new PDO('sqlite:bilet_satis.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

 $username = trim($_POST['username']);
 $password = $_POST['password'];

if (empty($username) || empty($password)) {
    die("Lütfen tüm alanları doldurun. <a href='giris.php'>Geri dön</a>");
}

try {
    $sql = "SELECT id, username, password_hash, role FROM users WHERE username = :username OR email = :username";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'] ?? 'user';

        header("Location: index.php");
        exit();

    } else {
        die("Kullanıcı adı veya şifre hatalı. <a href='giris.php'>Geri dön</a>");
    }

} catch (PDOException $e) {
    die("Bir hata oluştu: " . $e->getMessage());
}
?>