<?php
$user = $user ?? [];
$courses = $courses ?? [];
$payments = $payments ?? [];
?>

<div class="container" style="padding: 40px 20px;">
    <h1 style="margin-bottom: 40px;">Личный кабинет</h1>
    
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

    <div id="notification" style="display: none; padding: 15px; border-radius: var(--border-radius-sm); margin-bottom: 20px;"></div>
    
    <!-- Информация о пользователе -->
    <div style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--border-radius); padding: 30px; margin-bottom: 30px;">
        <div style="display: flex; gap: 30px; align-items: center; flex-wrap: wrap;">
            <div style="position: relative; width: 120px; height: 120px;">
                <img src="<?php echo BASE_URL . $user['avatar']; ?>" 
                     alt="Avatar" id="userAvatar"
                     style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary);"
                     onerror="this.src='<?php echo asset('images/default-avatar.svg'); ?>'">
                <form id="avatarForm" enctype="multipart/form-data" style="position: absolute; bottom: 0; right: 0;">
                    <input type="file" name="avatar" id="avatarUpload" style="display: none;" accept="image/*">
                    <button type="button" onclick="document.getElementById('avatarUpload').click()" style="width: 36px; height: 36px; background: var(--primary); border: none; border-radius: 50%; color: white; cursor: pointer; font-size: 1.2rem; display: flex; align-items: center; justify-content: center;">✏️</button>
                </form>
            </div>
            <div>
                <h2 id="userFullName"><?php echo htmlspecialchars($user['last_name'] . ' ' . $user['first_name'] . ' ' . $user['middle_name']); ?></h2>
                <p style="color: var(--gray-600); margin-bottom: 5px;"><span id="userEmail"><?php echo htmlspecialchars($user['email']); ?></span></p>
            </div>
            <div style="margin-left: auto;">
                <a href="<?php echo url('?page=edit-profile'); ?>" class="btn btn-primary">Редактировать профиль</a>
            </div>
        </div>
    </div>
    
    <!-- Статистика -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--border-radius); padding: 20px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 800; color: var(--primary);" id="coursesCount"><?php echo count($courses); ?></div>
            <div style="color: var(--gray-600);">Куплено курсов</div>
        </div>
        <div style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--border-radius); padding: 20px; text-align: center;">
            <div style="font-size: 2rem; font-weight: 800; color: var(--primary);" id="paymentsCount"><?php echo count($payments); ?></div>
            <div style="color: var(--gray-600);">Всего платежей</div>
        </div>
    </div>
    
    <!-- Вкладки -->
    <div style="display: flex; gap: 4px; border-bottom: 2px solid var(--gray-200); margin-bottom: 30px;">
        <button class="profile-tab active" data-tab="courses">Мои курсы</button>
        <button class="profile-tab" data-tab="payments">История платежей</button>
        <button class="profile-tab" data-tab="settings">Настройки</button>
    </div>
    
    <!-- Содержимое вкладок -->
    <div id="courses" class="profile-section active">
        <h3 style="margin-bottom: 20px;">Мои курсы</h3>
        <div id="coursesList">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                <div class="my-course-item">
                    <div style="width: 80px; height: 80px; border-radius: var(--border-radius-sm); overflow: hidden;">
                        <img src="<?php echo BASE_URL . ($course['image'] ?? '/assets/images/courses/default.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($course['title']); ?>"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="flex: 1;">
                        <h4 style="margin-bottom: 5px;"><?php echo htmlspecialchars($course['title']); ?></h4>
                        <p style="color: var(--gray-600); font-size: 0.9rem; margin-bottom: 10px;">
                            Куплен: <?php echo date('d.m.Y', strtotime($course['purchase_date'])); ?>
                            <?php if ($course['payment_status'] == 'paid'): ?>
                            <span style="background: #D1FAE5; color: #065F46; padding: 2px 8px; border-radius: 20px; margin-left: 10px;">Оплачен</span>
                            <?php else: ?>
                            <span style="background: #FEF3C7; color: #92400E; padding: 2px 8px; border-radius: 20px; margin-left: 10px;">Ожидает оплаты</span>
                            <?php endif; ?>
                        </p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%;"></div>
                        </div>
                    </div>
                    <div>
                        <a href="<?php echo url('?page=course&id=' . $course['course_id']); ?>" class="btn btn-outline btn-sm">Перейти</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; padding: 40px; background: var(--gray-100); border-radius: var(--border-radius);">
                    У вас пока нет купленных курсов. <a href="<?php echo url('?page=courses'); ?>">Перейти к каталогу</a>
                </p>
            <?php endif; ?>
        </div>
    </div>
    
    <div id="payments" class="profile-section">
        <h3 style="margin-bottom: 20px;">История платежей</h3>
        <div id="paymentsList">
            <?php if (!empty($payments)): ?>
                <div class="payments-list">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--gray-100);">
                                <th style="padding: 12px; text-align: left;">Дата</th>
                                <th style="padding: 12px; text-align: left;">Курс</th>
                                <th style="padding: 12px; text-align: left;">Сумма</th>
                                <th style="padding: 12px; text-align: left;">Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $payment): ?>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 12px;"><?php echo date('d.m.Y H:i', strtotime($payment['purchase_date'])); ?></td>
                                <td style="padding: 12px;"><?php echo htmlspecialchars($payment['course_title']); ?></td>
                                <td style="padding: 12px; font-weight: 600;"><?php echo number_format($payment['price'], 0, '.', ' '); ?> ₽</td>
                                <td style="padding: 12px;">
                                    <?php if ($payment['payment_status'] == 'paid'): ?>
                                    <span class="payment-status paid">Оплачено</span>
                                    <?php elseif ($payment['payment_status'] == 'pending'): ?>
                                    <span class="payment-status pending">В обработке</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="text-align: center; padding: 40px; background: var(--gray-100); border-radius: var(--border-radius);">
                    История платежей пуста
                </p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Вкладка настроек -->
    <div id="settings" class="profile-section">
        <h3 style="margin-bottom: 20px;">Настройки профиля</h3>
        
        <div style="max-width: 400px;">
            <div style="background: var(--gray-100); padding: 30px; border-radius: var(--border-radius);">
                <h4 style="margin-bottom: 20px;">Безопасность</h4>
                <p style="margin-bottom: 20px; color: var(--gray-600);">
                    Регулярно меняйте пароль для безопасности вашего аккаунта.
                </p>
                <a href="<?php echo url('?page=password'); ?>" class="btn btn-primary">
                    Сменить пароль
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Вкладки
    const tabs = document.querySelectorAll('.profile-tab');
    const sections = document.querySelectorAll('.profile-section');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.dataset.tab;
            
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));
            
            this.classList.add('active');
            document.getElementById(target).classList.add('active');
        });
    });
    
    // Загрузка аватара через API
    const avatarUpload = document.getElementById('avatarUpload');
    if (avatarUpload) {
        avatarUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('user_id', <?php echo $user['user_id']; ?>);
            
            fetch('/LinguaPro/public/api/avatar/upload', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('userAvatar').src = data.avatar_url + '?t=' + new Date().getTime();
                    showNotification('Аватар успешно обновлен', 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                showNotification('Ошибка при загрузке', 'error');
            });
        });
    }
    
    // Функция показа уведомлений
    function showNotification(message, type) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.style.display = 'block';
        notification.style.background = type === 'success' ? '#D1FAE5' : '#FEE2E2';
        notification.style.color = type === 'success' ? '#065F46' : '#991B1B';
        
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }
});
</script>

<style>
.profile-tab {
    padding: 12px 24px;
    background: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    color: var(--gray-600);
    position: relative;
    font-size: 1rem;
}

.profile-tab.active {
    color: var(--primary);
}

.profile-tab.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 2px;
    background: var(--primary);
}

.profile-section {
    display: none;
}

.profile-section.active {
    display: block;
}

.my-courses-list {
    display: grid;
    gap: 16px;
}

.my-course-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 16px;
    background: var(--white);
    border-radius: var(--border-radius-sm);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.my-course-item:hover {
    box-shadow: var(--shadow-md);
    border-color: var(--primary);
}

.payments-list {
    background: var(--white);
    border-radius: var(--border-radius-sm);
    border: 1px solid var(--gray-200);
    overflow: hidden;
}

.payment-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-block;
}

.payment-status.paid {
    background: #D1FAE5;
    color: #065F46;
}

.payment-status.pending {
    background: #FEF3C7;
    color: #92400E;
}

@media (max-width: 768px) {
    .my-course-item {
        flex-direction: column;
        text-align: center;
    }
    
    .payments-list table {
        font-size: 0.9rem;
    }
    
    .payments-list th,
    .payments-list td {
        padding: 8px;
    }
}
</style>