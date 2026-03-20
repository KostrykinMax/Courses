<?php
    require_once __DIR__ . '/BaseController.php';
    require_once dirname(__DIR__) . '/Models/Course.php';
    require_once dirname(__DIR__) . '/Models/Blog.php';

    class HomeController extends BaseController {
        
        private $courseModel;
        private $blogModel;

        public function __construct() {
            parent::__construct();
            $this->courseModel = new Course();
            $this->blogModel = new Blog();
        }

        public function index() {
            $popularCourses = $this->courseModel->getPopularCourses(6);
            $totalCourses = $this->courseModel->getTotalCourses();
            
            $latestPosts = $this->blogModel->getLatestPosts(3);

            $heroSlides = [
                [
                    'image' => asset('images/heroes/hero-1.png'),
                    'title' => 'Английский для начинающих',
                    'subtitle' => 'С нуля до уверенного общения'
                ],
                [
                    'image' => asset('images/heroes/hero-2.png'),
                    'title' => 'Немецкий для бизнеса',
                    'subtitle' => 'Деловой немецкий за 6 месяцев'
                ],
                [
                    'image' => asset('images/heroes/hero-3.png'),
                    'title' => 'Испанский для путешествий',
                    'subtitle' => 'Заговорите за 4 недели'
                ],
                [
                    'image' => asset('images/heroes/hero-4.png'),
                    'title' => 'Французский разговорный',
                    'subtitle' => 'Язык любви и романтики'
                ],
                [
                    'image' => asset('images/heroes/hero-5.png'),
                    'title' => 'Итальянский с носителями',
                    'subtitle' => 'Погружение в культуру'
                ]
            ];
            
            $partners = [
                ['name' => 'Яндекс.Касса', 'logo' => asset('images/partners/yandex.png')],
                ['name' => 'Tinkoff', 'logo' => asset('images/partners/tinkoff.png')],
                ['name' => 'JivoSite', 'logo' => asset('images/partners/jivo.png')],
                ['name' => 'Google', 'logo' => asset('images/partners/google.png')],
                ['name' => 'Microsoft', 'logo' => asset('images/partners/microsoft.png')]
            ];
            
            $this->view('pages/index', [
                'page' => 'home',
                'pageTitle' => 'LinguaPro - Онлайн-школа иностранных языков',
                'pageDescription' => 'Изучайте иностранные языки онлайн с носителями.',
                'popularCourses' => $popularCourses,
                'totalCourses' => $totalCourses,
                'heroSlides' => $heroSlides,
                'partners' => $partners,
                'blogPosts' => $latestPosts
            ]);
        }
    }