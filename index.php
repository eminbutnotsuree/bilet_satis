<?php
session_start();

$iller = [
    "Adana", "Adıyaman", "Afyonkarahisar", "Ağrı", "Aksaray", "Amasya", "Ankara", "Antalya",
    "Ardahan", "Artvin", "Aydın", "Balıkesir", "Bartın", "Batman", "Bayburt", "Bilecik",
    "Bingöl", "Bitlis", "Bolu", "Burdur", "Bursa", "Çanakkale", "Çankırı", "Çorum",
    "Denizli", "Diyarbakır", "Düzce", "Edirne", "Elazığ", "Erzincan", "Erzurum", "Eskişehir",
    "Gaziantep", "Giresun", "Gümüşhane", "Hakkari", "Hatay", "Iğdır", "Isparta", "İstanbul",
    "İzmir", "Kahramanmaraş", "Karabük", "Karaman", "Kars", "Kastamonu", "Kayseri", "Kilis",
    "Kırıkkale", "Kırklareli", "Kırşehir", "Kocaeli", "Konya", "Kütahya", "Malatya", "Manisa",
    "Mardin", "Mersin", "Muğla", "Muş", "Nevşehir", "Niğde", "Ordu", "Osmaniye",
    "Rize", "Sakarya", "Samsun", "Şanlıurfa", "Siirt", "Sinop", "Sivas", "Şırnak",
    "Tekirdağ", "Tokat", "Trabzon", "Tunceli", "Uşak", "Van", "Yalova", "Yozgat", "Zonguldak"
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa - Bilet Satın Alma Platformu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">BiletPlatformu</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><span class="navbar-text me-3">Hoş geldin, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span></li>
                    <li class="nav-item"><a class="nav-link" href="cikis.php">Çıkış Yap</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="kayit.php">Kayıt Ol</a></li>
                    <li class="nav-item"><a class="nav-link" href="giris.php">Giriş Yap</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Sefer Ara</h2>
                    
                    <form action="sefer_ara.php" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="kalkis" class="form-label">Kalkış Yeri</label>
                            <select id="kalkis" name="kalkis" class="form-select" required>
                                <option value="" selected disabled>Seçiniz...</option>
                                <?php foreach ($iller as $il): ?>
                                    <option value="<?php echo htmlspecialchars($il); ?>"><?php echo htmlspecialchars($il); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="varis" class="form-label">Varış Yeri</label>
                            <select id="varis" name="varis" class="form-select" required>
                                <option value="" selected disabled>Seçiniz...</option>
                                <?php foreach ($iller as $il): ?>
                                    <option value="<?php echo htmlspecialchars($il); ?>"><?php echo htmlspecialchars($il); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tarih" class="form-label">Tarih</label>
                            <input type="date" id="tarih" name="tarih" class="form-control" required>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Seferleri Ara</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>