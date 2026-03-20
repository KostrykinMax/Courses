<?php
require_once __DIR__ . '/BaseController.php';

class PasswordController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
    }

    public function index() {
        $this->view('profile/password', [
            'page' => 'password',
            'pageTitle' => 'Смена пароля - LinguaPro'
        ]);
    }

    public function change() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /LinguaPro/public/?page=password');
            exit;
        }
        
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        
        // Проверка на пустые поля
        if (empty($current) || empty($new) || empty($confirm)) {
            $_SESSION['error'] = 'Все поля обязательны для заполнения';
            header('Location: /LinguaPro/public/?page=password');
            exit;
        }
        
        // Проверка совпадения новых паролей
        if ($new !== $confirm) {
            $_SESSION['error'] = 'Новые пароли не совпадают';
            header('Location: /LinguaPro/public/?page=password');
            exit;
        }
        
        // Проверка длины нового пароля
        if (strlen($new) < 6) {
            $_SESSION['error'] = 'Пароль должен быть не менее 6 символов';
            header('Location: /LinguaPro/public/?page=password');
            exit;
        }
        
        // Подключаемся к БД
        $conn = mysqli_connect('localhost', 'root', '', 'coursesdb');
        
        if (!$conn) {
            $_SESSION['error'] = 'Ошибка подключения к БД';
            header('Location: /LinguaPro/public/?page=password');
            exit;
        }
        
        mysqli_set_charset($conn, 'utf8mb4');
        
        $userId = (int)$_SESSION['user_id'];
        
        // Получаем текущий пароль из БД
        $result = mysqli_query($conn, "SELECT password FROM users WHERE user_id = $userId");
        
        if (!$result) {
            $_SESSION['error'] = 'Ошибка запроса: ' . mysqli_error($conn);
            mysqli_close($conn);
            header('Location: /LinguaPro/public/?page=password');
            exit;
        }
        
        $user = mysqli_fetch_assoc($result);
        
        if (!$user) {
            $_SESSION['error'] = 'Пользователь не найден';
            mysqli_close($conn);
            header('Location: /LinguaPro/public/?page=password');
            exit;
        }
        
        // Проверяем текущий пароль
        if (!password_verify($current, $user['password'])) {
            $_SESSION['error'] = 'Неверный текущий пароль';
            mysqli_close($conn);
            header('Location: /LinguaPro/public/?page=password');
            exit;
        }
        
        // Хешируем новый пароль
        $newHash = password_hash($new, PASSWORD_DEFAULT);
        
        // Обновляем пароль в БД
        $updateSql = "UPDATE users SET password = '$newHash' WHERE user_id = $userId";
        $updateResult = mysqli_query($conn, $updateSql);
        
        if ($updateResult) {
            $_SESSION['success'] = 'Пароль успешно изменен';
        } else {
            $_SESSION['error'] = 'Ошибка при обновлении пароля: ' . mysqli_error($conn);
        }
        
        mysqli_close($conn);
        header('Location: /LinguaPro/public/?page=profile');
        exit;
    }
}