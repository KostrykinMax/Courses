<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__) . '/Models/User.php';

class AuthApi {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    /**
    * Регистрация пользователя
    * POST /api/auth/register
    */
    public function register() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Неверный формат данных']);
            return;
        }
        
        // Валидация
        $errors = [];
        
        if (empty($data['email'])) {
            $errors[] = 'Email обязателен';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Неверный формат email';
        }
        
        if (empty($data['password'])) {
            $errors[] = 'Пароль обязателен';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'Пароль должен быть не менее 6 символов';
        }
        
        if (empty($data['last_name'])) {
            $errors[] = 'Фамилия обязательна';
        }
        
        if (empty($data['first_name'])) {
            $errors[] = 'Имя обязательно';
        }
        
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }
        
        // Проверка существования пользователя
        $existingUser = $this->userModel->getUserByEmail($data['email']);
        if ($existingUser) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Пользователь с таким email уже существует']);
            return;
        }
        
        // Создание пользователя (только поля из БД)
        $userData = [
            'email' => $data['email'],
            'password' => $data['password'],
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? ''
        ];
        
        $result = $this->userModel->register($userData);
        
        if ($result['success']) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Регистрация успешна',
                'user_id' => $result['user_id']
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Ошибка при регистрации']);
        }
    }
    
    /**
     * Авторизация пользователя
     * POST /api/auth/login
     */
    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Неверный формат данных']);
            return;
        }
        
        if (empty($data['email']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Email и пароль обязательны']);
            return;
        }
        
        $result = $this->userModel->login($data['email'], $data['password']);
        
        if ($result['success']) {
            // Сохраняем в сессию
            session_start();
            $_SESSION['user_id'] = $result['user']['user_id'];
            $_SESSION['user_email'] = $result['user']['email'];
            $_SESSION['user_name'] = $result['user']['last_name'] . ' ' . $result['user']['first_name'];
            
            echo json_encode([
                'success' => true,
                'message' => 'Авторизация успешна',
                'user' => $result['user']
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
    }
    
    /**
     * Проверка авторизации
     * GET /api/auth/check
     */
    public function check() {
        session_start();
        
        if (isset($_SESSION['user_id'])) {
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            echo json_encode([
                'success' => true,
                'authenticated' => true,
                'user' => $user
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'authenticated' => false
            ]);
        }
    }
    
    /**
     * Выход из системы
     * POST /api/auth/logout
     */
    public function logout() {
        session_start();
        session_destroy();
        
        echo json_encode([
            'success' => true,
            'message' => 'Выход выполнен успешно'
        ]);
    }
}

// Роутинг для API
$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

$api = new AuthApi();

if ($request_method === 'POST' && strpos($request_uri, '/api/auth/register') !== false) {
    $api->register();
} elseif ($request_method === 'POST' && strpos($request_uri, '/api/auth/login') !== false) {
    $api->login();
} elseif ($request_method === 'POST' && strpos($request_uri, '/api/auth/logout') !== false) {
    $api->logout();
} elseif ($request_method === 'GET' && strpos($request_uri, '/api/auth/check') !== false) {
    $api->check();
}