<?php
?>
<div class="container" style="padding: 40px 20px;">
    <h1 style="margin-bottom: 30px;">Результаты поиска: "<?php echo htmlspecialchars($query); ?>"</h1>
    
    <div style="background: var(--gray-100); padding: 20px; border-radius: var(--border-radius); margin-bottom: 30px;">
        <form method="GET" action="<?php echo url(''); ?>" style="display: flex; gap: 10px;">
            <input type="hidden" name="page" value="course-search">
            <input type="text" name="q" class="form-control" placeholder="Введите название курса..." value="<?php echo htmlspecialchars($query); ?>" style="flex: 1;">
            <button type="submit" class="btn btn-primary">Найти</button>
            <a href="<?php echo url('?page=courses'); ?>" class="btn btn-secondary">Все курсы</a>
        </form>
    </div>
    
    <?php if (!empty($courses)): ?>
        
        <div class="courses-grid">
            <?php foreach ($courses as $course): ?>
            <div class="course-card">
                <div class="course-image">
                    <img src="<?php echo asset(ltrim($course['image'] ?? '', '/')); ?>" 
                         alt="<?php echo htmlspecialchars($course['title']); ?>"
                         onerror="this.onerror=null; this.src='<?php echo asset('images/placeholder.svg'); ?>';">
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
                        <a href="<?php echo url('?page=course&id=' . $course['course_id']); ?>" class="btn btn-outline" style="flex: 1;">Подробнее</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 60px; background: var(--gray-100); border-radius: var(--border-radius);">
            <p style="font-size: 1.2rem; color: var(--gray-600); margin-bottom: 20px;">По вашему запросу "<strong><?php echo htmlspecialchars($query); ?></strong>" ничего не найдено</p>
            <p style="color: var(--gray-600); margin-bottom: 30px;">Попробуйте изменить поисковый запрос или посмотрите все курсы</p>
            <a href="<?php echo url('?page=courses'); ?>" class="btn btn-primary">Смотреть все курсы</a>
        </div>
    <?php endif; ?>
</div>