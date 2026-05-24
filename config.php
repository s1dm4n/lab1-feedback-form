<?php
/**
 * Конфигурация подключения к базе данных MySQL
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');        // По умолчанию в XAMPP пароль пустой
define('DB_NAME', 'feedback_db');

/**
 * Получение соединения с БД
 * @return PDO
 */
function getDBConnection(): PDO
{
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die('Ошибка подключения к базе данных: ' . $e->getMessage());
    }
}

/**
 * Инициализация базы данных и таблиц
 */
function initDatabase(): void
{
    try {
        // Подключаемся без указания БД, чтобы создать её
        $dsn = 'mysql:host=' . DB_HOST . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        // Создаём базу данных, если не существует
        $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        $pdo->exec('USE `' . DB_NAME . '`');

        // Создаём таблицу обращений
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `feedback` (
                `id`         INT AUTO_INCREMENT PRIMARY KEY,
                `username`   VARCHAR(100)  NOT NULL,
                `email`      VARCHAR(150)  NOT NULL,
                `type`       ENUM('жалоба','предложение','благодарность') NOT NULL,
                `message`    TEXT          NOT NULL,
                `reply_method` VARCHAR(50) NOT NULL DEFAULT '',
                `created_at` TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    } catch (PDOException $e) {
        die('Ошибка инициализации базы данных: ' . $e->getMessage());
    }
}
