<?php
session_start();


define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "demo2");

// Подключение к базе данных
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Проверка подключения
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Установка кодировки
mysqli_set_charset($link, "utf8");

/**
 * Функция для проверки авторизации пользователя
 */


/**
 * Функция для получения всех новостей
 */
function getAllNews() {
    global $link;
    $sql = "SELECT * FROM news ORDER BY news_date DESC, created_at DESC";
    $result = mysqli_query($link, $sql);
    $news = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $news[] = $row;
    }
    return $news;
}

/**
 * Функция для получения новости по ID
 */
function getNewsById($id) {
    global $link;
    $sql = "SELECT * FROM news WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

/**
 * Функция для безопасного вывода данных
 */
function escape($data) {
    global $link;
    return mysqli_real_escape_string($link, htmlspecialchars(trim($data)));
}
?>