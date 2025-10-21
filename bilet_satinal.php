<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: giris.php');
    exit();
}
$sefer_id = $_GET['sefer_id'] ?? null;
$koltuk_no = $_GET['koltuk_no'] ?? null;

if (!$sefer_id || !$koltuk_no || !is_numeric($sefer_id) || !is_numeric($koltuk_no)) {
    die("Geçersiz istek. <a href='index.php'>Ana Sayfaya Dön</a>");
}

try {
    $db = new PDO('sqlite:bilet_satis.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
try {
    $stmt_sefer = $db->prepare("SELECT * FROM seferler WHERE id = :sefer_id");
    $stmt_sefer->bindParam(':sefer_id', $sefer_id);
    $stmt_sefer->execute();
    $sefer = $stmt_sefer->fetch(PDO::FETCH_ASSOC);

    $stmt_user = $db->prepare("SELECT balance FROM users WHERE id = :user_id");
    $stmt_user->bindParam(':user_id', $_SESSION['user_id']);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if (!$sefer || !$user) {
        die("Sefer veya kullanıcı bulunamadı. <a href='index.php'>Ana Sayfaya Dön</a>");
    }

} catch (PDOException $e) {
    die("Bir hata oluştu: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db->beginTransaction();

    try {
        $stmt_check = $db->prepare("SELECT id FROM biletler WHERE sefer_id = :sefer_id AND koltuk_no = :koltuk_no");
        $stmt_check->bindParam(':sefer_id', $sefer_id);
        $stmt_check->bindParam(':koltuk_no', $koltuk_no);
        $stmt_check->execute();
        if ($stmt_check->fetch()) {
            throw new Exception("Seçtiğiniz koltuk maalesef刚刚 satın alındı. Lütfen başka bir koltuk seçin.");
        }

        $yeni_bakiye = $user['balance'] - $sefer['fiyat'];
        if ($yeni_bakiye < 0) {
            throw new Exception("Yetersiz bakiye.");
        }
        $stmt_update_balance = $db->prepare("UPDATE users SET balance = :yeni_bakiye WHERE id = :user_id");
        $stmt_update_balance->bindParam(':yeni_bakiye', $yeni_bakiye);
        $stmt_update_balance->bindParam(':user_id', $_SESSION['user_id']);
        $stmt_update_balance->execute();

        $stmt_insert_ticket = $db->prepare("INSERT INTO biletler (user_id, sefer_id, koltuk_no, fiyat) VALUES (:user_id, :sefer_id, :koltuk_no, :fiyat)");
        $stmt_insert_ticket->bindParam(':user_id', $_SESSION['user_id']);
        $stmt_insert_ticket->bindParam(':sefer_id', $sefer_id);
        $stmt_insert_ticket->bindParam(':koltuk_no', $koltuk_no);
        $stmt_insert_ticket->bindParam(':fiyat', $sefer['fiyat']);
        $stmt_insert_ticket->execute();

        $db->commit();

        header("Location: biletlerim.php?satinalma_basarili=1");
        exit();

    } catch (Exception $e) {
        $db->rollBack();
        die("Satın alma işlemi başarısız oldu: " . $e->getMessage() . " <a href='javascript:history.back()'>Geri dön</a>");
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bilet Satın Al</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><div class="container-fluid"><a class="navbar-brand" href="#">BiletPlatformu</a>...</div></nav>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Bilet Satın Alma Onayı</h4>
        </div>
        <div class="card-body">
            <p><strong>Sefer:</strong> <?php echo htmlspecialchars($sefer['kalkis_yeri']); ?> - <?php echo htmlspecialchars($sefer['varis_yeri']); ?></p>
            <p><strong>Tarih:</strong> <?php echo htmlspecialchars($sefer['tarih']); ?> | <strong>Saat:</strong> <?php echo htmlspecialchars($sefer['kalkis_saati']); ?></p>
            <p><strong>Seçili Koltuk:</strong> <?php echo htmlspecialchars($koltuk_no); ?></p>
            <p><strong>Bilet Fiyatı:</strong> <?php echo htmlspecialchars($sefer['fiyat']); ?> TL</p>
            <hr>
            <p><strong>Mevcut Bakiyeniz:</strong> <?php echo htmlspecialchars($user['balance']); ?> TL</p>
            <p><strong>Kalan Bakiyeniz:</strong> <span class="text-danger"><?php echo htmlspecialchars($user['balance'] - $sefer['fiyat']); ?> TL</span></p>
            
            <form action="bilet_satinal.php?sefer_id=<?php echo $sefer_id; ?>&koltuk_no=<?php echo $koltuk_no; ?>" method="POST">
                <button type="submit" class="btn btn-success">Satın Almayı Onayla</button>
                <a href="sefer_detay.php?id=<?php echo $sefer_id; ?>" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>