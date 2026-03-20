<?php
?>
<div class="container" style="padding: 40px 20px;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
        <!-- Основная информация о курсе -->
        <div>
            <h1><?php echo htmlspecialchars($course['title']); ?></h1>
            
            <?php if ($course['image']): ?>
            <img src="<?php echo BASE_URL . $course['image']; ?>" alt="<?php echo htmlspecialchars($course['title']); ?>" 
                 style="width: 100%; border-radius: var(--border-radius); margin: 20px 0;"
                 onerror="this.src='<?php echo asset('images/placeholder.jpg'); ?>'">
            <?php endif; ?>
            
            <div style="background: var(--gray-100); padding: 20px; border-radius: var(--border-radius); margin: 20px 0;">
                <h3>Описание курса</h3>
                <p><?php echo nl2br(htmlspecialchars($course['description'] ?? 'Нет описания')); ?></p>
            </div>
            
            <!-- Программа курса -->
            <h3>Программа курса</h3>
            <div style="margin-top: 20px;">
                <?php if (!empty($lessons)): ?>
                    <?php foreach ($lessons as $index => $lesson): ?>
                    <div class="lesson-item" style="padding: 15px; border: 1px solid var(--gray-200); border-radius: var(--border-radius-sm); margin-bottom: 10px; display: flex; align-items: center; gap: 15px;">
                        <div style="width: 40px; height: 40px; background: <?php echo $isPurchased ? 'var(--primary)' : 'var(--gray-200)'; ?>; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                            <?php echo $index + 1; ?>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="margin-bottom: 5px;"><?php echo htmlspecialchars($lesson['title']); ?></h4>
                            <?php if ($lesson['duration']): ?>
                            <small style="color: var(--gray-600);">⏱ <?php echo $lesson['duration']; ?> мин</small>
                            <?php endif; ?>
                        </div>
                        <?php if ($isPurchased): ?>
                        <a href="<?php echo url('?page=lesson&id=' . $lesson['lesson_id']); ?>" class="btn btn-primary btn-sm">Смотреть</a>
                        <?php else: ?>
                        <span class="btn btn-secondary btn-sm" style="opacity: 0.5;">🔒 Доступ после покупки</span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Программа курса скоро будет добавлена</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Боковая панель с ценой и покупкой -->
        <div>
            <div style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--border-radius); padding: 30px; position: sticky; top: 100px;">
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 20px;">
                    <?php echo number_format($course['price'], 0, '.', ' '); ?> ₽
                </div>
                
                <?php if ($course['duration_hours']): ?>
                <p style="margin-bottom: 10px;">
                    <strong>Длительность:</strong> <?php echo $course['duration_hours']; ?> часов
                </p>
                <?php endif; ?>
                
                <?php if ($course['start_date'] && $course['end_date']): ?>
                <p style="margin-bottom: 20px;">
                    <strong>Даты курса:</strong><br>
                    <?php echo date('d.m.Y', strtotime($course['start_date'])); ?> - 
                    <?php echo date('d.m.Y', strtotime($course['end_date'])); ?>
                </p>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($isPurchased ?? false): ?>
                        <div style="background: #D1FAE5; color: #065F46; padding: 15px; border-radius: var(--border-radius-sm); text-align: center; margin-bottom: 20px;">
                            ✓ Вы уже приобрели этот курс
                        </div>
                        <a href="<?php echo url('?page=my-courses'); ?>" class="btn btn-primary" style="width: 100%;">Перейти к курсу</a>
                    <?php else: ?>
                        <form method="POST" action="<?php echo url('?page=course-purchase'); ?>">
                            <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Купить курс</button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="text-align: center; margin-bottom: 15px; color: var(--gray-600);">
                        Войдите в аккаунт, чтобы купить курс
                    </p>
                    <a href="<?php echo url('?page=login'); ?>" class="btn btn-primary" style="width: 100%;">Войти</a>
                    <a href="<?php echo url('?page=register'); ?>" style="display: block; text-align: center; margin-top: 10px; color: var(--primary);">Зарегистрироваться</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>