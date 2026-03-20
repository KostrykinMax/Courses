<?php
require_once __DIR__ . '/../../config/database.php';

class Course {
    private $db;
    private $table = 'courses';

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Получить все курсы
     */
    public function getAllCourses() {
        $sql = "SELECT * FROM {$this->table} ORDER BY course_id DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    /**
     * Получить популярные курсы (последние 6)
     */
    public function getPopularCourses($limit = 6) {
        $sql = "SELECT * FROM {$this->table} ORDER BY course_id DESC LIMIT $limit";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    /**
     * Получить курс по ID
     */
    public function getCourseById($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM {$this->table} WHERE course_id = '$id'";
        $result = $this->db->query($sql);
        return $this->db->fetchOne($result);
    }

    /**
     * Получить уроки курса
     */
    public function getCourseLessons($courseId) {
        $courseId = $this->db->escape($courseId);
        $sql = "SELECT * FROM lessons WHERE course_id = '$courseId' ORDER BY lesson_id";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    /**
     * Поиск курсов
     */
    public function searchCourses($query) {
        $query = $this->db->escape($query);
        $sql = "SELECT * FROM {$this->table} 
                WHERE title LIKE '%$query%' OR description LIKE '%$query%'
                ORDER BY course_id DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    /**
     * Получить общее количество курсов
     */
    public function getTotalCourses() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        $data = $this->db->fetchOne($result);
        return $data['total'];
    }

    /**
     * Получить курсы с пагинацией
     */
    public function getCoursesWithPagination($limit, $offset) {
        $sql = "SELECT * FROM {$this->table} 
                ORDER BY course_id DESC 
                LIMIT $offset, $limit";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    /**
     * Форматировать цену
     */
    public function formatPrice($price) {
        return number_format($price, 0, '.', ' ') . ' ₽';
    }

    /**
     * Получить длительность курса в месяцах
     */
    public function getDurationInMonths($start_date, $end_date) {
        if ($start_date && $end_date) {
            $start = new DateTime($start_date);
            $end = new DateTime($end_date);
            $interval = $start->diff($end);
            return $interval->m + ($interval->y * 12);
        }
        return null;
    }
}