<?php
require_once __DIR__ . '/../../config/database.php';

class Blog {
    private $db;
    private $table = 'blog_posts';

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Получить все посты блога
     */
    public function getAllPosts() {
        $sql = "SELECT * FROM {$this->table} ORDER BY date DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    /**
     * Получить пост по ID
     */
    public function getPostById($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM {$this->table} WHERE id = '$id'";
        $result = $this->db->query($sql);
        return $this->db->fetchOne($result);
    }

    /**
     * Получить последние посты (для главной)
     */
        public function getLatestPosts($limit = 3) {
            $sql = "SELECT * FROM {$this->table} ORDER BY date DESC LIMIT $limit";
            $result = $this->db->query($sql);
            return $this->db->fetchAll($result);
        }

    /**
     * Получить все категории
     */
    public function getCategories() {
        $sql = "SELECT DISTINCT category FROM {$this->table} ORDER BY category";
        $result = $this->db->query($sql);
        $categories = ['all' => 'Все'];
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[$row['category']] = $row['category'];
        }
        return $categories;
    }

    /**
     * Добавить просмотр
     */
    public function incrementViews($id) {
        $id = $this->db->escape($id);
        $sql = "UPDATE {$this->table} SET views = views + 1 WHERE id = '$id'";
        return $this->db->query($sql);
    }
}