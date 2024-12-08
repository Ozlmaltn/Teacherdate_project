<?php
include("header.php");

include("body.php");
include("footer.php");
?>

<?php
// Dosya yükleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['tasarim'])) {
    $adSoyad = $_POST['adSoyad'];
    $uploadDir = 'uploads/';  // Yükleme yapılacak dizin
    $uploadFile = $uploadDir . basename($_FILES['tasarim']['name']);

    // Dosya uzantı kontrolü (PNG formatı)
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    if ($imageFileType != 'png') {
        echo "Sadece PNG formatında dosya yüklenebilir.";
    } else {
        // Dosyayı yükle
        if (move_uploaded_file($_FILES['tasarim']['tmp_name'], $uploadFile)) {
            echo "Dosya başarıyla yüklendi.";
        } else {
            echo "Dosya yüklenirken bir hata oluştu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasarım Yükleme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .image-preview {
            margin-top: 20px;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container " style="color: white;">
        <h1 class=" mt-4">Tasarım Yükleme ve Görüntüleme</h1>

        <!-- Tasarım Yükleme Formu -->
        <form method=" POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="adSoyad" class="form-label">Ad Soyad</label>
                <input type="text" class="form-control" id="adSoyad" name="adSoyad" required>
            </div>

            <div class="mb-3">
                <label for="tasarim" class="form-label">Tasarımlarınızı Yükleyin (PNG Formatı)</label>
                <input type="file" class="form-control" id="tasarim" name="tasarim" accept=".png" required>
            </div>

            <button type="submit" class="btn btn-primary">Tasarımdan Kaydet</button>
        </form>

        <!-- Tasarım Önizlemesi -->
        <?php if (isset($uploadFile) && file_exists($uploadFile)): ?>
            <div class="mt-4">
                <h3>Yüklenen Tasarım:</h3>
                <img src="<?php echo $uploadFile; ?>" alt="Tasarım" class="image-preview">
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Dosya seçildiğinde önizleme gösterme
        document.getElementById("tasarim").addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file && file.type === "image/png") {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imgPreview = document.createElement("img");
                    imgPreview.src = e.target.result;
                    imgPreview.classList.add("image-preview");
                    const previewDiv = document.querySelector(".mt-4");
                    previewDiv.innerHTML = "<h3>Yüklenen Tasarım:</h3>"; // Başlık ekle
                    previewDiv.appendChild(imgPreview);
                };
                reader.readAsDataURL(file);
            } else {
                alert("Lütfen PNG formatında bir dosya yükleyin.");
            }
        });
    </script>
</body>

</html>