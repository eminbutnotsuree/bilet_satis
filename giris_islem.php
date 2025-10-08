<?php   
session_start();
ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !=  'POST') {
    header('location: index.php');
    exit() ;
}

try {
    $db = new PDO('sqlite:bilet_satis.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
$username = trim($_POST["username"]);
$password = $_POST["password"];

if ($username == "" || $password == "") {
    die("Lütfen tüm alanları doldurun. <a href='giris.php'>Geri Dön</a>");
}

try {
    $sql = "SELECT id, username, password_hash FROM users where username = :username OR email = :username";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($username && password_verify($password, $user['password_hash']) ) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: index.php');
        exit();

    }
    else {
        die("Geçersiz kullanıcı adı veya şifre. <a href='giris.php'>Geri Dön</a>");
    }
} catch (PDOException $e) {
    die("Giriş hatası: " . $e->getMessage());
}
?>