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

// Yorum ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ad'], $_POST['yorum'], $_POST['konu_icerigi'])) {
    $ad = $conn->real_escape_string($_POST['ad']);
    $yorum = $conn->real_escape_string($_POST['yorum']);
    $konu_icerigi = $conn->real_escape_string($_POST['konu_icerigi']);

    $sql = "INSERT INTO ogretmentablo (ad, yorum, konu_icerigi) VALUES ('$ad', '$yorum', '$konu_icerigi')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Yorum başarıyla eklendi!</p>";
    } else {
        echo "<p style='color: red;'>Yorum eklenirken hata oluştu: " . $conn->error . "</p>";
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