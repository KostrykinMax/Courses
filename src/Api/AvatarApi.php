<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__) . '/Models/User.php';

class AvatarApi {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    /**
     * Загрузить аватар
     * POST /api/avatar/upload
     */
    public function upload() {
        if (!isset($_FILES['avatar'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Файл не загружен']);
            return;
        }
        
        $userId = $_POST['user_id'] ?? 0;
        $file = $_FILES['avatar'];
        
        // Проверка типа файла
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Разрешены только JPG, PNG и GIF']);
            return;
        }
        
        // Проверка размера
        if ($file['size'] > 2 * 1024 * 1024) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Размер файла не должен превышать 2MB']);
            return;
        }
        
        $avatarPath = $this->userModel->uploadAvatar($userId, $file);
        
        if ($avatarPath) {
            echo json_encode([
                'success' => true,
                'message' => 'Аватар загружен',
                'avatar_url' => '/LinguaPro/public' . $avatarPath
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Ошибка при загрузке']);
        }
    }
}

// Роутинг
$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

$api = new AvatarApi();

if ($request_method === 'POST' && strpos($request_uri, '/api/avatar/upload') !== false) {
    $api->upload();
}