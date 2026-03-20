<?php
$lesson = $lesson ?? [];
$courseLessons = $courseLessons ?? [];
$nextLesson = $nextLesson ?? null;
$prevLesson = $prevLesson ?? null;
?>

<div class="container" style="padding: 40px 0;">
    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 30px;">
        <!-- Список уроков -->
        <div style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--border-radius); padding: 20px;">
            <h3 style="margin-bottom: 20px;">Содержание курса</h3>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <?php foreach ($courseLessons as $courseLesson): ?>
                <a href="<?php echo url('?page=lesson&id=' . $courseLesson['lesson_id']); ?>" 
                   style="text-decoration: none; padding: 10px; border-radius: var(--border-radius-sm); 
                          <?php echo ($courseLesson['lesson_id'] == $lesson['lesson_id']) ? 'background: var(--primary); color: white;' : 'color: var(--dark);'; ?> 
                          ">
                    <?php echo $courseLesson['order'] ?? $courseLesson['lesson_id']; ?>. <?php echo htmlspecialchars($courseLesson['title']); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Контент урока -->
        <div>
            <!-- Навигация -->
            <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                <h2><?php echo htmlspecialchars($lesson['title']); ?></h2>
                <div style="display: flex; gap: 10px;">
                    <?php if ($prevLesson): ?>
                    <a href="<?php echo url('?page=lesson&id=' . $prevLesson['lesson_id']); ?>" class="btn btn-secondary">← Предыдущий</a>
                    <?php endif; ?>
                    <?php if ($nextLesson): ?>
                    <a href="<?php echo url('?page=lesson&id=' . $nextLesson['lesson_id']); ?>" class="btn btn-primary">Следующий →</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Видео (если есть) -->
            <?php if (!empty($lesson['video_url'])): ?>
            <div style="margin-bottom: 30px;">
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: var(--border-radius);">
                    <iframe src="<?php echo htmlspecialchars($lesson['video_url']); ?>" 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Текстовый контент -->
            <?php if (!empty($lesson['content'])): ?>
            <div style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--border-radius); padding: 30px; line-height: 1.8;">
                <?php echo nl2br(htmlspecialchars($lesson['content'])); ?>
            </div>
            <?php endif; ?>
            
            <!-- Мобильная навигация -->
            <div style="margin-top: 30px; display: flex; gap: 10px; justify-content: center;">
                <?php if ($prevLesson): ?>
                <a href="<?php echo url('?page=lesson&id=' . $prevLesson['lesson_id']); ?>" class="btn btn-secondary">← Предыдущий</a>
                <?php endif; ?>
                <?php if ($nextLesson): ?>
                <a href="<?php echo url('?page=lesson&id=' . $nextLesson['lesson_id']); ?>" class="btn btn-primary">Следующий →</a>
                <?php endif; ?>
            </div>
            
            <!-- Прогресс -->
            <?php
            $totalLessons = count($courseLessons);
            $currentIndex = array_search($lesson['lesson_id'], array_column($courseLessons, 'lesson_id')) + 1;
            $progress = round(($currentIndex / $totalLessons) * 100);
            ?>
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--gray-200);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span>Прогресс курса</span>
                    <span><?php echo $currentIndex; ?> из <?php echo $totalLessons; ?> уроков (<?php echo $progress; ?>%)</span>
                </div>
                <div class="progress-bar" style="height: 8px; background: var(--gray-200); border-radius: 4px; overflow: hidden;">
                    <div class="progress-fill" style="width: <?php echo $progress; ?>%; height: 100%; background: var(--primary);"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .container > div {
        grid-template-columns: 1fr !important;
    }
}
</style>