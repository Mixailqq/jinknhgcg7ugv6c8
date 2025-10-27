<?php
# Initialize the session
session_start();

# If user is not logged in then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  echo "<script>" . "window.location.href='./login.php';" . "</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="css.css">
  <link rel="stylesheet" href="milchik.cs">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
</head>
<style>
.button2 {
    padding: 15px 45px;
    border-radius: 5px;
    margin-top: 15px;
    margin-bottom: 15px;
    border: none;
    color: rgb(238, 234, 234);
    cursor: pointer;
    background-color: #cc4e14;
    width: 100%;
    font-size: 20px;
}

</style>

<body>







<nav class="navbar" id="navbar">
        <div class="logo">
<span><a href="index.php" class="button2">Liriki12 </a></span>
        </div>
        <div class="logo">

        <span><a href="index2.php" class="button2">Новости </a></span>
</div>
        <!-- Бургер меню -->
        <a  id="mobile-menu"></a>
    </nav>









    
    <!-- User profile -->
        <h4 class="my-4">Здравствуйте, <?= htmlspecialchars($_SESSION["username"]); ?>.</h4>
        <a href="./logout.php" class="btn btn-primary">Выйти</a>
    

<br>
<br>
<br>
<a href="" class="btn btn-primary">Добавить</a>
<br>
<br>
<br>
        
  <?php
// Убедимся, что config.php подключен и соединение с БД установлено
require_once 'config.php';


// Получаем действие из GET параметра
$action = isset($_GET['action']) ? $_GET['action'] : 'pages';
?>

<!-- Навигация в sidebar -->
<ul class="nav-list">
    
    <li>
        <a href="admin.php?action=news" 
           class="<?php echo ($action == 'news' || $action == 'add_news' || $action == 'edit_news') ? 'active' : ''; ?>">
           Новости
        </a>
    </li>
    <li>
        <a href="admin.php?action=add_news" 
           class="<?php echo ($action == 'add_news') ? 'active' : ''; ?>">
           Добавить новость
        </a>
    </li>
</ul>

<!-- Основной контент -->
<div class="content">
    <?php
    switch($action) {
        case 'news':
            // Получаем все новости
            $news = getAllNews();
            ?>
            <div class="page-list">
                <h2>Управление новостями</h2>
                <a href="admin.php?action=add_news" class="btn btn-success">Добавить новость</a>
                
                <?php if (empty($news)): ?>
                    <div class="no-data">
                        <p>Новостей пока нет. <a href="admin.php?action=add_news">Добавить первую новость</a></p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="news-table">
                            <thead>
                                <tr>
                                    <th width="50">ID</th>
                                    <th>Заголовок</th>
                                    <th width="120">Дата</th>
                                    <th width="150">Изображения</th>
                                    <th width="200">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($news as $item): ?>
                                <tr>
                                    <td><?php echo (int)$item['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['title']); ?></strong>
                                        <?php if (strlen($item['title']) > 50): ?>
                                            <br><small><?php echo htmlspecialchars(substr($item['title'], 0, 50)) . '...'; ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d.m.Y', strtotime($item['news_date'])); ?></td>
                                    <td>
                                        <?php if (!empty($item['images'])): 
                                            $imageCount = count(explode(',', $item['images']));
                                            echo $imageCount . ' ' . ($imageCount == 1 ? 'изображение' : 'изображений');
                                        else: ?>
                                            <span class="no-images">Нет</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="actions">
                                        <a href="admin.php?action=edit_news&id=<?php echo (int)$item['id']; ?>" 
                                           class="btn btn-primary btn-sm">Редактировать</a>
                                        <a href="admin.php?action=delete_news&id=<?php echo (int)$item['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Вы уверены, что хотите удалить новость \"<?php echo addslashes($item['title']); ?>\"?')">
                                           Удалить
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            break;

        case 'add_news':
        case 'edit_news':
            // Инициализируем переменные
            $news_item = [
                'id' => '', 
                'title' => '', 
                'content' => '', 
                'images' => '', 
                'news_date' => date('Y-m-d')
            ];
            $error = '';
            $success = '';

            // Если редактируем существующую новость
            if (isset($_GET['id']) && $action == 'edit_news') {
                $id = (int)$_GET['id'];
                $news_item = getNewsById($id);
                if (!$news_item) {
                    $error = "Новость с ID $id не найдена";
                }
            }

            // Обработка формы
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Валидация данных
                $title = trim($_POST['title']);
                $content = trim($_POST['content']);
                $images = trim($_POST['images']);
                $news_date = trim($_POST['news_date']);

                // Проверка обязательных полей
                if (empty($title) || empty($content) || empty($news_date)) {
                    $error = "Заполните все обязательные поля";
                } elseif (!strtotime($news_date)) {
                    $error = "Некорректная дата";
                } else {
                    // Экранируем данные
                    $title = escape($title);
                    $content = escape($content);
                    $images = escape($images);
                    $news_date = date('Y-m-d', strtotime($news_date));

                    try {
                        if (!empty($news_item['id'])) {
                            // Обновление существующей новости
                            $sql = "UPDATE news SET title = ?, content = ?, images = ?, news_date = ? WHERE id = ?";
                            $stmt = mysqli_prepare($link, $sql);
                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, "ssssi", $title, $content, $images, $news_date, $news_item['id']);
                                if (mysqli_stmt_execute($stmt)) {
                                    $success = "Новость успешно обновлена";
                                    // Обновляем данные для отображения
                                    $news_item = getNewsById($news_item['id']);
                                } else {
                                    $error = "Ошибка при обновлении: " . mysqli_error($link);
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            // Добавление новой новости
                            $sql = "INSERT INTO news (title, content, images, news_date) VALUES (?, ?, ?, ?)";
                            $stmt = mysqli_prepare($link, $sql);
                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, "ssss", $title, $content, $images, $news_date);
                                if (mysqli_stmt_execute($stmt)) {
                                    $success = "Новость успешно добавлена";
                                    // Очищаем форму
                                    $news_item = [
                                        'id' => '', 
                                        'title' => '', 
                                        'content' => '', 
                                        'images' => '', 
                                        'news_date' => date('Y-m-d')
                                    ];
                                } else {
                                    $error = "Ошибка при добавлении: " . mysqli_error($link);
                                }
                                mysqli_stmt_close($stmt);
                            }
                        }
                    } catch (Exception $e) {
                        $error = "Произошла ошибка: " . $e->getMessage();
                    }
                }
            }
            ?>
            <div class="page-list">
                <h2><?php echo (!empty($news_item['id'])) ? 'Редактировать новость' : 'Добавить новость'; ?></h2>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <form method="POST" class="news-form">
                    <div class="form-group">
                        <label for="title">Заголовок *</label>
                        <input type="text" id="title" name="title" class="form-control" 
                               value="<?php echo htmlspecialchars($news_item['title']); ?>" 
                               required maxlength="255">
                    </div>
                    
                    <div class="form-group">
                        <label for="news_date">Дата публикации *</label>
                        <input type="date" id="news_date" name="news_date" class="form-control" 
                               value="<?php echo htmlspecialchars($news_item['news_date']); ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="images">Изображения</label>
                        <input type="text" id="images" name="images" class="form-control" 
                               value="<?php echo htmlspecialchars($news_item['images']); ?>" 
                               placeholder="image1.jpg, image2.jpg, image3.jpg">
                        <small class="form-text">Укажите названия файлов через запятую. Файлы должны быть загружены на сервер.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="content">Содержимое *</label>
                        <textarea id="content" name="content" class="form-control" 
                                  rows="12" required><?php echo htmlspecialchars($news_item['content']); ?></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <?php echo (!empty($news_item['id'])) ? 'Обновить' : 'Добавить'; ?> новость
                        </button>
                        <a href="admin.php?action=news" class="btn btn-secondary">Отмена</a>
                        
                        <?php if (!empty($news_item['id'])): ?>
                            <a href="admin.php?action=delete_news&id=<?php echo (int)$news_item['id']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Вы уверены, что хотите удалить эту новость?')">
                               Удалить новость
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <?php
            break;

        case 'delete_news':
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                
                // Проверяем существование новости
                $news_item = getNewsById($id);
                if ($news_item) {
                    $sql = "DELETE FROM news WHERE id = ?";
                    $stmt = mysqli_prepare($link, $sql);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "i", $id);
                        if (mysqli_stmt_execute($stmt)) {
                            $_SESSION['success_message'] = "Новость \"{$news_item['title']}\" успешно удалена";
                        } else {
                            $_SESSION['error_message'] = "Ошибка при удалении: " . mysqli_error($link);
                        }
                        mysqli_stmt_close($stmt);
                    }
                } else {
                    $_SESSION['error_message'] = "Новость не найдена";
                }
                
                header("Location: admin.php?action=news");
                exit();
            }
            break;

        default:
            // Обработка других действий (pages и т.д.)
            // Здесь может быть ваш существующий код для управления страницами
            break;
    }
    ?>
</div>

<style>
/* Дополнительные стили для улучшения интерфейса */
.table-responsive {
    overflow-x: auto;
}

.news-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.news-table th,
.news-table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

.news-table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.news-table tr:hover {
    background-color: #f5f5f5;
}

.actions {
    white-space: nowrap;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 14px;
    margin: 2px;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: #666;
}

.alert {
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.form-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #545b62;
}

.no-images {
    color: #999;
    font-style: italic;
}

.news-form .form-text {
    color: #6c757d;
    font-size: 0.875em;
    margin-top: 5px;
}
</style>


    <br>
    <br>
    <br>


    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        table { border-collapse: collapse; margin: 20px 0; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>

    <h1>Данные из базы данных</h1>
    
    <?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'demo2';

    // Подключаемся к базе данных
    $connection = mysqli_connect($host, $user, $password, $db);

    if (!$connection) {
        exit("<p class='error'>Connection failed: " . mysqli_connect_error() . "</p>");
    }

    echo "<p class='success'>Connected successfully</p>";

    // Установка кодировки
    mysqli_set_charset($connection, "utf8");

    // Пример 1: Вывод списка таблиц в базе данных
    echo "<h2>Таблицы в базе данных:</h2>";
    $result = mysqli_query($connection, "SHOW TABLES");
    
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<ul>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Таблицы не найдены</p>";
    }

    // Пример 2: Вывод данных из конкретной таблицы (замените 'your_table' на реальное имя таблицы)
    $table_name = "users"; // Замените на имя вашей таблицы
    
    // Проверяем существование таблицы
    $table_check = mysqli_query($connection, "SHOW TABLES LIKE '$table_name'");
    
    if (mysqli_num_rows($table_check) > 0) {
        echo "<h2>Данные из таблицы: $table_name</h2>";
        
        $query = "SELECT * FROM $table_name";
        $result = mysqli_query($connection, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>";
            
            // Вывод названий колонок
            $fields = mysqli_fetch_fields($result);
            foreach ($fields as $field) {
                echo "<th>" . $field->name . "</th>";
            }
            echo "</tr>";
            
            // Вывод данных
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>В таблице '$table_name' нет данных или произошла ошибка: " . mysqli_error($connection) . "</p>";
        }
    } else {
        echo "<p class='error'>Таблица '$table_name' не найдена в базе данных</p>";
        
        // Показываем пример создания таблицы
        echo "<h3>Пример создания таблицы:</h3>";
        echo "<pre>
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email) VALUES 
('Иван Иванов', 'ivan@example.com'),
('Петр Петров', 'petr@example.com'),
('Мария Сидорова', 'maria@example.com');
        </pre>";
    }
// Закрываем соединение
    mysqli_close($connection);
    ?>
    <br>
    <br>
    <br>
    <br>
</body>

</html>