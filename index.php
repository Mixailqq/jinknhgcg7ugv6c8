
<!DOCTYPE html><html lang="ru"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница | Liriki12 </title>


    <link rel="stylesheet" href="milchik.css">
  
</head>



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

</style>







<body>
    <!-- Партиклы фона -->
    <div class="particles" id="particles"></div>
    
    <!-- Глитч-эффект -->
    <div class="glitch-effect"></div>
    <!-- Навигация -->
    <nav class="navbar" id="navbar">
        <div class="logo">
            <span class="logo-text">Liriki12</span>
        </div>
        <div class="logo">
        <span><a href="index2.php" class="logo-text2">Новости </a></span>
</div>
        <!-- Бургер меню -->
        <div class="menu-toggle" id="mobile-menu">
            <span></span>
            <span></span>
            <span></span>
            
        </div>
    </nav>
    
    <!-- Мобильное меню -->
    <div class="mobile-menu" id="menu">
        <a href="#social" class="btn">Соц сети</a>
        <a href="#biography" class="btn">Биография</a>
    </div>

    <section class="hero">
        <div class="hero-content">
            <p class="hero-subtitle">Листай вниз, чтобы узнать чуть больше обо мне!</p>
        </div>
    </section>
   
        <section class="section" id="social">
            <div class="section-title-container">
                <h2 class="section-title animate-on-scroll">Соц сети</h2>
            </div>
            
            <div class="cards-container">
                <div class=" card animate-on-scroll">
                    <div class="card-content ">
                        <h3 class="card-title">Telegram</h3>
                        <p class="card-description">Свяжитесь со мной через Telegram. Отвечаю практически быстро и всегда на связи!</p>
                        <div class="card-buttons  cardneon">
                            <a href="https://t.me/Liriki12" target="_blank" class="card-btn cardneon2">
                                <img src="Tg.webp" alt="Telegram">
                                Основной аккаунт 
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card animate-on-scroll">
                    <div class="card-content">
                        <h3 class="card-title">ВКонтакте</h3>
                        <p class="card-description">Мой аккаунт ВКонтакте для тех, кто предпочитает эту платформу. Учтите, что я редко там бываю - лучше писать в Telegram.</p>
                        <div class="card-buttons cardneon">
                            <a href="https://vk.com/timofei_127" target="_blank" class="cardneon2 card-btn">
                                <img src="VK.png" alt="VK">
                                ВКонтакте
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card animate-on-scroll">
                    <div class="card-content">
                        <h3 class="card-title">Gmail</h3>
                        <p class="card-description ">Общение здесь бесплатное, но ответы могут задержаться — я чаще онлайн на основном аккаунте. Имейте терпение.</p>
                        <div class="card-buttons cardneon">
                            <a href="mailto:tv1111cer@gmail.com" target="_blank" class="cardneon2 card-btn">
                                <img src="Gmail.png" alt="Gmail" class="">
                                Gmail
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card animate-on-scroll">
                    <div class="card-content">
                        <h3 class="card-title">Мой канал</h3>
                        <p class="card-description">В канале ты можешь узнать о бомне немного побольше.</p>
                        <div class="card-buttons cardneon">
                            <a href="https://t.me/Timofei33" target="_blank"  class="cardneon2 card-btn">
                                <img src="Tg.webp" width="12" alt="Telegram канал">
                                Telegram канал
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        
        <!-- Секция биографии -->
        <section class="section" id="biography">
            <div class="section-title-container">
                <h2 class="section-title animate-on-scroll">Биография</h2>
            </div>
            
            <div class="cards-container">
                <div class="card animate-on-scroll">
                    <div class="card-content">
                        <h3 class="card-title">Моё био</h3>
                        <p class="card-description">Меня зовут Тимофей.</p>
                        <p class="card-description">Я проживаю в г.Туле</p>
                    </div>
                </div>
            </div>
        </section>
        
        
        <!-- Футер -->
        <footer class="footer" style="background: transparent; color: white; padding: 20px 0; border-top: none;">
            <div class="footer-content">
                <div class="footer-logo">
                    <span style="color: white;">
                        © 2025 ООО « Liriki12.ru »<br>
                        
                    </span>
                </div>          
            </div>
        </footer>
      
        
        
        
        
        
        
        
        <script src="milchik.js"></script>
    </body></html>