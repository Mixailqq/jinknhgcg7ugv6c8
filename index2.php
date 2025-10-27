<?php
require_once 'config.php';

// Получаем все новости
$news = getAllNews();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница | Liriki12</title>
    <link rel="stylesheet" href="/milchik.css">
    <style>
        .cardneon{
            width: 173px;
            height: 89px;
            background-image: linear-gradient(163deg, #61796c 11%, #5fc49d 100%);
            border-radius: 20px;
            transition: all .3s;
        }
        .cardneon2{
            width: 173px;
            height: 89px;
            background-color: #000000;
            border-radius:;
            transition: all .6s;
        }
        .cardneon:hover {
            box-shadow: 0px 0px 30px 1px rgba(0, 255, 177, 0.30);
        }
        .cardneon2:hover {transform: scale(0.98); border-radius: 20px;}

        .btn3{
            display: inline-block;
            padding: 18px 40px;
            background: linear-gradient(45deg, #45db9d, #61f327);
            color: rgb(255, 255, 255);
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            text-decoration: none;
            margin: 15px;
            box-shadow: 0 10px 30px rgba(212, 186, 186, 0.4);
            position: relative;
            overflow: hidden;
            letter-spacing: 1px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0s 0s forwards;
        }
        .img5{flex-wrap: wrap;}
        .news-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin: 5px;
            border-radius: 8px;
        }
        .news-date {
            text-align: right;
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <!-- Партиклы фона -->
    <div class="particles" id="particles"></div>
    
    <!-- Глитч-эффект -->
    <div class="glitch-effect"></div>
    
    <!-- Навигация -->
    <nav class="navbar" id="navbar">
        <div class="logo">
            <span class="logo-text">Новости</span>
        </div>
        <div class="logo">
            <span><a href="index.php" class="logo-text2">Liriki12</a></span>
        </div>
        <!-- Бургер меню -->
        <a id="mobile-menu"></a>
    </nav>

    <!-- Основной контент с новостями -->
    <section class="section" id="social">
        <div class="section-title-container">
            <h2 class="section-title animate-on-scroll">Новости из соц сетей</h2>
        </div>
        
        <div class="cards-container">
            <?php if (empty($news)): ?>
                <div class="card animate-on-scroll">
                    <div class="card-content">
                        <p>Новостей пока нет</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach($news as $item): ?>
                <div class="card animate-on-scroll">
                    <div class="card-content">
                        <p class="news-date"><?php echo date('d.m.Y', strtotime($item['news_date'])); ?></p>
                        <br>
                        
                        <?php if (!empty($item['images'])): ?>
                        <div class="img5">
                            <?php 
                            $images = explode(',', $item['images']);
                            foreach($images as $image): 
                                if (!empty(trim($image))):
                            ?>
                                <img src="<?php echo htmlspecialchars(trim($image)); ?>" class="news-image" alt="">
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                        <br><br>
                        <?php endif; ?>
                        
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <div class="news-content">
                            <?php echo nl2br(htmlspecialchars($item['content'])); ?>
                        </div>
                        <br>
                        <div class="card-buttons cardneon">
                            <a href="https://t.me/Liriki12" target="_blank" class="card-btn cardneon2">
                                <img src="Tg.webp" alt="Telegram" style="width: 20px; height: 20px;">
                                Telegram канал 
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Футер -->
    <footer class="footer" style="background: transparent; color: white; padding: 20px 0; border-top: none;">
        <div class="footer-content">
            <div class="footer-logo">
                <span style="color: white;">
                    <a href="admin.php" style="color: rgba(255, 255, 255, 1)">© 2025 ООО « Liriki12.ru »</a><br>
                </span>
            </div>          
        </div>
    </footer>

    <script src="/milchik.js"></script>
</body>
</html>
