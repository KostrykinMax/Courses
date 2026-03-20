<?php
// src/Controllers/AuthController.php
require_once __DIR__ . '/BaseController.php';
require_once dirname(__DIR__) . '/Models/User.php';

class AuthController extends BaseController {
    
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Страница регистрации
     */
    public function registerForm() {
        $this->view('auth/register', [
            'page' => 'register',
            'pageTitle' => 'Регистрация - LinguaPro'
        ]);
    }

    /**
     * Обработка регистрации
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/LinguaPro/public/?page=register');
        }

        // Валидация
        $errors = [];
        
        if (empty($_POST['fullname'])) {
            $errors[] = 'ФИО обязательно для заполнения';
        }
        
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Введите корректный email';
        }
        
        if (empty($_POST['password']) || strlen($_POST['password']) < 8) {
            $errors[] = 'Пароль должен содержать минимум 6 символов';
        }
        
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $errors[] = 'Пароли не совпадают';
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['form_data'] = $_POST;
            $this->redirect('/LinguaPro/public/?page=register');
        }

        // Регистрация
        $result = $this->userModel->register($_POST);

        if ($result['success']) {
            $_SESSION['success'] = 'Регистрация прошла успешно! Теперь вы можете войти.';
            $this->redirect('/LinguaPro/public/?page=login');
        } else {
            $_SESSION['error'] = $result['message'];
            $_SESSION['form_data'] = $_POST;
            $this->redirect('/LinguaPro/public/?page=register');
        }
    }

    /**
     * Страница входа
     */
    public function loginForm() {
        $this->view('auth/login', [
            'page' => 'login',
            'pageTitle' => 'Вход - LinguaPro'
        ]);
    }

    /**
     * Обработка входа
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/LinguaPro/public/?page=login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Заполните все поля';
            $this->redirect('/LinguaPro/public/?page=login');
        }

        $result = $this->userModel->login($email, $password);

        if ($result['success']) {
            $_SESSION['user_id'] = $result['user']['user_id'];
            $_SESSION['user_name'] = $result['user']['fullname'];
            $_SESSION['user_email'] = $result['user']['email'];
            
            $this->redirect('/LinguaPro/public/');
        } else {
            $_SESSION['error'] = $result['message'];
            $this->redirect('/LinguaPro/public/?page=login');
        }
    }

    /**
     * Выход из системы
     */
    public function logout() {
        session_destroy();
        $this->redirect('/LinguaPro/public/');
    }
}