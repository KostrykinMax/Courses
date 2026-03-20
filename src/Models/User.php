<?php
require_once __DIR__ . '/../../config/database.php';

class User {
    private $db;
    private $table = 'users';
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Регистрация нового пользователя
     */
    public function register($data) {
        $email = $this->db->escape($data['email']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $last_name = $this->db->escape($data['last_name']);
        $first_name = $this->db->escape($data['first_name']);
        $middle_name = $this->db->escape($data['middle_name'] ?? '');
        $avatar = '/assets/images/avatars/default-avatar.svg';

        // Проверка существования email
        $checkSql = "SELECT user_id FROM {$this->table} WHERE email = '$email'";
        $checkResult = $this->db->query($checkSql);
        if ($this->db->fetchOne($checkResult)) {
            return ['success' => false, 'message' => 'Пользователь с таким email уже существует'];
        }

        $sql = "INSERT INTO {$this->table} (email, password, last_name, first_name, middle_name, avatar) 
                VALUES ('$email', '$password', '$last_name', '$first_name', '$middle_name', '$avatar')";
        
        if ($this->db->query($sql)) {
            $userId = $this->db->lastInsertId();
            return ['success' => true, 'user_id' => $userId];
        }
        
        return ['success' => false, 'message' => 'Ошибка регистрации'];
    }

    /**
     * Авторизация пользователя
     */
    public function login($email, $password) {
        $email = $this->db->escape($email);
        $sql = "SELECT * FROM {$this->table} WHERE email = '$email'";
        $result = $this->db->query($sql);
        $user = $this->db->fetchOne($result);
        
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return ['success' => true, 'user' => $user];
        }
        
        return ['success' => false, 'message' => 'Неверный email или пароль'];
    }

    public function getUserById($id) {
        $conn = $this->db->getConnection();
        $id = (int)$id;
        $sql = "SELECT * FROM {$this->table} WHERE user_id = $id";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getUserByEmail($email) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $sql = "SELECT * FROM {$this->table} WHERE email = '$email'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    /**
     * Обновить профиль пользователя
     */
    public function updateProfile($id, $data) {
        $conn = $this->db->getConnection();
        $id = (int)$id;
        
        $last_name = mysqli_real_escape_string($conn, $data['last_name'] ?? '');
        $first_name = mysqli_real_escape_string($conn, $data['first_name'] ?? '');
        $middle_name = mysqli_real_escape_string($conn, $data['middle_name'] ?? '');
        $email = mysqli_real_escape_string($conn, $data['email'] ?? '');

        $sql = "UPDATE {$this->table} 
                SET last_name = '$last_name', 
                    first_name = '$first_name', 
                    middle_name = '$middle_name',
                    email = '$email'
                WHERE user_id = $id";
        
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            return ['success' => true, 'message' => 'Профиль обновлен'];
        } else {
            return ['success' => false, 'message' => 'Ошибка: ' . mysqli_error($conn)];
        }
    }
    
    public function updatePassword($id, $newPassword) {
        $conn = $this->db->getConnection();
        $id = (int)$id;
        $password = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $sql = "UPDATE users SET password = '$password' WHERE user_id = $id";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            return ['success' => true, 'message' => 'Пароль изменен'];
        } else {
            return ['success' => false, 'message' => 'Ошибка: ' . mysqli_error($conn)];
        }
    }

    /**
     * Загрузить аватар
     */
    public function uploadAvatar($userId, $file) {
        $uploadDir = dirname(__DIR__, 2) . '/public/assets/images/avatars/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar-' . $userId . '-' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $avatarPath = '/assets/images/avatars/' . $filename;
            
            $id = $this->db->escape($userId);
            $avatarPathEscaped = $this->db->escape($avatarPath);
            $sql = "UPDATE {$this->table} SET avatar = '$avatarPathEscaped' WHERE user_id = '$id'";
            $this->db->query($sql);
            
            return $avatarPath;
        }
        
        return false;
    }

    /**
     * Получить курсы пользователя
     */
    public function getUserCourses($userId) {
        $userId = $this->db->escape($userId);
        $sql = "SELECT c.*, p.purchase_id, p.payment_status, p.purchase_date 
                FROM purchases p 
                JOIN courses c ON p.course_id = c.course_id 
                WHERE p.user_id = '$userId' 
                ORDER BY p.purchase_date DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    /**
     * Получить историю платежей
     */
    public function getUserPayments($userId) {
        $userId = $this->db->escape($userId);
        $sql = "SELECT p.*, c.title as course_title, c.price 
                FROM purchases p
                JOIN courses c ON p.course_id = c.course_id
                WHERE p.user_id = '$userId'
                ORDER BY p.purchase_date DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    /**
     * Проверить, купил ли пользователь курс
     */
    public function hasPurchasedCourse($userId, $courseId) {
        $userId = $this->db->escape($userId);
        $courseId = $this->db->escape($courseId);
        
        $sql = "SELECT * FROM purchases 
                WHERE user_id = '$userId' AND course_id = '$courseId'";
        $result = $this->db->query($sql);
        return $this->db->fetchOne($result);
    }

    /**
     * Получить полное имя пользователя
     */
    public function getFullName($userId) {
        $user = $this->getUserById($userId);
        if ($user) {
            return trim($user['last_name'] . ' ' . $user['first_name'] . ' ' . $user['middle_name']);
        }
        return '';
    }
}