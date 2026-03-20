<?php
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/src/Models/User.php';

$user = null;
if (isset($_SESSION['user_id'])) {
    $userModel = new User();
    $user = $userModel->getUserById($_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'LinguaPro - Онлайн-школа иностранных языков'; ?></title>
    <meta name="description" content="<?php echo $pageDescription ?? 'Изучайте иностранные языки онлайн с носителями.'; ?>">
    
    <meta property="og:title" content="<?php echo $pageTitle ?? 'LinguaPro'; ?>">
    <meta property="og:description" content="<?php echo $pageDescription ?? 'Изучайте языки с экспертами'; ?>">
    <meta property="og:image" content="<?php echo asset('images/og-image.jpg'); ?>">
    
    <link rel="icon" href="<?php echo asset('images/favicon.ico'); ?>" type="image/x-icon">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo asset('css/main.css'); ?>">
    
<style>
    .user-menu { position: relative; }
    .user-avatar {
        width: 45px; height: 45px; border-radius: 50%;
        background: linear-gradient(135deg, #1A5CFF 0%, #7A4AFF 100%);
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 600; overflow: hidden; cursor: pointer;
    }
    .user-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .user-avatar svg { width: 60%; height: 60%; fill: white; }
    .user-dropdown {
        position: absolute; top: 55px; right: 0; width: 280px;
        background: white; border-radius: 8px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2); border: 0;
        display: none; z-index: 1000; overflow: hidden;
    }
    .user-dropdown.show { display: block; }
    .user-dropdown .user-info {
        padding: 20px; background: linear-gradient(135deg, #1A5CFF 0%, #7A4AFF 100%); color: white;
    }
    .user-dropdown a { display: block; padding: 12px 20px; text-decoration: none; color: #1A1E2B; }
    .user-dropdown a:hover { background: #F3F4F6; color: #1A5CFF; }
    .user-dropdown hr { border: none; border-top: 1px solid #E5E7EB; margin: 8px 0; }

    .nav { display: flex; gap: 32px; }
    .nav a { 
        text-decoration: none; color: #1A1E2B; font-weight: 500; position: relative; 
    }
    .nav a.active { color: #1A5CFF; }
    .nav a.active::after {
        content: ''; position: absolute; bottom: -4px; left: 0; right: 0;
        height: 2px; background: #1A5CFF; border-radius: 2px;
    }
    .header__actions { display: flex; gap: 12px; align-items: center; }

    .mobile-menu-btn {
        display: none; font-size: 1.5rem; background: none; border: none;
        cursor: pointer; color: #1A1E2B;
    }
    .mobile-overlay {
        position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.5); z-index: 99; display: none;
    }
    .mobile-overlay.active { display: block; }

    @media (min-width: 769px) {
        .user-menu:hover .user-dropdown { display: block; }
    }

    /* ===== МОБИЛЬНОЕ — СВЕРХУ ВНИЗ ===== */
    @media (max-width: 768px) {
        .mobile-menu-btn { 
            display: block !important; z-index: 101; position: relative; 
        }
        
        #mainNav {
            position: fixed !important;
            left: 0 !important;
            width: 100vw !important;
            background: white !important;
            flex-direction: column !important;
            padding-top: 50px;
            z-index: 100 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
            gap: 10px;
        }
        
        #mainNav.active {
            top: 0 !important;  
        }
        
        #mainNav a {
            padding: 18px 24px !important;
            border-bottom: 1px solid #E5E7EB !important;
            width: 100% !important;
            font-size: 1.1rem !important;
        }
        
        .header__actions .btn-secondary { display: none !important; }
        
        .user-menu:hover .user-dropdown { display: none; }
        
        .user-dropdown {
            position: fixed !important;
            top: 70px;
            bottom: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 45vh !important;
            transform: translateY(0) !important;
            transition: transform 0.3s ease !important;
            z-index: 102 !important;
        }
        .user-dropdown.show-mobile { 
            transform: translateY(0) !important; 
            display: block !important;
        }
    }
</style>

</head>
<body>
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <header class="header">
        <div class="container header__inner">
            <a href="<?php echo url(''); ?>" class="logo">LinguaPro</a>
            
            <nav class="nav" id="mainNav">
                <a href="<?php echo url(''); ?>" class="<?php echo $page == 'home' ? 'active' : ''; ?>">Главная</a>
                <a href="<?php echo url('?page=courses'); ?>" class="<?php echo $page == 'courses' ? 'active' : ''; ?>">Курсы</a>
                <a href="<?php echo url('?page=teachers'); ?>" class="<?php echo $page == 'teachers' ? 'active' : ''; ?>">Преподаватели</a>
                <a href="<?php echo url('?page=blog'); ?>" class="<?php echo $page == 'blog' ? 'active' : ''; ?>">Блог</a>
                <a href="<?php echo url('?page=faq'); ?>" class="<?php echo $page == 'faq' ? 'active' : ''; ?>">FAQ</a>
                <a href="<?php echo url('?page=contacts'); ?>" class="<?php echo $page == 'contacts' ? 'active' : ''; ?>">Контакты</a>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo url('?page=login'); ?>" class="mobile-login-btn">Войти</a>
                <?php endif; ?>
            </nav>
            
            <div class="header__actions">
                <?php if (isset($_SESSION['user_id']) && $user): ?>
                <div class="user-menu">
                    <div class="user-avatar" id="userAvatar">
                        <?php if (!empty($user['avatar'])): ?>
                            <img src="<?php echo BASE_URL . $user['avatar']; ?>" alt="Avatar">
                        <?php else: ?>
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="8" r="4" fill="white"/>
                                <path d="M12 14C8.7 14 6 16.7 6 20H18C18 16.7 15.3 14 12 14Z" fill="white"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="user-dropdown" id="userDropdown">
                        <div class="user-info">
                            <strong><?php echo htmlspecialchars($user['last_name'] . ' ' . $user['first_name']); ?></strong>
                            <small><?php echo htmlspecialchars($user['email']); ?></small>
                        </div>
                        <a href="<?php echo url('?page=profile'); ?>">Личный кабинет</a>
                        <a href="<?php echo url('?page=my-courses'); ?>">Мои курсы</a>
                        <a href="<?php echo url('?page=payments'); ?>">История платежей</a>
                        <hr>
                        <a href="#" id="logoutBtn">Выйти</a>
                    </div>
                </div>
                <?php else: ?>
                <a href="<?php echo url('?page=login'); ?>" class="btn btn-secondary">Войти</a>
                <?php endif; ?>
            </div>
            
            <button class="mobile-menu-btn" id="mobileMenuBtn">☰</button>
        </div>
    </header>
    <main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('mobileMenuBtn');
    const menu = document.getElementById('mainNav');
    const overlay = document.getElementById('mobileOverlay');
    const avatar = document.getElementById('userAvatar');
    const userDropdown = document.getElementById('userDropdown');
    const logoutBtn = document.getElementById('logoutBtn');
    
    // Бургер меню
    if (burger && menu) {
        burger.onclick = function(e) {
            e.stopPropagation();
            menu.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
            
            // Закрываем меню пользователя если открыто
            if (userDropdown && userDropdown.classList.contains('show-mobile')) {
                userDropdown.classList.remove('show-mobile');
            }
        };
    }
    
    // Аватар меню
    if (avatar && userDropdown) {
        avatar.onclick = function(e) {
            e.stopPropagation();
            
            if (window.innerWidth <= 768) {
                // Мобильная версия
                userDropdown.classList.toggle('show-mobile');
                
                // Закрываем бургер меню если открыто
                if (menu && menu.classList.contains('active')) {
                    menu.classList.remove('active');
                }
                
                // Управляем оверлеем
                if (userDropdown.classList.contains('show-mobile')) {
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                } else {
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            } else {
                // Десктоп версия
                userDropdown.classList.toggle('show');
            }
        };
    }
    
    // Оверлей
    if (overlay) {
        overlay.onclick = function() {
            if (menu) menu.classList.remove('active');
            if (userDropdown) {
                userDropdown.classList.remove('show', 'show-mobile');
            }
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        };
    }
    
    // Закрытие по ESC
    document.onkeydown = function(e) {
        if (e.key === 'Escape') {
            if (menu) menu.classList.remove('active');
            if (userDropdown) {
                userDropdown.classList.remove('show', 'show-mobile');
            }
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    };
    
    // Закрытие при клике вне
    document.onclick = function(e) {
        // Для бургер меню
        if (menu && menu.classList.contains('active') && !menu.contains(e.target) && e.target !== burger) {
            menu.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Для меню пользователя
        if (window.innerWidth <= 768) {
            if (userDropdown && userDropdown.classList.contains('show-mobile') && !userDropdown.contains(e.target) && e.target !== avatar) {
                userDropdown.classList.remove('show-mobile');
                if (!menu.classList.contains('active')) {
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }
        } else {
            if (userDropdown && userDropdown.classList.contains('show') && !userDropdown.contains(e.target) && e.target !== avatar) {
                userDropdown.classList.remove('show');
            }
        }
    };
    
    // Выход
    if (logoutBtn) {
        logoutBtn.onclick = function(e) {
            e.preventDefault();
            window.location.href = '/LinguaPro/public/?page=logout';
        };
    }
    
    // При клике на ссылки в меню - закрываем
    if (menu) {
        const links = menu.querySelectorAll('a');
        links.forEach(link => {
            link.onclick = function() {
                menu.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            };
        });
    }
    
    // Ресайз
    window.onresize = function() {
        if (window.innerWidth > 768) {
            menu.classList.remove('active');
            userDropdown.classList.remove('show-mobile');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        } else {
            userDropdown.classList.remove('show');
        }
    };
});
</script>
</body>