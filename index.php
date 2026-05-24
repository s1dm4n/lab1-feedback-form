<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form — Лабораторная работа</title>
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
        <div class="form-container">
            <h2>Форма обратной связи</h2>
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
                    <button type="submit" class="btn btn-primary">
                        <span class="btn__text">Отправить</span>
                    </button>
                    <a  href="result.php" class="btn btn-secondary">
                        <span class="btn__text">Результат</span>
                    </a>
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
