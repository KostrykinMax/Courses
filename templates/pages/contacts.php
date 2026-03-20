<?php
// templates/pages/contacts.php
?>
<div class="container" style="padding: 40px 20px;">
    <h1 style="margin-bottom: 40px; text-align: center;">Контакты</h1>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; margin-bottom: 60px;">
        <!-- Контактная информация -->
        <div>
            <h2 style="margin-bottom: 30px;">Свяжитесь с нами</h2>
            
            <div style="margin-bottom: 30px;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                    <div>
                        <h3 style="margin-bottom: 5px;">Телефон</h3>
                        <p style="color: var(--gray-600);">8 (800) 123-45-67</p>
                        <p style="color: var(--gray-600);">+7 (495) 123-45-67</p>
                        <small style="color: var(--gray-400);">Бесплатно по России</small>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                    <div>
                        <h3 style="margin-bottom: 5px;">Email</h3>
                        <p style="color: var(--gray-600);">info@linguapro.ru</p>
                        <p style="color: var(--gray-600);">support@linguapro.ru</p>
                        <small style="color: var(--gray-400);">Ответим в течение 24 часов</small>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                    <div>
                        <h3 style="margin-bottom: 5px;">Адрес</h3>
                        <p style="color: var(--gray-600);">г. Москва, ул. Образования, д. 15</p>
                        <p style="color: var(--gray-600);">БЦ "Образовательный", офис 305</p>
                        <small style="color: var(--gray-400);">м. Проспект Мира</small>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div>
                        <h3 style="margin-bottom: 5px;">Режим работы</h3>
                        <p style="color: var(--gray-600);">Пн-Пт: 9:00 - 21:00</p>
                        <p style="color: var(--gray-600);">Сб-Вс: 10:00 - 18:00</p>
                    </div>
                </div>
            </div>
            
            <!-- Социальные сети -->
            <div style="margin-top: 40px;">
                <h3 style="margin-bottom: 20px;">Мы в соцсетях</h3>
                <div style="display: flex; gap: 15px;">
                    <a href="#" style="width: 45px; height: 45px; background: #4A76A8; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 1.2rem;">VK</a>
                    <a href="#" style="width: 45px; height: 45px; background: #0088cc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 1.2rem;">TG</a>
                    <a href="#" style="width: 45px; height: 45px; background: #FF0000; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 1.2rem;">YT</a>
                    <a href="#" style="width: 45px; height: 45px; background: #25D366; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 1.2rem;">WA</a>
                </div>
            </div>
        </div>
        
        <!-- Форма обратной связи -->
        <div style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--border-radius); padding: 40px;">
            <h2 style="margin-bottom: 30px;">Напишите нам</h2>
            
            <?php if (isset($_SESSION['success'])): ?>
            <div style="background: #D1FAE5; color: #065F46; padding: 15px; border-radius: var(--border-radius-sm); margin-bottom: 20px;">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
            <div style="background: #FEE2E2; color: #991B1B; padding: 15px; border-radius: var(--border-radius-sm); margin-bottom: 20px;">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo url('handlers/contact-handler.php'); ?>">
                <div class="form-group">
                    <label for="name">Ваше имя *</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="+7 (___) ___-__-__">
                </div>
                
                <div class="form-group">
                    <label for="subject">Тема</label>
                    <select id="subject" name="subject" class="form-control">
                        <option value="general">Общий вопрос</option>
                        <option value="course">Вопрос о курсе</option>
                        <option value="payment">Оплата</option>
                        <option value="tech">Техническая поддержка</option>
                        <option value="other">Другое</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">Сообщение *</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Отправить сообщение</button>
            </form>
        </div>
    </div>
    
    <!-- Карта -->
    <div style="margin-top: 60px;">
        <h2 style="margin-bottom: 30px; text-align: center;">Как нас найти</h2>
        <div style="border-radius: var(--border-radius); overflow: hidden; height: 400px;">
            <iframe src="https://yandex.ru/map-widget/v1/?ll=39.855228,57.628503&z=16&pt=39.855228,57.628503,pm2rdm" 
                    width="100%" 
                    height="400" 
                    frameborder="0"
                    style="border: none;"
                    allowfullscreen>
            </iframe>
        </div>
        <p style="text-align: center; margin-top: 15px; color: var(--gray-600);">
            г. Ярославль, ул. Чайковского, 55а
        </p>
    </div>
</div>