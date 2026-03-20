<?php
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once dirname(__DIR__, 3) . '/config/database.php';
require_once dirname(__DIR__, 3) . '/src/Models/User.php';

try {
    // Получаем данные из запроса
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);
    
    if (!$data) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Неверный формат данных']);
        exit;
    }
    
    // Валидация
    $errors = [];
    
    if (empty($data['last_name'])) {
        $errors[] = 'Фамилия обязательна';
    }
    
    if (empty($data['first_name'])) {
        $errors[] = 'Имя обязательно';
    }
    
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
    
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }
    
    // Создаем пользователя
    $userModel = new User();
    
    // Проверка существования email
    $existingUser = $userModel->getUserByEmail($data['email']);
    if ($existingUser) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Пользователь с таким email уже существует']);
        exit;
    }
    
    // Регистрация
    $userData = [
        'email' => $data['email'],
        'password' => $data['password'],
        'last_name' => $data['last_name'],
        'first_name' => $data['first_name'],
        'middle_name' => $data['middle_name'] ?? ''
    ];
    
    $result = $userModel->register($userData);
    
    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'message' => 'Регистрация успешна',
            'user_id' => $result['user_id']
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Ошибка при регистрации']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Ошибка сервера']);
}