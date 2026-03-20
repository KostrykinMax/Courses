<?php
require_once __DIR__ . '/BaseController.php';
require_once dirname(__DIR__) . '/Models/Blog.php';

class BlogController extends BaseController {
    
    private $blogModel;

    public function __construct() {
        parent::__construct();
        $this->blogModel = new Blog();
    }

    /**
     * Главная страница блога
     */
    public function index() {
        $posts = $this->blogModel->getAllPosts();
        $categories = $this->blogModel->getCategories();
        
        $this->view('blog/index', [
            'page' => 'blog',
            'pageTitle' => 'Блог об изучении языков - LinguaPro',
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    /**
     * Страница отдельного поста
     */
    public function show($id) {
        $post = $this->blogModel->getPostById($id);
        
        if (!$post) {
            $_SESSION['error'] = 'Статья не найдена';
            $this->redirect('/LinguaPro/public/?page=blog');
        }
        
        // Увеличиваем счетчик просмотров
        $this->blogModel->incrementViews($id);
        
        $this->view('blog/show', [
            'page' => 'blog',
            'pageTitle' => $post['title'] . ' - LinguaPro',
            'post' => $post
        ]);
    }
}