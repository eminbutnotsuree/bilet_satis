<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: giris.php");
    exit();
}

try {
    $db = new PDO('sqlite:bilet_satis.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

try {
    $sql = "SELECT 
                biletler.id AS bilet_id, 
                biletler.koltuk_no, 
                biletler.satinalma_tarihi, 
                biletler.fiyat AS satin_alinan_fiyat,
                seferler.kalkis_yeri,           -- BURADA 'seferler' yazıyor
                seferler.varis_yeri,             -- BURADA 'seferler' yazıyor
                seferler.tarih,                  -- BURADA 'seferler' yazıyor
                seferler.kalkis_saati,           -- BURADA 'seferler' yazıyor
                firmalar.firma_adi
            FROM biletler
            JOIN seferler ON biletler.sefer_id = seferler.id -- BURADA 'seferler.id' yazıyor
            JOIN firmalar ON seferler.firma_id = firmalar.id
            WHERE biletler.user_id = :user_id
            ORDER BY seferler.tarih DESC, seferler.kalkis_saati DESC";
                            
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();

    $biletler = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Bir hata oluştu: " . $e->getMessage());
}

try {
    $stmt_balance = $db->prepare("SELECT balance FROM users WHERE id = :user_id");
    $stmt_balance->bindParam(':user_id', $_SESSION['user_id']);
    $stmt_balance->execute();
    $user_data = $stmt_balance->fetch(PDO::FETCH_ASSOC);
    $current_balance = $user_data['balance'] ?? 0.00;
} catch (PDOException $e) {
    $current_balance = 0.00;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Biletlerim - Bilet Satın Alma Platformu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">BiletPlatformu</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Ana Sayfa</a></li>
                <li class="nav-item"><a class="nav-link active" href="biletlerim.php">Biletlerim</a></li>
                <li class="nav-item"><span class="navbar-text me-3">Hoş geldin, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span></li>
                <li class="nav-item"><a class="nav-link" href="cikis.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Geçmiş Biletlerim</h2>
        <div class="text-end">
            <strong>Bakiyeniz:</strong> 
            <span class="badge bg-primary fs-6"><?php echo number_format($current_balance, 2); ?> TL</span>
            <br>
            <a href="bakiye_yukle.php" class="btn btn-sm btn-success mt-2">Bakiye Yükle</a>
        </div>
    </div>

    <?php if (isset($_GET['satinalma_basarili'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Biletiniz başarıyla satın alındı!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['bakiye_yuklendi'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Bakiyeniz başarıyla güncellendi!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (count($biletler) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Firma</th>
                        <th>Sefer</th>
                        <th>Tarih / Saat</th>
                        <th>Koltuk No</th>
                        <th>Fiyat</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($biletler as $bilet): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($bilet['firma_adi']); ?></td>
                        <td><?php echo htmlspecialchars($bilet['kalkis_yeri']); ?> - <?php echo htmlspecialchars($bilet['varis_yeri']); ?></td>
                        <td><?php echo htmlspecialchars($bilet['tarih']); ?> <br> <small><?php echo htmlspecialchars($bilet['kalkis_saati']); ?></small></td>
                        <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($bilet['koltuk_no']); ?></span></td>
                        <td><?php echo htmlspecialchars($bilet['satin_alinan_fiyat']); ?> TL</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-danger" disabled>İptal Et</a>
                            <a href="#" class="btn btn-sm btn-outline-secondary" disabled>PDF</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <h4>Henüz biletiniz bulunmuyor.</h4>
            <p>Ana sayfadan sefer arayıp bakiye yükledikten sonra ilk biletinizi alabilirsiniz.</p>
            <a href="index.php" class="btn btn-primary">Sefer Ara</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>