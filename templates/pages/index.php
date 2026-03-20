<?php
if (!isset($blogPosts)) {
    $blogPosts = [];
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
.about {
    padding: 80px 0;
}

.about__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.about__text {
    font-size: 1.2rem;
    color: var(--gray-600);
    margin: 20px 0;
    line-height: 1.6;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    margin: 40px 0;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1.2;
}

.stat-label {
    color: var(--gray-600);
    font-size: 0.9rem;
}

.contacts-block {
    background: var(--gray-100);
    padding: 20px;
    border-radius: var(--border-radius);
}

.contacts-block h4 {
    margin-bottom: 15px;
}

.contacts-block p {
    margin-bottom: 8px;
    color: var(--gray-600);
}

.about__image img {
    width: 100%;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
}

.courses-section {
    padding: 80px 0;
    background: var(--gray-100);
}

.section-header {
    text-align: center;
    margin-bottom: 50px;
}

.section-header h2 {
    margin-bottom: 10px;
}

.section-header p {
    color: var(--gray-600);
    font-size: 1.2rem;
}

.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
}

.course-card {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.course-image {
    height: 200px;
    overflow: hidden;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.course-card:hover .course-image img {
    transform: scale(1.05);
}

.course-content {
    padding: 20px;
}

.course-title {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.course-description {
    color: var(--gray-600);
    font-size: 0.9rem;
    margin-bottom: 15px;
    line-height: 1.5;
}

.course-meta {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    color: var(--gray-600);
    font-size: 0.9rem;
}

.course-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 15px;
}

.course-footer {
    display: flex;
    gap: 10px;
}

.course-footer .btn {
    flex: 1;
}

.section-footer {
    text-align: center;
    margin-top: 50px;
}

.blog-preview {
    padding: 80px 0;
}

.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
}

.blog-card {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.blog-image {
    height: 200px;
    overflow: hidden;
}

.blog-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.blog-card:hover .blog-image img {
    transform: scale(1.05);
}

.blog-content {
    padding: 20px;
}

.blog-date {
    color: var(--primary);
    font-size: 0.9rem;
    margin-bottom: 10px;
}

.blog-title {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.blog-excerpt {
    color: var(--gray-600);
    margin-bottom: 15px;
    line-height: 1.6;
}

.partners-section {
    padding: 60px 0;
    background: var(--gray-100);
}

.section-title {
    text-align: center;
    margin-bottom: 40px;
    font-size: 1.5rem;
}

.partner-logo {
    max-width: 120px;
    height: auto;
    opacity: 0.7;
    transition: all 0.3s ease;
    filter: grayscale(100%);
}

.partner-logo:hover {
    opacity: 1;
    filter: grayscale(0%);
    transform: scale(1.05);
}

.no-courses {
    text-align: center;
    padding: 40px;
    color: var(--gray-600);
    font-size: 1.2rem;
    grid-column: 1 / -1;
}

/* Главный слайдер */
.hero-slider {
    position: relative;
    height: 600px;
    overflow: hidden;
}

.hero-slider .swiper-slide {
    position: relative;
}

.hero-slider .swiper-slide img {
    width: 100%;
    height: 600px;
    object-fit: cover;
}

.hero-slider .slider-content {
    position: absolute;
    bottom: 100px;
    left: 100px;
    color: white;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    max-width: 600px;
    z-index: 10;
}

.hero-slider .slider-content h2 {
    font-size: 3rem;
    margin-bottom: 20px;
}

.hero-slider .slider-content p {
    font-size: 1.2rem;
    margin-bottom: 30px;
}

.hero-slider .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: rgba(255,255,255,0.5);
    opacity: 1;
}

.hero-slider .swiper-pagination-bullet-active {
    background: white;
}

.hero-slider .swiper-button-prev,
.hero-slider .swiper-button-next {
    color: white;
    background: rgba(0,0,0,0.3);
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.hero-slider .swiper-button-prev:after,
.hero-slider .swiper-button-next:after {
    font-size: 20px;
}

/* Слайдер партнеров */
.partnersSwiper {
    padding: 20px 40px;
}

.partnersSwiper .swiper-slide {
    display: flex;
    align-items: center;
    justify-content: center;
}

.partner-logo {
    max-width: 120px;
    height: auto;
    opacity: 0.7;
    transition: all 0.3s ease;
    filter: grayscale(100%);
}

.partner-logo:hover {
    opacity: 1;
    filter: grayscale(0%);
    transform: scale(1.05);
}

.partnersSwiper .swiper-button-prev,
.partnersSwiper .swiper-button-next {
    color: var(--primary);
    background: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.partnersSwiper .swiper-button-prev:after,
.partnersSwiper .swiper-button-next:after {
    font-size: 16px;
}

.partnersSwiper .swiper-button-prev:hover,
.partnersSwiper .swiper-button-next:hover {
    background: var(--primary);
    color: white;
}

@media (max-width: 768px) {
    .hero-slider {
        height: 400px;
    }
    
    .hero-slider .swiper-slide img {
        height: 400px;
    }
    
    .hero-slider .slider-content {
        left: 20px;
        right: 20px;
        bottom: 50px;
    }
    
    .hero-slider .slider-content h2 {
        font-size: 2rem;
    }
    
    .hero-slider .slider-content p {
        font-size: 1rem;
    }

    .about__grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .courses-grid,
    .blog-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .partner-logo {
        max-width: 80px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .course-footer {
        flex-direction: column;
    }
}
</style>

<!-- Главный слайдер -->
<section class="hero-slider">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            <?php foreach ($heroSlides as $slide): ?>
            <div class="swiper-slide">
                <img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>">
                <div class="slider-content">
                    <h2><?php echo $slide['title']; ?></h2>
                    <p><?php echo $slide['subtitle']; ?></p>
                    <a href="<?php echo url('?page=courses'); ?>" class="btn btn-primary">Узнать больше</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>

<!-- Блок "О школе" -->
<section class="about">
    <div class="container">
        <div class="about__grid">
            <div class="about__content">
                <h2>О школе LinguaPro</h2>
                <p class="about__text">
                    Мы объединили современные технологии и живого преподавателя, чтобы вы заговорили на иностранном языке быстро и с удовольствием.
                </p>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">лет на рынке</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50k+</div>
                        <div class="stat-label">выпускников</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">300+</div>
                        <div class="stat-label">преподавателей</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $totalCourses; ?>+</div>
                        <div class="stat-label">курсов</div>
                    </div>
                </div>
                
                <div class="contacts-block">
                    <h4>Контакты</h4>
                    <p><strong>Телефон:</strong> 8 (800) 123-45-67</p>
                    <p><strong>Email:</strong> info@linguapro.ru</p>
                    <p><strong>График работы:</strong> Пн-Пт 9:00-21:00, Сб-Вс 10:00-18:00</p>
                </div>
            </div>
            <div class="about__image">
                <img src="<?php echo asset('images/about-school.jpg'); ?>" alt="О школе">
            </div>
        </div>
    </div>
</section>

<!-- Популярные курсы (ИЗ БД) -->
<section class="courses-section">
    <div class="container">
        <div class="section-header">
            <h2>Наши популярные курсы</h2>
            <p>Выберите программу под свои цели</p>
        </div>
        
        <div class="courses-grid">
            <?php if (!empty($popularCourses)): ?>
                <?php foreach ($popularCourses as $course): ?>
                <div class="course-card">
                    <div class="course-image">
                        <img src="<?php echo BASE_URL . $course['image']; ?>" 
                             alt="<?php echo htmlspecialchars($course['title']); ?>">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                        
                        <?php if (!empty($course['description'])): ?>
                        <p class="course-description"><?php echo mb_substr(htmlspecialchars($course['description']), 0, 100) . '...'; ?></p>
                        <?php endif; ?>
                        
                        <div class="course-meta">
                            <?php if ($course['duration_hours']): ?>
                            <span>⏱ <?php echo $course['duration_hours']; ?> часов</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="course-price">
                            <?php echo number_format($course['price'], 0, '.', ' '); ?> ₽
                        </div>
                        
                        <div class="course-footer">
                            <a href="<?php echo url('?page=course&id=' . $course['course_id']); ?>" class="btn btn-outline">Подробнее</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-courses">Курсы временно недоступны</p>
            <?php endif; ?>
        </div>
        
        <div class="section-footer">
            <a href="<?php echo url('?page=courses'); ?>" class="btn btn-secondary">Смотреть все курсы →</a>
        </div>
    </div>
</section>

<!-- Слайдер партнеров -->
<section class="partners-section">
    <div class="container">
        <h3 class="section-title">Наши партнеры</h3>
        
        <div class="swiper partnersSwiper">
            <div class="swiper-wrapper">
                <?php foreach ($partners as $partner): ?>
                <div class="swiper-slide">
                    <img src="<?php echo $partner['logo']; ?>" 
                         alt="<?php echo $partner['name']; ?>" 
                         class="partner-logo">
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Главный слайдер
        const heroSwiper = new Swiper('.heroSwiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        
        // Слайдер партнеров
        const partnersSwiper = new Swiper('.partnersSwiper', {
            slidesPerView: 2,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                480: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 50,
                },
            },
        });
    });
</script>