<?php
// index.php
session_start();

// Список слов для угадывания
$words = [
    'ЯКУБОВИЧ',
    'ШЛЁПА',
    'ИГРА',
    'УГАДАЙ',
    'БУКВА'
];

// Выбираем случайное слово
if (!isset($_SESSION['word'])) {
    $_SESSION['word'] = $words[array_rand($words)];
    $_SESSION['guessed'] = array_fill(0, strlen($_SESSION['word']), false);
    $_SESSION['attempts'] = 6;
}

$word = $_SESSION['word'];
$guessed = $_SESSION['guessed'];
$attempts = $_SESSION['attempts'];

// Обработчик ввода буквы
if (isset($_POST['letter'])) {
    $letter = strtoupper($_POST['letter']);
    $found = false;

    for ($i = 0; $i < strlen($word); $i++) {
        if ($word[$i] === $letter && !$guessed[$i]) {
            $guessed[$i] = true;
            $found = true;
        }
    }

    if (!$found) {
        $attempts--;
    }

    $_SESSION['guessed'] = $guessed;
    $_SESSION['attempts'] = $attempts;

    // Проверка победы
    if (!in_array(false, $guessed)) {
        echo "<script>alert('Поздравляем! Вы угадали слово: $word!');</script>";
        session_destroy();
        header('Refresh: 0');
    }

    // Проверка проигрыша
    if ($attempts <= 0) {
        echo "<script>alert('Вы проиграли! Загаданное слово: $word.');</script>";
        session_destroy();
        header('Refresh: 0');
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поле чудес с Якубовичем и Шлёпой</title>
</head>
<body>
    <h1> Поле чудес с Якубовичем и Шлёпой! </h1>

    <!-- Изображение Якубовича -->
    <div style="text-align: center; margin: 20px 0;">
        <img src="https://via.placeholder.com/200x150?text=Якубович" alt="Якубович" style="border: 2px solid gold;">
    </div>

    <!-- Изображение Шлёпы -->
    <div style="text-align: center; margin: 20px 0;">
        <img src="https://via.placeholder.com/150x150?text=Шлёпа" alt="Шлёпа" style="border: 2px dashed pink;">
    </div>

    <p><strong>Попыток осталось:</strong> <?php echo $attempts; ?></p>

    <p><strong>Слово:</strong></p>
    <div style="font-size: 24px; font-weight: bold; margin: 20px 0;">
        <?php
        for ($i = 0; $i < strlen($word); $i++) {
            echo $guessed[$i] ? $word[$i] : '_';
            echo ' ';
        }
        ?>
    </div>

    <form method="post" style="margin: 20px 0;">
        <label for="letter">Введите букву:</label>
        <input type="text" id="letter" name="letter" maxlength="1" required style="padding: 5px; width: 30px; text-transform: uppercase;">
        <button type="submit" style="padding: 5px 10px;">Угадать</button>
    </form>

    <button onclick="location.reload()" style="padding: 5px 10px; background: #ff9900; color: white; border: none; cursor: pointer;">
        Новая игра
    </button>

    <div style="margin-top: 30px; padding: 10px; border: 1px solid #ccc; background: #f9f9f9;">
        <h3>Правила игры:</h3>
        <ul>
            <li>Якубович загадал слово, а Шлёпа вам помогает!</li>
            <li>У вас есть <?php echo $attempts; ?> попыток.</li>
            <li>Вводите по одной букве.</li>
            <li>Если буква есть в слове, она откроется.</li>
            <li>Если буквы нет, количество попыток уменьшится.</li>
            <li>Удачи!</li>
        </ul>
    </div>
</body>
</html>
