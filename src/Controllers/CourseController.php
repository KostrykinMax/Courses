<?php
require_once __DIR__ . '/BaseController.php';
require_once dirname(__DIR__) . '/Models/Course.php';
require_once dirname(__DIR__) . '/Models/Lesson.php';
require_once dirname(__DIR__) . '/Models/Purchase.php';

class CourseController extends BaseController {
    
    private $courseModel;
    private $lessonModel;
    private $purchaseModel;

    public function __construct() {
        parent::__construct();
        $this->courseModel = new Course();
        $this->lessonModel = new Lesson();
        $this->purchaseModel = new Purchase();
    }

    /**
     * Страница со всеми курсами
     */
    public function catalog() {
        $this->view('courses/catalog', [
            'page' => 'courses',
            'pageTitle' => 'Все курсы - LinguaPro'
        ]);
    }

    /**
     * AJAX метод для фильтрации и поиска
     */
    public function filter() {
        // Получаем параметры из POST запроса
        $search = $_POST['search'] ?? '';
        $sort = $_POST['sort'] ?? 'newest';
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = 9;
        $offset = ($page - 1) * $limit;
        
        // Получаем все курсы
        $allCourses = $this->courseModel->getAllCourses();
        
        // ФИЛЬТРАЦИЯ по поиску (регистронезависимая)
        if (!empty($search)) {
            $filteredCourses = [];
            $searchLower = mb_strtolower($search, 'UTF-8');
            
            foreach ($allCourses as $course) {
                $titleLower = mb_strtolower($course['title'], 'UTF-8');
                $descLower = isset($course['description']) ? mb_strtolower($course['description'], 'UTF-8') : '';
                
                if (mb_strpos($titleLower, $searchLower) !== false || 
                    mb_strpos($descLower, $searchLower) !== false) {
                    $filteredCourses[] = $course;
                }
            }
            $allCourses = $filteredCourses;
        }
        
        // СОРТИРОВКА
        if ($sort === 'price_asc') {
            // По возрастанию цены
            usort($allCourses, function($a, $b) {
                return $a['price'] - $b['price'];
            });
        } elseif ($sort === 'price_desc') {
            // По убыванию цены
            usort($allCourses, function($a, $b) {
                return $b['price'] - $a['price'];
            });
        } else {
            // По новизне (по умолчанию)
            usort($allCourses, function($a, $b) {
                return $b['course_id'] - $a['course_id'];
            });
        }
        
        // Общее количество после фильтрации
        $totalCourses = count($allCourses);
        $totalPages = ceil($totalCourses / $limit);
        
        // Пагинация
        $courses = array_slice($allCourses, $offset, $limit);
        
        // Формируем HTML для каждой карточки
        $html = '';
        foreach ($courses as $course) {
            $html .= $this->renderCourseCard($course);
        }
        
        // Возвращаем JSON ответ
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'html' => $html,
            'total' => $totalCourses,
            'page' => $page,
            'totalPages' => $totalPages,
            'hasPrev' => $page > 1,
            'hasNext' => $page < $totalPages
        ]);
        exit;
    }

    /**
     * Рендер карточки курса с правильными путями к изображениям
     */
    private function renderCourseCard($course) {
        // Формируем правильный путь к изображению
        $imagePath = !empty($course['image']) ? $course['image'] : '/assets/images/courses/default.jpg';
        
        // Убираем лишние слеши в начале, если они есть
        $imagePath = ltrim($imagePath, '/');
        
        // Добавляем базовый URL
        $fullImageUrl = BASE_URL . '/' . $imagePath;
        
        $title = htmlspecialchars($course['title']);
        $description = !empty($course['description']) ? htmlspecialchars(mb_substr($course['description'], 0, 100)) . '...' : '';
        $duration = $course['duration_hours'] ?? 0;
        $price = number_format($course['price'], 0, '.', ' ');
        $courseId = $course['course_id'];
        
        return "
        <div class='course-card' data-course-id='{$courseId}'>
            <div class='course-image'>
                <img src='{$fullImageUrl}' 
                     alt='{$title}'
                     onerror='this.onerror=null; this.src=\"" . BASE_URL . "/assets/images/placeholder.svg\"; console.log(\"Failed to load: {$fullImageUrl}\");'>
            </div>
            <div class='course-content'>
                <h3 class='course-title'>{$title}</h3>
                " . ($description ? "<p class='course-description'>{$description}</p>" : "") . "
                <div class='course-meta'>
                    " . ($duration ? "<span>⏱ {$duration} часов</span>" : "") . "
                </div>
                <div class='course-price'>{$price} ₽</div>
                <div class='course-footer'>
                    <a href='" . url('?page=course&id=' . $courseId) . "' class='btn btn-outline'>Подробнее</a>
                </div>
            </div>
        </div>";
    }

    /**
     * Страница конкретного курса
     */
    public function show($id) {
        $course = $this->courseModel->getCourseById($id);
        
        if (!$course) {
            $_SESSION['error'] = 'Курс не найден';
            $this->redirect('/LinguaPro/public/?page=courses');
        }
        
        $lessons = $this->courseModel->getCourseLessons($id);
        
        // Проверяем, купил ли пользователь этот курс
        $isPurchased = false;
        if (isset($_SESSION['user_id'])) {
            $purchase = $this->purchaseModel->checkUserCourse($_SESSION['user_id'], $id);
            $isPurchased = !empty($purchase);
        }
        
        $this->view('courses/show', [
            'page' => 'course',
            'pageTitle' => $course['title'] . ' - LinguaPro',
            'course' => $course,
            'lessons' => $lessons,
            'isPurchased' => $isPurchased
        ]);
    }

    /**
     * Покупка курса
     */
    public function purchase() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseId = $_POST['course_id'] ?? null;
            
            if (!$courseId) {
                $_SESSION['error'] = 'ID курса не указан';
                $this->redirect('/LinguaPro/public/?page=courses');
            }
            
            $result = $this->purchaseModel->createPurchase($_SESSION['user_id'], $courseId);
            
            if ($result['success']) {
                $this->redirect('/LinguaPro/public/?page=payments');
            } else {
                $_SESSION['error'] = $result['message'];
                $this->redirect('/LinguaPro/public/?page=course&id=' . $courseId);
            }
        }
    }
}