<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ogretmen";

$conn = new mysqli($servername, $username, $password, $database);

// Eğer bağlantıda sorun varsa hata gösterilsin
if ($conn->connect_error) {
    die("Bağlantı Hatası: " . $conn->connect_error);
}

// Silme işlemi
if (isset($_GET['sil_id'])) {
    $sil_id = intval($_GET['sil_id']);
    $sql = "DELETE FROM ogretmentablo WHERE id = $sil_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Yorum başarıyla silindi!</p>";
    } else {
        echo "<p style='color: red;'>Silme işlemi sırasında hata oluştu: " . $conn->error . "</p>";
    }
}

// Güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guncelle_id'])) {
    $guncelle_id = intval($_POST['guncelle_id']);
    $ad = $conn->real_escape_string($_POST['ad']);
    $yorum = $conn->real_escape_string($_POST['yorum']);
    $konu_icerigi = $conn->real_escape_string($_POST['konu_icerigi']);

    $sql = "UPDATE ogretmentablo SET ad='$ad', yorum='$yorum', konu_icerigi='$konu_icerigi' WHERE id = $guncelle_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Yorum başarıyla güncellendi!</p>";
    } else {
        echo "<p style='color: red;'>Güncelleme işlemi sırasında hata oluştu: " . $conn->error . "</p>";
    }
}

// Veritabanından öğretmen verilerini alma
$ogretmenler = [];
$result = $conn->query("SELECT * FROM ogretmentablo");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ogretmenler[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğretmen Yorumları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class=" text-white">

    <div class="container mt-5">
        <h1 class="text-center mb-4">Öğretmen Yorumları</h1>

        <!-- Yorum Tablosu -->
        <table class="table table-dark table-striped mt-5">
            <thead>
                <tr>
                    <th>Ad</th>
                    <th>Yorum</th>
                    <th>Konu İçeriği</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ogretmenler)): ?>
                    <?php foreach ($ogretmenler as $ogretmen): ?>
                        <tr>
                            <td><?= htmlspecialchars($ogretmen['ad']) ?></td>
                            <td><?= htmlspecialchars($ogretmen['yorum']) ?></td>
                            <td><?= htmlspecialchars($ogretmen['konu_icerigi']) ?></td>
                            <td>
                                <!-- Silme Butonu -->
                                <a href="?sil_id=<?= $ogretmen['id'] ?>" class="btn btn-light btn-sm">Sil</a>
                                <!-- Güncelle Butonu -->
                                <button onclick="fillUpdateForm(<?= htmlspecialchars(json_encode($ogretmen)) ?>)"
                                    class="btn btn-success btn-sm">Güncelle</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Henüz bir yorum eklenmedi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Yorum Ekleme veya Güncelleme Formu -->
        <form method="POST" action="" class="mt-4">
            <input type="hidden" name="guncelle_id" id="guncelle_id">
            <div class="mb-3">
                <label for="ad" class="form-label">Adınız:</label>
                <input type="text" name="ad" id="ad" class="form-control" placeholder="Adınız veya takma adınız"
                    required>
            </div>
            <div class="mb-3">
                <label for="yorum" class="form-label">Yorumunuz:</label>
                <textarea name="yorum" id="yorum" class="form-control" rows="4" placeholder="Yorumunuzu yazın..."
                    required></textarea>
            </div>
            <div class="mb-3">
                <label for="konu_icerigi" class="form-label">Konu İçeriği:</label>
                <select name="konu_icerigi" id="konu_icerigi" class="form-select" required>
                    <option value="Beğeni">Beğeni</option>
                    <option value="Öneri">Öneri</option>
                    <option value="Eleştiri">Eleştiri</option>
                    <option value="Eğitici Bilgi">Eğitici Bilgi</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </form>
    </div>


    <script>
        // Güncelleme formunu doldur
        function fillUpdateForm(data) {
            document.getElementById('guncelle_id').value = data.id;
            document.getElementById('ad').value = data.ad;
            document.getElementById('yorum').value = data.yorum;
            document.getElementById('konu_icerigi').value = data.konu_icerigi;
        }
    </script>

</body>

</html> 