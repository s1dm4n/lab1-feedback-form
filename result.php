<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>get_headers() — Лабораторная работа</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- HEADER -->
<header>
    <div class="header-left">
        <img src="https://mospolytech.ru/local/templates/main/dist/img/logos/mospolytech-logo-white.svg" alt="Логотип МосПолитеха">
    </div>
    <div class="header-center">Задание для самостоятельной работы «Feedback form»</div>
    <div style="width:120px;"></div>
</header>

<!-- MAIN -->
<main>
    <div class="result-container">
        <h2>Результат работы функции get_headers()</h2>
        <textarea readonly><?php
$url = 'https://httpbin.org/post';
$headers = @get_headers($url, 1);

if ($headers !== false) {
    echo "URL: {$url}\n";
    echo str_repeat('═', 70) . "\n\n";
    foreach ($headers as $key => $value) {
        if (is_int($key)) {
            echo $value . "\n";
        } else {
            echo "{$key}: {$value}\n";
        }
    }
} else {
    echo "Ошибка: не удалось получить заголовки.\n";
    echo "Проверьте подключение к интернету или доступность сайта {$url}.";
}
?></textarea>
        <div class="back-link">
            <a href="index.php" class="btn btn-secondary">
                <span class="btn__text">Вернуться к форме</span>
            </a>
        </div>
    </div>
</main>

<!-- FOOTER -->
<footer>Задание для самостоятельной работы</footer>

</body>
</html>
