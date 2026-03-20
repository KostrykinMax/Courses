<?php
require_once __DIR__ . '/../../config/database.php';

class Purchase {
    private $db;
    private $table = 'purchases';

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Создать покупку
     */
    public function createPurchase($userId, $courseId) {
        $userId = $this->db->escape($userId);
        $courseId = $this->db->escape($courseId);
        $paymentStatus = 'pending';
        $purchaseDate = date('Y-m-d H:i:s');

        // Проверка, не купил ли уже пользователь этот курс
        if ($this->checkUserCourse($userId, $courseId)) {
            return ['success' => false, 'message' => 'Курс уже приобретен'];
        }

        $sql = "INSERT INTO {$this->table} (user_id, course_id, payment_status, purchase_date) 
                VALUES ('$userId', '$courseId', '$paymentStatus', '$purchaseDate')";
        
        if ($this->db->query($sql)) {
            return ['success' => true, 'purchase_id' => $this->db->lastInsertId()];
        }
        
        return ['success' => false, 'message' => 'Ошибка при создании покупки'];
    }

    /**
     * Проверить, купил ли пользователь курс
     */
    public function checkUserCourse($userId, $courseId) {
        $userId = $this->db->escape($userId);
        $courseId = $this->db->escape($courseId);
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_id = '$userId' AND course_id = '$courseId'";
        $result = $this->db->query($sql);
        return $this->db->fetchOne($result);
    }

    /**
     * Обновить статус платежа
     */
    public function updatePaymentStatus($purchaseId, $status) {
        $purchaseId = $this->db->escape($purchaseId);
        $status = $this->db->escape($status);
        
        $sql = "UPDATE {$this->table} SET payment_status = '$status' WHERE purchase_id = '$purchaseId'";
        return $this->db->query($sql);
    }

    /**
     * Получить покупки пользователя
     */
    public function getUserPurchases($userId) {
        $userId = $this->db->escape($userId);
        $sql = "SELECT p.*, c.title, c.price, c.image 
                FROM {$this->table} p
                JOIN courses c ON p.course_id = c.course_id
                WHERE p.user_id = '$userId'
                ORDER BY p.purchase_date DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    /**
     * Получить покупку по ID
     */
    public function getPurchaseById($purchaseId) {
        $purchaseId = $this->db->escape($purchaseId);
        $sql = "SELECT p.*, c.title, c.price, u.fullname, u.email 
                FROM {$this->table} p
                JOIN courses c ON p.course_id = c.course_id
                JOIN users u ON p.user_id = u.user_id
                WHERE p.purchase_id = '$purchaseId'";
        $result = $this->db->query($sql);
        return $this->db->fetchOne($result);
    }

    /**
     * Получить статистику продаж
     */
    public function getSalesStats() {
        $sql = "SELECT 
                    COUNT(*) as total_purchases,
                    SUM(CASE WHEN payment_status = 'paid' THEN 1 ELSE 0 END) as paid_purchases,
                    SUM(CASE WHEN payment_status = 'pending' THEN 1 ELSE 0 END) as pending_purchases,
                    COUNT(DISTINCT user_id) as unique_customers
                FROM {$this->table}";
        $result = $this->db->query($sql);
        return $this->db->fetchOne($result);
    }
}