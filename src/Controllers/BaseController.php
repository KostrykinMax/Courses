<?php
// src/Controllers/BaseController.php
class BaseController {
    protected $db;

    public function __construct() {
        // Запускаем сессию, если еще не запущена
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function initDb() {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db = 'coursesdb';
        
        $this->db = mysqli_connect($host, $user, $pass, $db);
        mysqli_set_charset($this->db, 'utf8mb4');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }

    /**
     * Загрузка шаблона
     */
    protected function view($view, $data = []) {
        extract($data);
        
        $viewPath = dirname(__DIR__, 2) . '/templates/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View not found: " . $viewPath);
        }
    }

    /**
     * Редирект
     */
    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    /**
     * JSON ответ
     */
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Проверка авторизации
     */
    protected function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/LinguaPro/public/?page=login');
        }
    }

    /**
     * Получить текущего пользователя
     */
    protected function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            require_once dirname(__DIR__) . '/Models/User.php';
            $userModel = new User();
            return $userModel->getUserById($_SESSION['user_id']);
        }
        return null;
    }
}