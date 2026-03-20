<?php
require_once __DIR__ . '/../../config/database.php';

class Lesson {
    private $db;
    private $table = 'lessons';

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Получить все уроки курса
     */
    public function getCourseLessons($courseId) {
        $courseId = $this->db->escape($courseId);
        $sql = "SELECT * FROM {$this->table} WHERE course_id = '$courseId' ORDER BY lesson_id";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    /**
     * Получить урок по ID
     */
    public function getLessonById($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT l.*, c.title as course_title 
                FROM {$this->table} l
                JOIN courses c ON l.course_id = c.course_id
                WHERE l.lesson_id = '$id'";
        $result = $this->db->query($sql);
        return $this->db->fetchOne($result);
    }

    /**
     * Получить общее количество уроков в курсе
     */
    public function getTotalLessonsCount($courseId) {
        $courseId = $this->db->escape($courseId);
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE course_id = '$courseId'";
        $result = $this->db->query($sql);
        $data = $this->db->fetchOne($result);
        return $data['total'];
    }

    /**
     * Получить следующий урок
     */
    public function getNextLesson($courseId, $currentLessonId) {
        $courseId = $this->db->escape($courseId);
        $currentLessonId = $this->db->escape($currentLessonId);
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE course_id = '$courseId' AND lesson_id > '$currentLessonId'
                ORDER BY lesson_id
                LIMIT 1";
        $result = $this->db->query($sql);
        return $this->db->fetchOne($result);
    }

    /**
     * Получить предыдущий урок
     */
    public function getPreviousLesson($courseId, $currentLessonId) {
        $courseId = $this->db->escape($courseId);
        $currentLessonId = $this->db->escape($currentLessonId);
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE course_id = '$courseId' AND lesson_id < '$currentLessonId'
                ORDER BY lesson_id DESC
                LIMIT 1";
        $result = $this->db->query($sql);
        return $this->db->fetchOne($result);
    }
}