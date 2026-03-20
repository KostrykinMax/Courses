/**
 * LinguaPro - Основной JavaScript файл
 */

// Инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', function() {
    initSliders();
    initFeedbackForm();
    initFaqAccordion();
    initUserMenu();
    initProfileTabs();
    initAvatarUpload();
    initMobileMenu();
});

/**
 * Инициализация слайдеров
 */
function initSliders() {
    // Главный слайдер в хедере
    const heroSlider = document.querySelector('.hero-slider');
    if (heroSlider) {
        createSlider(heroSlider, {
            autoplay: true,
            interval: 5000,
            dots: true,
            arrows: true
        });
    }
    
    // Слайдер партнеров
    const partnersSlider = document.querySelector('.partners-slider');
    if (partnersSlider) {
        createSlider(partnersSlider, {
            slidesToShow: 5,
            autoplay: true,
            interval: 3000,
            dots: false,
            arrows: true,
            responsive: [
                { breakpoint: 768, slidesToShow: 3 },
                { breakpoint: 480, slidesToShow: 2 }
            ]
        });
    }
}

/**
 * Создание слайдера
 */
function createSlider(sliderElement, options) {
    const container = sliderElement.querySelector('.slider-container');
    const slides = sliderElement.querySelectorAll('.slider-slide');
    const prevBtn = sliderElement.querySelector('.slider-prev');
    const nextBtn = sliderElement.querySelector('.slider-next');
    const dotsContainer = sliderElement.querySelector('.slider-dots');
    
    let currentIndex = 0;
    let slidesToShow = options.slidesToShow || 1;
    let autoplayInterval;
    const slideCount = slides.length;
    const maxIndex = slideCount - slidesToShow;
    
    // Создаем точки навигации
    if (options.dots && dotsContainer) {
        for (let i = 0; i <= maxIndex; i++) {
            const dot = document.createElement('span');
            dot.classList.add('slider-dot');
            dot.addEventListener('click', () => goToSlide(i));
            dotsContainer.appendChild(dot);
        }
        updateDots();
    }
    
    // Функция перехода к слайду
    function goToSlide(index) {
        if (index < 0) index = 0;
        if (index > maxIndex) index = maxIndex;
        currentIndex = index;
        
        const translateValue = - (currentIndex * 100 / slidesToShow);
        container.style.transform = `translateX(${translateValue}%)`;
        
        if (options.dots) updateDots();
    }
    
    // Обновление активной точки
    function updateDots() {
        const dots = sliderElement.querySelectorAll('.slider-dot');
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentIndex);
        });
    }
    
    // Следующий слайд
    function nextSlide() {
        if (currentIndex < maxIndex) {
            goToSlide(currentIndex + 1);
        } else {
            goToSlide(0); 
        }
    }
    
    // Предыдущий слайд
    function prevSlide() {
        if (currentIndex > 0) {
            goToSlide(currentIndex - 1);
        } else {
            goToSlide(maxIndex); 
        }
    }
    
    // Обработчики кнопок
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    
    // Автопрокрутка
    if (options.autoplay) {
        autoplayInterval = setInterval(nextSlide, options.interval || 3000);
        
        // Останавливаем автопрокрутку при наведении
        sliderElement.addEventListener('mouseenter', () => {
            clearInterval(autoplayInterval);
        });
        
        sliderElement.addEventListener('mouseleave', () => {
            autoplayInterval = setInterval(nextSlide, options.interval || 3000);
        });
    }
    
    // Адаптивность
    if (options.responsive) {
        const handleResize = () => {
            const width = window.innerWidth;
            let newSlidesToShow = slidesToShow;
            
            for (const rule of options.responsive) {
                if (width <= rule.breakpoint) {
                    newSlidesToShow = rule.slidesToShow;
                    break;
                }
            }
            
            if (newSlidesToShow !== slidesToShow) {
                slidesToShow = newSlidesToShow;
                goToSlide(0);
            }
        };
        
        window.addEventListener('resize', handleResize);
        handleResize();
    }
    
    return { goToSlide, nextSlide, prevSlide };
}

/**
 * Инициализация формы обратной связи в сайдбаре
 */
function initFeedbackForm() {
    const feedbackTab = document.querySelector('.feedback-tab');
    const feedbackForm = document.querySelector('.feedback-form-container');
    
    if (feedbackTab && feedbackForm) {
        feedbackTab.addEventListener('click', function() {
            feedbackForm.classList.toggle('active');
        });
        
        // Закрытие при клике вне формы
        document.addEventListener('click', function(e) {
            if (!feedbackForm.contains(e.target) && !feedbackTab.contains(e.target)) {
                feedbackForm.classList.remove('active');
            }
        });
        
        // Обработка отправки формы
        const form = feedbackForm.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Сбор данных формы
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
                
                // Здесь будет отправка на сервер
                console.log('Отправка формы обратной связи:', data);
                
                // Показываем сообщение об успехе
                alert('Спасибо! Мы свяжемся с вами в ближайшее время.');
                form.reset();
                feedbackForm.classList.remove('active');
            });
        }
    }
}

/**
 * Инициализация FAQ аккордеона
 */
function initFaqAccordion() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('click', () => {
            // Закрываем другие открытые элементы
            if (!item.classList.contains('active')) {
                faqItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                });
            }
            
            item.classList.toggle('active');
        });
    });
    
    // Открываем первый элемент по умолчанию
    if (faqItems.length > 0) {
        faqItems[0].classList.add('active');
    }
}

/**
 * Инициализация меню пользователя
 */
function initUserMenu() {
    const userMenu = document.querySelector('.user-menu');
    
    if (userMenu) {
        userMenu.addEventListener('click', function(e) {
            e.stopPropagation();
            this.querySelector('.user-dropdown').classList.toggle('show');
        });
        
        // Закрытие при клике вне меню
        document.addEventListener('click', function() {
            const dropdown = userMenu.querySelector('.user-dropdown');
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });
    }
}

/**
 * Инициализация вкладок личного кабинета
 */
function initProfileTabs() {
    const tabs = document.querySelectorAll('.profile-tab');
    const sections = document.querySelectorAll('.profile-section');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.dataset.tab;
            
            // Деактивируем все вкладки и секции
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));
            
            // Активируем текущие
            this.classList.add('active');
            document.getElementById(target).classList.add('active');
        });
    });
}

/**
 * Инициализация загрузки аватара
 */
function initAvatarUpload() {
    const avatarUpload = document.querySelector('.avatar-upload input');
    
    if (avatarUpload) {
        avatarUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            // Проверка типа файла
            if (!file.type.startsWith('image/')) {
                alert('Пожалуйста, выберите изображение');
                return;
            }
            
            // Проверка размера (макс 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Размер файла не должен превышать 2MB');
                return;
            }
            
            // Создание превью
            const reader = new FileReader();
            reader.onload = function(e) {
                const avatarImg = document.querySelector('.profile-avatar img');
                if (avatarImg) {
                    avatarImg.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
            
            // Здесь будет отправка на сервер
            console.log('Загрузка аватара:', file.name);
        });
    }
}

/**
 * Инициализация мобильного меню
 */
function initMobileMenu() {
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const nav = document.querySelector('.nav');
    
    if (menuBtn && nav) {
        menuBtn.addEventListener('click', function() {
            nav.classList.toggle('show');
        });
    }
}

/**
 * Валидация формы
 */
function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    return isValid;
}

/**
 * Валидация отдельного поля
 */
function validateField(field) {
    const value = field.value.trim();
    const type = field.type;
    const name = field.name;
    let isValid = true;
    let errorMessage = '';
    
    // Удаляем предыдущее сообщение об ошибке
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    field.classList.remove('error');
    
    // Проверка обязательных полей
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'Это поле обязательно для заполнения';
    }
    
    // Проверка email
    if (type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Введите корректный email';
        }
    }
    
    // Проверка пароля (минимум 6 символов)
    if (name === 'password' && value) {
        if (value.length < 6) {
            isValid = false;
            errorMessage = 'Пароль должен содержать минимум 6 символов';
        }
    }
    
    if (!isValid) {
        field.classList.add('error');
        const errorSpan = document.createElement('span');
        errorSpan.className = 'error-message';
        errorSpan.style.color = 'var(--danger)';
        errorSpan.style.fontSize = '0.8rem';
        errorSpan.style.marginTop = '4px';
        errorSpan.style.display = 'block';
        errorSpan.textContent = errorMessage;
        field.parentNode.appendChild(errorSpan);
    }
    
    return isValid;
}

/**
 * Показ уведомлений
 */
function showNotification(message, type = 'info') {
    // Проверяем, существует ли элемент notification
    let notification = document.getElementById('notification');
    
    // Если элемента нет, создаем его
    if (!notification) {
        notification = document.createElement('div');
        notification.id = 'notification';
        document.body.appendChild(notification);
    }
    
    notification.textContent = message;
    notification.style.display = 'block';
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.padding = '15px 25px';
    notification.style.borderRadius = 'var(--border-radius-sm)';
    notification.style.zIndex = '9999';
    notification.style.boxShadow = 'var(--shadow-lg)';
    notification.style.animation = 'slideIn 0.3s ease';
    
    if (type === 'success') {
        notification.style.background = '#D1FAE5';
        notification.style.color = '#065F46';
        notification.style.border = '1px solid #A7F3D0';
    } else if (type === 'error') {
        notification.style.background = '#FEE2E2';
        notification.style.color = '#991B1B';
        notification.style.border = '1px solid #FECACA';
    } else {
        notification.style.background = 'var(--primary)';
        notification.style.color = 'white';
    }
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 300);
    }, 3000);
}

/**
 * Добавление стилей для анимаций
 */
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .error {
        border-color: var(--danger) !important;
    }
    
    .nav.show {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: var(--header-height);
        left: 0;
        right: 0;
        background: white;
        padding: 20px;
        box-shadow: var(--shadow-lg);
        z-index: 999;
    }
    
    .user-dropdown.show {
        display: block;
    }
`;
document.head.appendChild(style);