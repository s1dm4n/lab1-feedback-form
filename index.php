<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form — Лабораторная работа</title>
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

        .form-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 40px;
            width: 100%;
            max-width: 550px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1a1a2e;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #444;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4a6cf7;
            box-shadow: 0 0 0 3px rgba(74,108,247,0.15);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 400;
            cursor: pointer;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            gap: 10px;
        }

        .btn {
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            text-decoration: none;
            display: inline-block;
            flex: 1;
            text-align: center;
        }

        .btn:active {
            transform: scale(0.97);
        }

        .btn-primary {
            background-color: #4a6cf7;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #3b5de7;
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
        <div class="form-container">
            <h2>📋 Форма обратной связи</h2>
            <form action="https://httpbin.org/post" method="POST">
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" id="username" name="username" placeholder="Введите ваше имя" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail пользователя</label>
                    <input type="email" id="email" name="email" placeholder="example@mail.ru" required>
                </div>

                <div class="form-group">
                    <label for="type">Тип обращения</label>
                    <select id="type" name="type" required>
                        <option value="" disabled selected>Выберите тип обращения</option>
                        <option value="жалоба">Жалоба</option>
                        <option value="предложение">Предложение</option>
                        <option value="благодарность">Благодарность</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Текст обращения</label>
                    <textarea id="message" name="message" placeholder="Опишите ваше обращение..." required></textarea>
                </div>

                <div class="form-group">
                    <label>Вариант ответа</label>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="reply_method" value="sms"> SMS
                        </label>
                        <label>
                            <input type="checkbox" name="reply_method" value="email"> E-mail
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">📤 Отправить</button>
                    <a href="result.php" class="btn btn-secondary">Страница 2 →</a>
                </div>
            </form>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        Задание для самостоятельной работы
    </footer>

</body>
</html>
