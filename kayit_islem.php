<?php
ini_set("display_errors",1);
ini_set('display_startup_errors', 1);   
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
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
 $email = trim($_POST["email"]);
 $password = $_POST['password'];

if ($username == "" || $email == "" || $password == "") {
    die("Lütfen tüm alanları doldurun. <a href='kayit.php'>Geri Dön</a>");
}

 $password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password_hash', $password_hash);
 
    $stmt->execute();

    header('Location: giris.php?kayit_basarili=1');
    exit();
}
catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        die("Bu kullanıcı adı veya email zaten kullanılıyor. <a href='kayit.php'>Geri Dön</a>");
    } else {
        die("Kayıt hatası: " . $e->getMessage());
    }
}
?>