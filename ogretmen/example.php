<?php
include("header.php");
include("body.php");

include("footer.php");
?>

<?php
// Eğer bir konu seçildiyse, ilgili soruları göster
if (isset($_POST['konu'])) {
    $konu = $_POST['konu'];
    // Konuya göre soru setini yükle
    if ($konu == 'php') {
        $sorular = [
            ['soru' => 'PHP dilinde, veritabanına bağlanmak için kullanılan fonksiyon nedir?', 'cevaplar' => ['mysqli_connect()', 'db_connect()', 'connect_db()', 'mysqli_connect_db()'], 'dogru' => 0],
            ['soru' => 'PHP\'de $_GET süper global değişkeninin ne amacı vardır?', 'cevaplar' => ['Formdan gelen POST verilerini almak', 'URL\'den gelen verileri almak', 'Çerezlerden veri almak', 'Sunucudan veri almak'], 'dogru' => 1],
        ];
    } elseif ($konu == 'html') {
        $sorular = [
            ['soru' => 'HTML\'de bir başlık etiketi (heading) hangi etikette bulunur?', 'cevaplar' => ['<title>', '<h1>', '<head>', '<header>'], 'dogru' => 1],
            ['soru' => 'HTML\'de bir bağlantıyı (link) tanımlamak için hangi etiket kullanılır?', 'cevaplar' => ['<a>', '<link>', '<href>', '<url>'], 'dogru' => 0],
        ];
    }
    // Diğer konular için benzer şekilde soruları ekleyebilirsiniz...
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yazılım Bilgi Oyunu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f3f3;
        }

        .quiz-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-answer {
            width: 100%;
            margin-bottom: 10px;
        }

        .timer {
            font-size: 1.5rem;
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Yazılım Bilgi Oyunu</h1>

        <!-- Konu Seçim Formu -->
        <?php if (!isset($konu)): ?>
            <form method="POST" action="">
                <h3 class="mt-4" style="color: white;">Hangi konuda oyun oynamak istersiniz?</h3>
                <select name="konu" class="form-select mt-3">
                    <option value="php">PHP</option>
                    <option value="html">HTML</option>
                    <option value="css">CSS</option>
                    <option value="js">JavaScript</option>
                    <option value="sql">SQL</option>
                </select>
                <button type="submit" class="btn btn-primary mt-3">Seçimi Yap</button>
            </form>
        <?php else: ?>
            <!-- Seçilen konuya ait soruları göster -->
            <div class="quiz-container text-center mt-4">
                <h3><?php echo strtoupper($konu); ?> Konusuna Ait Sorular</h3>
                <div id="timer" class="timer mt-3">10</div>
                <p id="question" class="mt-4"></p>
                <div id="options" class="mt-3"></div>
                <button id="next-btn" class="btn btn-primary mt-3" style="display: none;">Sonraki Soru</button>
                <p id="score" class="mt-4" style="display: none;"></p>
            </div>

            <script>
                const questions = <?php echo json_encode($sorular); ?>;
                let currentQuestionIndex = 0;
                let score = 0;
                let timerInterval;
                let timeLeft = 10; // Her soru için süre (saniye)

                const questionElement = document.getElementById("question");
                const optionsElement = document.getElementById("options");
                const nextButton = document.getElementById("next-btn");
                const scoreElement = document.getElementById("score");
                const timerElement = document.getElementById("timer");

                function startTimer() {
                    timeLeft = 10; // Süreyi sıfırla
                    timerElement.textContent = timeLeft;

                    timerInterval = setInterval(() => {
                        timeLeft--;
                        timerElement.textContent = timeLeft;

                        if (timeLeft === 0) {
                            clearInterval(timerInterval);
                            disableOptions(); // Süre dolarsa seçenekler devre dışı bırakılır
                            nextButton.style.display = "block";
                        }
                    }, 1000);
                }

                function showQuestion() {
                    clearInterval(timerInterval); // Önceki sayacın durdurulması
                    startTimer(); // Yeni soru için sayaç başlatılır

                    const currentQuestion = questions[currentQuestionIndex];
                    questionElement.textContent = currentQuestion['soru'];

                    optionsElement.innerHTML = ""; // Seçenekleri temizle
                    currentQuestion['cevaplar'].forEach((option, index) => {
                        const button = document.createElement("button");
                        button.className = "btn btn-outline-primary btn-answer";
                        button.textContent = option;
                        button.addEventListener("click", () => checkAnswer(index));
                        optionsElement.appendChild(button);
                    });
                }

                function checkAnswer(selectedIndex) {
                    clearInterval(timerInterval); // Yanıt verildiğinde zaman durur
                    const correctIndex = questions[currentQuestionIndex]['dogru'];

                    // Seçeneklere tıklamayı kapat
                    document.querySelectorAll(".btn-answer").forEach(button => {
                        button.disabled = true;
                        if (button.textContent === questions[currentQuestionIndex]['cevaplar'][correctIndex]) {
                            button.classList.add("btn-success");
                        } else if (questions[currentQuestionIndex]['cevaplar'][selectedIndex] === button.textContent) {
                            button.classList.add("btn-danger");
                        }
                    });

                    if (selectedIndex === correctIndex) {
                        score++;
                    }

                    nextButton.style.display = "block";
                }

                function disableOptions() {
                    // Seçenekleri devre dışı bırak
                    document.querySelectorAll(".btn-answer").forEach(button => {
                        button.disabled = true;
                    });
                }

                function nextQuestion() {
                    currentQuestionIndex++;
                    if (currentQuestionIndex < questions.length) {
                        showQuestion();
                        nextButton.style.display = "none";
                    } else {
                        showScore();
                    }
                }

                function showScore() {
                    questionElement.style.display = "none";
                    optionsElement.style.display = "none";
                    nextButton.style.display = "none";
                    timerElement.style.display = "none";

                    scoreElement.style.display = "block";
                    scoreElement.textContent = `Tebrikler! Puanınız: ${score}/${questions.length}`;
                }

                nextButton.addEventListener("click", nextQuestion);

                showQuestion();
            </script>
        <?php endif; ?>
    </div>
</body>

</html>