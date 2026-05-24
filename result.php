<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>get_headers() — Лабораторная работа</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ===== HEADER ===== */
        header {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-left img {
            height: 50px;
        }

        .header-center {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1a1a2e;
        }

        /* ===== MAIN ===== */
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px;
        }

        .result-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 40px;
            width: 100%;
            max-width: 850px;
        }

        .result-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #1a1a2e;
        }

        textarea {
            width: 100%;
            min-height: 420px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-family: 'Consolas', 'Courier New', monospace;
            font-size: 0.85rem;
            line-height: 1.6;
            resize: vertical;
            background-color: #f8f9fa;
            color: #333;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-secondary {
            background-color: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #d0d0d0;
        }

        /* ===== FOOTER ===== */
        footer {
            background-color: #1a1a2e;
            color: #ccc;
            text-align: center;
            padding: 15px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<header>
    <div class="header-left">
        <img src="https://mospolytech.ru/local/templates/main/img/logo.svg" alt="Логотип МосПолитеха" onerror="this.src='https://via.placeholder.com/120x50?text=МосПолитех'">
    </div>
    <div class="header-center">Задание для самостоятельной работы «Feedback form»</div>
    <div style="width:120px;"></div>
</header>

<!-- MAIN -->
<main>
    <div class="result-container">
        <h2>📡 Результат работы функции get_headers()</h2>
        <textarea readonly><?php
$url = 'https://mospolytech.ru';
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
    echo "❌ Ошибка: не удалось получить заголовки.\n";
    echo "Проверьте подключение к интернету или доступность сайта {$url}.";
}
?></textarea>
        <div class="back-link">
            <a href="index.php" class="btn btn-secondary">← Вернуться к форме</a>
        </div>
    </div>
</main>

<!-- FOOTER -->
<footer>Задание для самостоятельной работы</footer>

</body>
</html>
