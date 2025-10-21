<?php
session_start();

 $sefer_id = $_GET['id'] ?? null;

if (!$sefer_id || !is_numeric($sefer_id)) {
    die("Geçersiz sefer ID'si. <a href='index.php'>Ana Sayfaya Dön</a>");
}

try {
    $db = new PDO('sqlite:bilet_satis.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

try {
    $sql = "SELECT seferler.*, firmalar.firma_adi 
            FROM seferler 
            JOIN firmalar ON seferler.firma_id = firmalar.id 
            WHERE seferler.id = :sefer_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':sefer_id', $sefer_id);
    $stmt->execute();

    $sefer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$sefer) {
        die("Böyle bir sefer bulunamadı. <a href='index.php'>Ana Sayfaya Dön</a>");
    }

} catch (PDOException $e) {
    die("Bir hata oluştu: " . $e->getMessage());
}

try {
    $sql = "SELECT koltuk_no FROM biletler WHERE sefer_id = :sefer_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':sefer_id', $sefer_id);
    $stmt->execute();
    $satilan_koltuklar_sonuc = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 
} catch (PDOException $e) {
    die("Bir hata oluştu: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sefer Detayı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .koltuk { width: 40px; height: 40px; margin: 2px; font-size: 12px; }
        .dolu { background-color: #dc3545; color: white; }
        .bos { background-color: #198754; color: white; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><div class="container-fluid"><a class="navbar-brand" href="#">BiletPlatformu</a>...</div></nav>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3><?php echo htmlspecialchars($sefer['firma_adi']); ?> Seferi</h3>
        </div>
        <div class="card-body">
            <p><strong>Kalkış:</strong> <?php echo htmlspecialchars($sefer['kalkis_yeri']); ?></p>
            <p><strong>Varış:</strong> <?php echo htmlspecialchars($sefer['varis_yeri']); ?></p>
            <p><strong>Tarih:</strong> <?php echo htmlspecialchars($sefer['tarih']); ?></p>
            <p><strong>Saat:</strong> <?php echo htmlspecialchars($sefer['kalkis_saati']); ?></p>
            <p><strong>Fiyat:</strong> <?php echo htmlspecialchars($sefer['fiyat']); ?> TL</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5>Koltuk Seçimi</h5>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['user_id'])): ?>
                <p class="text-muted">Lütfen boş koltuklardan birini seçin.</p>
                <div class="d-flex flex-wrap">
                    <?php for ($i = 1; $i <= $sefer['koltuk_sayisi']; $i++): ?>
                        <?php if (in_array($i, $satilan_koltuklar_sonuc)): ?>
                            <button class="btn koltuk dolu" disabled><?php echo $i; ?></button>
                        <?php else: ?>
                            <a href="bilet_satinal.php?sefer_id=<?php echo $sefer['id']; ?>&koltuk_no=<?php echo $i; ?>" class="btn koltuk bos"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    Bilet almak için lütfen giriş yapın. <a href="giris.php">Giriş Yap </a>.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
