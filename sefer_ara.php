<?php
session_start();

 $kalkis = trim($_GET['kalkis'] ?? '');
 $varis = trim($_GET['varis'] ?? '');
 $tarih = trim($_GET['tarih'] ?? '');

if (empty($kalkis) || empty($varis) || empty($tarih)) {
    die("Lütfen arama formunda tüm alanları doldurun. <a href='index.php'>Geri dön</a>");
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
            WHERE seferler.kalkis_yeri = :kalkis AND seferler.varis_yeri = :varis AND seferler.tarih = :tarih
            ORDER BY seferler.kalkis_saati ASC";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':kalkis', $kalkis);
    $stmt->bindParam(':varis', $varis);
    $stmt->bindParam(':tarih', $tarih);
    $stmt->execute();

    $seferler = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Bir hata oluştu: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sefer Sonuçları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><div class="container-fluid"><a class="navbar-brand" href="#">BiletPlatformu</a>...</div></nav>

<div class="container mt-5">
    <h3><?php echo htmlspecialchars($kalkis); ?> - <?php echo htmlspecialchars($varis); ?> Tarihi: <?php echo htmlspecialchars($tarih); ?></h3>
    
    <?php if (count($seferler) > 0): ?>
        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th>Firma</th>
                    <th>Kalkış Saati</th>
                    <th>Fiyat</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seferler as $sefer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($sefer['firma_adi']); ?></td>
                    <td><?php echo htmlspecialchars($sefer['kalkis_saati']); ?></td>
                    <td><?php echo htmlspecialchars($sefer['fiyat']); ?> TL</td>
                    <td>
                        <a href="sefer_detay.php?id=<?php echo $sefer['id']; ?>" class="btn btn-info btn-sm">Detaylar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning mt-4">
            <h4>Sonuç Bulunamadı</h4>
            <p>Aradığınız kriterlere uygun sefer bulunmamaktadır.</p>
            <a href="index.php" class="btn btn-secondary">Yeni Arama Yap</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>