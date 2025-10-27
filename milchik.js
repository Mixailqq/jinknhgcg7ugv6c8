// Защита от скачивания изображений
    document.addEventListener('DOMContentLoaded', function() {
        // Блокировка контекстного меню для всех изображений
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.oncontextmenu = function() { return false; };
            img.draggable = false;
            
            // Защита от перетаскивания
            img.addEventListener('dragstart', function(e) {
                e.preventDefault();
                return false;
            });
        });
        
        // Блокировка клавиш PrintScreen и других
        document.addEventListener('keydown', function(e) {
            // Блокировка PrintScreen, Ctrl+P, Ctrl+S и т.д.
            if (e.key === "PrintScreen" || 
                (e.ctrlKey && e.key === "p") || 
                (e.ctrlKey && e.key === "s")) {
                e.preventDefault();
                return false;
            }
        });
    });

    // Обработчик для mailto ссылок
    function handleMailClick(event, email) {
        event.preventDefault();
        window.location.href = `mailto:${email}`;
        return false;
    }

    // Инициализация партиклов
    function initParticles() {
        const container = document.getElementById('particles');
        const particleCount = window.innerWidth < 768 ? 15 : 30;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Случайные параметры
            const size = Math.random() * 30 + 10;
            const posX = Math.random() * 100;
            const delay = Math.random() * 15;
            const duration = Math.random() * 10 + 10;
            
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.left = `${posX}%`;
            particle.style.animationDelay = `${delay}s`;
            particle.style.animationDuration = `${duration}s`;
            particle.style.opacity = Math.random() * 0.3;
            
            container.appendChild(particle);
        }
    }
    
    // Анимация навигации при скролле
    function handleScroll() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    
    // Анимация элементов при скролле
    function animateOnScroll() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        const windowHeight = window.innerHeight;
        const triggerPoint = windowHeight * 0.8;
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            
            if (elementTop < triggerPoint) {
                element.classList.add('animated');
            }
        });
    }
    
    // Плавный скролл для якорных ссылок
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
                
                // Закрываем мобильное меню, если оно открыто
                const menu = document.getElementById('menu');
                const menuToggle = document.getElementById('mobile-menu');
                if (menu.classList.contains('active')) {
                    menu.classList.remove('active');
                    menuToggle.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            }
        });
    });
    
    // Мобильное меню
    const menuToggle = document.getElementById('mobile-menu');
    const menu = document.getElementById('menu');
    
    menuToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        menu.classList.toggle('active');
        
        if (menu.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    });
    
    // Закрытие меню при клике на ссылку
    const menuLinks = document.querySelectorAll('.mobile-menu a');
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            menuToggle.classList.remove('active');
            menu.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    });
    
    // Инициализация
    document.addEventListener('DOMContentLoaded', function() {
        initParticles();
        window.addEventListener('scroll', handleScroll);
        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll(); // Проверить сразу при загрузке
    });