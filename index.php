<?php
/**
 * Главная страница — Форма обратной связи + список обращений (CRUD)
 */

require_once __DIR__ . '/config.php';

// Инициализация БД
initDatabase();
$db = getDBConnection();

// ===== Обработка действий =====

// DELETE — удаление обращения
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $db->prepare('DELETE FROM `feedback` WHERE `id` = ?');
    $stmt->execute([$id]);
    header('Location: index.php?msg=deleted');
    exit;
}

// UPDATE — обновление обращения
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id          = (int) $_POST['id'];
    $username    = trim($_POST['username']);
    $email       = trim($_POST['email']);
    $type        = $_POST['type'];
    $message     = trim($_POST['message']);
    $replyMethod = isset($_POST['reply_method']) ? implode(', ', $_POST['reply_method']) : '';

    $stmt = $db->prepare('UPDATE `feedback` SET `username` = ?, `email` = ?, `type` = ?, `message` = ?, `reply_method` = ? WHERE `id` = ?');
    $stmt->execute([$username, $email, $type, $message, $replyMethod, $id]);
    header('Location: index.php?msg=updated');
    exit;
}

// CREATE — новое обращение
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $username    = trim($_POST['username']);
    $email       = trim($_POST['email']);
    $type        = $_POST['type'];
    $message     = trim($_POST['message']);
    $replyMethod = isset($_POST['reply_method']) ? implode(', ', $_POST['reply_method']) : '';

    $stmt = $db->prepare('INSERT INTO `feedback` (`username`, `email`, `type`, `message`, `reply_method`) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$username, $email, $type, $message, $replyMethod]);
    header('Location: index.php?msg=created');
    exit;
}

// Получаем все обращения
$feedbacks = $query = $db->query('SELECT * FROM `feedback` ORDER BY `created_at` DESC')->fetchAll();

// Получаем одно обращение для редактирования
$editItem = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare('SELECT * FROM `feedback` WHERE `id` = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $editItem = $stmt->fetch();
}

// Сообщения
$messages = [
    'created' => '✅ Обращение успешно добавлено!',
    'updated' => '✅ Обрашение успешно обновлено!',
    'deleted' => '🗑️ Обращение удалено.',
];
$msg = isset($_GET['msg']) && isset($messages[$_GET['msg']]) ? $messages[$_GET['msg']] : '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form — Лабораторная работа</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* HEADER */
        header {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .header-left img { height: 50px; }
        .header-center { font-size: 1.2rem; font-weight: 600; color: #1a1a2e; }

        /* MAIN */
        main {
            flex: 1;
            padding: 40px 20px;
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
        }

        /* ALERT */
        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 500;
        }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        /* FORM */
        .form-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 35px;
            margin-bottom: 40px;
        }
        .form-container h2 { margin-bottom: 25px; color: #1a1a2e; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; color: #444; }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group select,
        .form-group textarea {
            width: 100%; padding: 10px 14px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none; border-color: #4a6cf7; box-shadow: 0 0 0 3px rgba(74,108,247,0.15);
        }
        .form-group textarea { resize: vertical; min-height: 90px; }
        .checkbox-group { display: flex; gap: 20px; }
        .checkbox-group label { display: flex; align-items: center; gap: 6px; font-weight: 400; cursor: pointer; }
        .btn { padding: 10px 24px; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer; transition: background 0.2s; }
        .btn-primary { background-color: #4a6cf7; color: #fff; }
        .btn-primary:hover { background-color: #3b5de7; }
        .btn-secondary { background-color: #e0e0e0; color: #333; text-decoration: none; }
        .btn-secondary:hover { background-color: #d0d0d0; }
        .btn-danger { background-color: #dc3545; color: #fff; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-sm { padding: 6px 14px; font-size: 0.85rem; }

        /* TABLE */
        .table-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 35px;
            overflow-x: auto;
        }
        .table-container h2 { margin-bottom: 20px; color: #1a1a2e; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 14px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #f8f9fa; font-weight: 600; color: #555; }
        tr:hover { background-color: #f8f9fa; }
        .actions { display: flex; gap: 6px; }

        /* FOOTER */
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
        <img src="https://mospolytech.ru/local/templates/main/img/logo.svg" alt="МосПолитех"
             onerror="this.src='https://via.placeholder.com/120x50?text=МосПолитех'">
    </div>
    <div class="header-center">Задание для самостоятельной работы «Feedback form»</div>
    <div style="width:120px;"></div>
</header>

<!-- MAIN -->
<main>
    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- ФОРМА СОЗДАНИЯ / РЕДАКТИРОВАНИЯ -->
    <div class="form-container">
        <h2><?= $editItem ? '✏️ Редактирование обращения #' . (int)$editItem['id'] : '📝 Новое обращение' ?></h2>
        <form method="POST" action="index.php">
            <input type="hidden" name="action" value="<?= $editItem ? 'update' : 'create' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Имя пользователя</label>
                <input type="text" id="username" name="username"
                       value="<?= $editItem ? htmlspecialchars($editItem['username']) : '' ?>"
                       placeholder="Введите ваше имя" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail пользователя</label>
                <input type="email" id="email" name="email"
                       value="<?= $editItem ? htmlspecialchars($editItem['email']) : '' ?>"
                       placeholder="example@mail.ru" required>
            </div>

            <div class="form-group">
                <label for="type">Тип обращения</label>
                <select id="type" name="type" required>
                    <option value="" disabled <?= !$editItem ? 'selected' : '' ?>>Выберите тип обращения</option>
                    <?php foreach (['жалоба', 'предложение', 'благодарность'] as $t): ?>
                        <option value="<?= $t ?>" <?= ($editItem && $editItem['type'] === $t) ? 'selected' : '' ?>>
                            <?= ucfirst($t) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="message">Текст обращения</label>
                <textarea id="message" name="message" placeholder="Опишите ваше обращение..."
                          required><?= $editItem ? htmlspecialchars($editItem['message']) : '' ?></textarea>
            </div>

            <div class="form-group">
                <label>Вариант ответа</label>
                <div class="checkbox-group">
                    <?php
                    $checkedMethods = $editItem ? explode(', ', $editItem['reply_method']) : [];
                    foreach (['sms' => 'SMS', 'email' => 'E-mail'] as $val => $label):
                    ?>
                        <label>
                            <input type="checkbox" name="reply_method[]" value="<?= $val ?>"
                                <?= in_array($val, $checkedMethods) ? 'checked' : '' ?>>
                            <?= $label ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div style="display:flex;gap:10px;align-items:center;">
                <button type="submit" class="btn btn-primary">
                    <?= $editItem ? '💾 Сохранить' : '📤 Отправить' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="index.php" class="btn btn-secondary">Отмена</a>
                <?php endif; ?>
                <a href="result.php" class="btn btn-secondary">Страница 2 →</a>
            </div>
        </form>
    </div>

    <!-- ТАБЛИЦА ОБРАЩЕНИЙ (READ) -->
    <div class="table-container">
        <h2>📋 Все обращения (<?= count($feedbacks) ?>)</h2>
        <?php if (empty($feedbacks)): ?>
            <p style="color:#888;">Пока нет ни одного обращения.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>E-mail</th>
                        <th>Тип</th>
                        <th>Сообщение</th>
                        <th>Ответ через</th>
                        <th>Дата</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $fb): ?>
                        <tr>
                            <td><?= (int)$fb['id'] ?></td>
                            <td><?= htmlspecialchars($fb['username']) ?></td>
                            <td><?= htmlspecialchars($fb['email']) ?></td>
                            <td><?= htmlspecialchars($fb['type']) ?></td>
                            <td><?= htmlspecialchars(mb_strimwidth($fb['message'], 0, 60, '…')) ?></td>
                            <td><?= htmlspecialchars($fb['reply_method']) ?></td>
                            <td><?= $fb['created_at'] ?></td>
                            <td class="actions">
                                <a href="index.php?edit=<?= (int)$fb['id'] ?>" class="btn btn-sm btn-secondary">✏️</a>
                                <a href="index.php?delete=<?= (int)$fb['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Удалить обращение #<?= (int)$fb['id'] ?>?')">🗑️</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<!-- FOOTER -->
<footer>Задание для самостоятельной работы</footer>

</body>
</html>
