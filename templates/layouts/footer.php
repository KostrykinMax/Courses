</main>
    <footer class="footer">
        <div class="container">
            <div class="footer__grid">
                <div class="footer__col">
                    <span class="footer-logo">LinguaPro</span>
                    <p>Онлайн-школа иностранных языков с индивидуальным подходом и современными технологиями.</p>
                    <p>Работаем с 2015 года</p>
                </div>
                <div class="footer__col">
                    <h4>Навигация</h4>
                    <a href="<?php echo url(''); ?>">Главная</a>
                    <a href="<?php echo url('?page=courses'); ?>">Курсы</a>
                    <a href="<?php echo url('?page=teachers'); ?>">Преподаватели</a>
                    <a href="<?php echo url('?page=blog'); ?>">Блог</a>
                    <a href="<?php echo url('?page=faq'); ?>">Вопрос-ответ</a>
                    <a href="<?php echo url('?page=contacts'); ?>">Контакты</a>
                </div>
                <div class="footer__col">
                    <h4>Курсы</h4>
                    <a href="<?php echo url('?page=course&id=1'); ?>">Английский язык</a>
                    <a href="<?php echo url('?page=course&id=2'); ?>">Немецкий язык</a>
                    <a href="<?php echo url('?page=course&id=3'); ?>">Французский язык</a>
                    <a href="<?php echo url('?page=course&id=4'); ?>">Испанский язык</a>
                    <a href="<?php echo url('?page=course&id=5'); ?>">Итальянский язык</a>
                </div>
                <div class="footer__col">
                    <h4>Контакты</h4>
                    <p> 8 (800) 123-45-67</p>
                    <p> info@linguapro.ru</p>
                    <p> Ярославль, ул. Чайковского 55а</p>
                    <p> Пн-Пт: 9:00-21:00</p>
                    <p> Сб-Вс: 10:00-18:00</p>
                    <div class="social-links">
                        <a href="#" aria-label="VK">📘</a>
                        <a href="#" aria-label="MAX">📱</a>
                        <a href="#" aria-label="Rutube">📺</a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                © 2026 LinguaPro. Все права защищены. 
                <a href="<?php echo url('?page=privacy'); ?>">Политика конфиденциальности</a>
            </div>
        </div>
    </footer>

    <script src="<?php echo asset('js/main.js'); ?>"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var header = document.querySelector('.header');
            if (header) {
                var headerStyles = window.getComputedStyle(header);
                if (headerStyles.position === 'sticky') {
                } else {
                    var warning = document.createElement('div');
                    warning.style.cssText = 'position: fixed; top: 0; left: 0; right: 0; background: red; color: white; text-align: center; padding: 10px; z-index: 9999;';
                    warning.textContent = '⚠️ Ошибка загрузки CSS. Проверьте путь: ' + '<?php echo asset('css/main.css'); ?>';
                    document.body.prepend(warning);
                }
            }
        });
    </script>
</body>
</html>