<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__) . '/Models/User.php';

class UserApi {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    /**
     * Получить данные пользователя
     * GET /api/user/{id}
     */
    public function getUser($id) {
        $user = $this->userModel->getUserById($id);
        
        if ($user) {
            echo json_encode(['success' => true, 'data' => $user]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Пользователь не найден']);
        }
    }
    
    /**
     * Обновить профиль пользователя
     * PUT /api/user/{id}
     */
    public function updateUser($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Неверный формат данных']);
            return;
        }
        
        $result = $this->userModel->updateProfile($id, $data);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Профиль обновлен']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Ошибка при обновлении']);
        }
    }
    
    /**
     * Получить курсы пользователя
     * GET /api/user/{id}/courses
     */
    public function getUserCourses($id) {
        $courses = $this->userModel->getUserCourses($id);
        echo json_encode(['success' => true, 'data' => $courses]);
    }
    
    /**
     * Получить платежи пользователя
     * GET /api/user/{id}/payments
     */
    public function getUserPayments($id) {
        $payments = $this->userModel->getUserPayments($id);
        echo json_encode(['success' => true, 'data' => $payments]);
    }
}

// Роутинг для API
$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

$api = new UserApi();

// Простой роутинг
if (preg_match('/\/api\/user\/(\d+)$/', $request_uri, $matches)) {
    $userId = $matches[1];
    
    if ($request_method === 'GET') {
        $api->getUser($userId);
    } elseif ($request_method === 'PUT') {
        $api->updateUser($userId);
    }
} elseif (preg_match('/\/api\/user\/(\d+)\/courses$/', $request_uri, $matches)) {
    $userId = $matches[1];
    $api->getUserCourses($userId);
} elseif (preg_match('/\/api\/user\/(\d+)\/payments$/', $request_uri, $matches)) {
    $userId = $matches[1];
    $api->getUserPayments($userId);
}