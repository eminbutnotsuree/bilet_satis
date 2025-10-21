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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $yuklenecek_tutar = $_POST['tutar'] ?? null;

    if (!is_numeric($yuklenecek_tutar) || $yuklenecek_tutar <= 0) {
        $error_message = "Lütfen geçerli ve pozitif bir tutar girin.";
    } else {
        try {
            $stmt = $db->prepare("SELECT balance FROM users WHERE id = :user_id");
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                session_destroy();
                header("Location: giris.php?error=db_user_not_found");
                exit();
            }

            $yeni_bakiye = $user['balance'] + $yuklenecek_tutar;

            $stmt_update = $db->prepare("UPDATE users SET balance = :yeni_bakiye WHERE id = :user_id");
            $stmt_update->bindParam(':yeni_bakiye', $yeni_bakiye);
            $stmt_update->bindParam(':user_id', $_SESSION['user_id']);
            $stmt_update->execute();

            header("Location: biletlerim.php?bakiye_yuklendi=1");
            exit();

        } catch (PDOException $e) {
            $error_message = "Bir hata oluştu: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bakiye Yükle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><div class="container-fluid"><a class="navbar-brand" href="#">BiletPlatformu</a>...</div></nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Bakiye Yükle</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <form action="bakiye_yukle.php" method="POST">
                        <div class="mb-3">
                            <label for="tutar" class="form-label">Yüklenecek Tutar (TL)</label>
                            <input type="number" step="0.01" min="1" class="form-control" id="tutar" name="tutar" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Bakiyemi Yükle</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="biletlerim.php" class="btn btn-secondary">Biletlerime Dön</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>