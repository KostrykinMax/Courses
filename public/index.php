<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

define('BASE_URL', '/LinguaPro/public');
define('ROOT_PATH', dirname(__DIR__));

// Автозагрузка классов
spl_autoload_register(function ($className) {
    $paths = [
        ROOT_PATH . '/src/Controllers/',
        ROOT_PATH . '/src/Models/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Подключаем конфиг для шаблонов
require_once ROOT_PATH . '/config/config.php';

$page = $_GET['page'] ?? 'home';
$id = $_GET['id'] ?? null;

try {
    ob_start();
    
    switch ($page) {
        // Главная
        case 'home':
            $controller = new HomeController();
            $controller->index();
            break;

        // Курсы
        case 'courses':
            $controller = new CourseController();
            $controller->catalog();
            break;

        case 'course':
            $controller = new CourseController();
            if ($id) {
                $controller->show($id);
            } else {
                $controller->catalog();
            }
            break;

        case 'course-filter':
            $controller = new CourseController();
            $controller->filter();
            break;

        case 'course-purchase':
            $controller = new CourseController();
            $controller->purchase();
            break;

        // Авторизация
        case 'register':
            $controller = new AuthController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->register();
            } else {
                $controller->registerForm();
            }
            break;

        case 'login':
            $controller = new AuthController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->login();
            } else {
                $controller->loginForm();
            }
            break;

        case 'logout':
            $controller = new AuthController();
            $controller->logout();
            break;

        // Личный кабинет
        case 'profile':
            $controller = new ProfileController();
            $controller->index();
            break;

        case 'upload-avatar':
            $controller = new ProfileController();
            $controller->uploadAvatar();
            break;

        case 'edit-profile':
            $controller = new ProfileController();
            $controller->edit();
            break;

        case 'password':
            $controller = new PasswordController();
            $controller->index();
            break;

        case 'password-change':
            $controller = new PasswordController();
            $controller->change();
            break;

        case 'my-courses':
            $controller = new ProfileController();
            $controller->myCourses();
            break;

        case 'payments':
            $controller = new ProfileController();
            $controller->payments();
            break;

        // Статические страницы
        case 'teachers':
            $pageTitle = 'Наши преподаватели - LinguaPro';
            $pageDescription = 'Профессиональные преподаватели иностранных языков';
            require_once ROOT_PATH . '/templates/teachers/index.php';
            break;

        case 'faq':
            $pageTitle = 'Часто задаваемые вопросы - LinguaPro';
            $pageDescription = 'Ответы на популярные вопросы';
            require_once ROOT_PATH . '/templates/pages/faq.php';
            break;

        case 'gallery':
            $pageTitle = 'Фотогалерея - LinguaPro';
            $pageDescription = 'Фотографии с наших уроков и мероприятий';
            require_once ROOT_PATH . '/templates/pages/gallery.php';
            break;

        case 'contacts':
            $pageTitle = 'Контакты - LinguaPro';
            $pageDescription = 'Свяжитесь с нами';
            require_once ROOT_PATH . '/templates/pages/contacts.php';
            break;
        
        // Блог (динамический)
        case 'blog':
            $controller = new BlogController();
            $controller->index();
            break;

        case 'blog-post':
            $controller = new BlogController();
            if ($id) {
                $controller->show($id);
            } else {
                $controller->index();
            }
            break;

        case 'logout':
            session_destroy();
            header('Location: ' . BASE_URL . '/');
            exit;
            break;

        default:
            $controller = new HomeController();
            $controller->index();
    }
    
    $content = ob_get_clean();
    
    require_once ROOT_PATH . '/templates/layouts/header.php';
    echo $content;
    require_once ROOT_PATH . '/templates/layouts/footer.php';
    
} catch (Exception $e) {
    ob_end_clean();
    die("Ошибка: " . $e->getMessage());
}