<?php
require_once __DIR__ . '/BaseController.php';
require_once dirname(__DIR__) . '/Models/User.php';
require_once dirname(__DIR__) . '/Models/Lesson.php';

class ProfileController extends BaseController {
    
    private $userModel;
    private $lessonModel;

    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $this->userModel = new User();
        $this->lessonModel = new Lesson();
    }

    public function index() {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $courses = $this->userModel->getUserCourses($_SESSION['user_id']);
        $payments = $this->userModel->getUserPayments($_SESSION['user_id']);
        
        $this->view('profile/index', [
            'page' => 'profile',
            'pageTitle' => 'Личный кабинет - LinguaPro',
            'user' => $user,
            'courses' => $courses,
            'payments' => $payments
        ]);
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'last_name' => $_POST['last_name'] ?? '',
                'first_name' => $_POST['first_name'] ?? '',
                'middle_name' => $_POST['middle_name'] ?? '',
                'email' => $_POST['email'] ?? ''
            ];
            
            $result = $this->userModel->updateProfile($_SESSION['user_id'], $data);
            
            if ($result['success']) {
                $_SESSION['success'] = 'Профиль обновлен';
                $_SESSION['user_name'] = $data['last_name'] . ' ' . $data['first_name'];
            } else {
                $_SESSION['error'] = $result['message'];
            }
            
            header('Location: /LinguaPro/public/?page=profile');
            exit;
        }
        
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $this->view('profile/edit', ['user' => $user]);
    }

    public function myCourses() {
        $courses = $this->userModel->getUserCourses($_SESSION['user_id']);
        
        $this->view('profile/my-courses', [
            'page' => 'my-courses',
            'pageTitle' => 'Мои курсы - LinguaPro',
            'courses' => $courses
        ]);
    }

    public function payments() {
        $payments = $this->userModel->getUserPayments($_SESSION['user_id']);
        
        $this->view('profile/payments', [
            'page' => 'payments',
            'pageTitle' => 'История платежей - LinguaPro',
            'payments' => $payments
        ]);
    }

    public function lesson($lessonId) {
        $lesson = $this->lessonModel->getLessonById($lessonId);
        
        if (!$lesson) {
            $_SESSION['error'] = 'Урок не найден';
            $this->redirect('/LinguaPro/public/?page=my-courses');
        }

        // Проверяем доступ
        $userCourses = $this->userModel->getUserCourses($_SESSION['user_id']);
        $hasAccess = false;
        foreach ($userCourses as $course) {
            if ($course['course_id'] == $lesson['course_id']) {
                $hasAccess = true;
                break;
            }
        }
        
        if (!$hasAccess) {
            $_SESSION['error'] = 'У вас нет доступа к этому уроку';
            $this->redirect('/LinguaPro/public/?page=my-courses');
        }

        $courseLessons = $this->lessonModel->getCourseLessons($lesson['course_id']);
        $nextLesson = $this->lessonModel->getNextLesson($lesson['course_id'], $lessonId);
        $prevLesson = $this->lessonModel->getPreviousLesson($lesson['course_id'], $lessonId);
        
        $this->view('profile/lesson', [
            'page' => 'lesson',
            'pageTitle' => $lesson['title'] . ' - LinguaPro',
            'lesson' => $lesson,
            'courseLessons' => $courseLessons,
            'nextLesson' => $nextLesson,
            'prevLesson' => $prevLesson
        ]);
    }

    public function uploadAvatar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
            $file = $_FILES['avatar'];
            
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                $_SESSION['error'] = 'Разрешены только JPG, PNG и GIF изображения';
                header('Location: /LinguaPro/public/?page=profile');
                exit;
            }
            
            if ($file['size'] > 2 * 1024 * 1024) {
                $_SESSION['error'] = 'Размер файла не должен превышать 2MB';
                header('Location: /LinguaPro/public/?page=profile');
                exit;
            }
            
            $avatarPath = $this->userModel->uploadAvatar($_SESSION['user_id'], $file);
            
            if ($avatarPath) {
                $_SESSION['success'] = 'Аватар успешно обновлен';
            } else {
                $_SESSION['error'] = 'Ошибка при загрузке аватара';
            }
        }
        
        header('Location: /LinguaPro/public/?page=profile');
        exit;
    }
}