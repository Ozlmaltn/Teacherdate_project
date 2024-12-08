<?php
// Dosya yükleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['tasarim'])) {
    // Dosya adı ve yeri
    $uploadDir = 'design/'; // Tasarımlar için dizin
    $uploadFile = $uploadDir . basename($_FILES['tasarim']['name']);

    // Dosya boyutu ve türü kontrolü
    $maxDosyaBoyutu = 5 * 1024 * 1024; // 5MB
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Boyut ve format kontrolü
    if ($_FILES['tasarim']['size'] > $maxDosyaBoyutu) {
        echo "Dosya boyutu çok büyük! Maksimum dosya boyutu 5MB olmalıdır.";
    } elseif ($imageFileType != 'png') {
        echo "Sadece PNG formatındaki dosyalar kabul edilmektedir.";
    } else {
        // Dosyayı yükleme
        if (move_uploaded_file($_FILES['tasarim']['tmp_name'], $uploadFile)) {
            $message = "Dosya başarıyla yüklendi.";
        } else {
            $message = "Dosya yüklenirken bir hata oluştu.";
        }
    }
}
?>

<?php
include("header.php");

include("body.php");
include("footer.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <div class="container " style="background-color: #FFF5E1; color: #333;">
        <div class="row justify-content-between mt-5">
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts1.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5">
            </div>
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts2.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5">
            </div>
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts3.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5">
            </div>
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts4.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5" width="100%" ,
                    height="100%">
            </div>
        </div>



        <div class="row justify-content-between mt-5">
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts5.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5">
            </div>
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts6.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5">
            </div>
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts7.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5">
            </div>
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts8.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5" width="100%" ,
                    height="100%">
            </div>
        </div>

        <div class="row justify-content-between mt-5">
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts9.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5">
            </div>
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts12.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5">
            </div>
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts11.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5">
            </div>
            <div class="col-sm-6 col-md-3 mt-3">
                <img src="design/ts10.png" alt=""
                    class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5" width="100%" ,
                    height="100%">
            </div>

        </div>

        <!-- Yeni yüklenen tasarımı buraya ekle -->
        <?php if (isset($uploadFile) && file_exists($uploadFile)): ?>
            <div class="row justify-content-between mt-5">
                <div class="col-sm-6 col-md-3 mt-3">
                    <img src="<?php echo $uploadFile; ?>" alt="Yeni Tasarım"
                        class="img-fluid shadow-lg p-3 bg-white rounded border border-dark mt-5">
                </div>
            </div>
        <?php endif; ?>


        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="tasarim" accept="image/png">
            <button type="submit" class="btn btn-primary">Tasarımı Yükle</button>
        </form>

    </div>



</body>

</html>