<?php
$courses = $courses ?? [];
?>

<div class="container" style="padding: 40px 20px;">
    <h1 style="margin-bottom: 40px;">Мои курсы</h1>
    
    <a href="<?php echo url('?page=profile'); ?>" class="btn btn-secondary" style="margin-bottom: 30px;">← Вернуться в личный кабинет</a>
    
    <?php if (!empty($courses)): ?>
        <div class="courses-grid">
            <?php foreach ($courses as $course): ?>
            <div class="course-card">
                <div class="course-image">
                    <img src="<?php echo BASE_URL . ($course['image'] ?? '/assets/images/courses/default.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($course['title']); ?>">
                </div>
                <div class="course-content">
                    <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                    
                    <div class="course-meta">
                        <span>📅 Куплен: <?php echo date('d.m.Y', strtotime($course['purchase_date'])); ?></span>
                    </div>
                    
                    <div style="margin: 15px 0;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span>Прогресс</span>
                            <span>0%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%;"></div>
                        </div>
                    </div>
                    
                    <div class="course-footer">
                        <a href="<?php echo url('?page=course&id=' . $course['course_id']); ?>" class="btn btn-outline">Перейти к курсу</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 60px; background: var(--gray-100); border-radius: var(--border-radius);">
            <p style="font-size: 1.2rem; color: var(--gray-600); margin-bottom: 20px;">У вас пока нет купленных курсов</p>
            <a href="<?php echo url('?page=courses'); ?>" class="btn btn-primary">Перейти к каталогу</a>
        </div>
    <?php endif; ?>
</div>