<?php
// templates/blog/show.php
$post = $post ?? [];
?>

<div class="container" style="padding: 40px 0; max-width: 800px;">
    <a href="<?php echo url('?page=blog'); ?>" class="btn btn-secondary" style="margin-bottom: 30px;">← Вернуться к блогу</a>
    
    <div style="background: white; border-radius: var(--border-radius); padding: 40px; box-shadow: var(--shadow-md);">
        <div style="margin-bottom: 30px;">
            <span style="background: var(--primary); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem;">
                <?php echo htmlspecialchars($post['category']); ?>
            </span>
        </div>
        
        <h1 style="margin-bottom: 20px;"><?php echo htmlspecialchars($post['title']); ?></h1>
        
        <div style="display: flex; gap: 20px; color: var(--gray-400); margin-bottom: 30px; flex-wrap: wrap;">
            <span>📅 <?php echo date('d F Y', strtotime($post['date'])); ?></span>
        </div>
        
        <?php if (!empty($post['image'])): ?>
        <div style="margin-bottom: 30px;">
            <img src="<?php echo BASE_URL . $post['image']; ?>" 
                 alt="<?php echo htmlspecialchars($post['title']); ?>"
                 style="width: 100%; border-radius: var(--border-radius);"
                 onerror="this.src='<?php echo asset('images/placeholder.svg'); ?>'">
        </div>
        <?php endif; ?>
        
        <div class="blog-author" style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px; padding: 20px; background: var(--gray-100); border-radius: var(--border-radius);">
            <div>
                <div style="font-weight: 600;"><?php echo htmlspecialchars($post['author']); ?></div>
                <div style="color: var(--gray-600); font-size: 0.9rem;">Автор статьи</div>
            </div>
        </div>
        
        <div class="blog-content" style="line-height: 1.8; font-size: 1.1rem;">
            <?php echo nl2br(htmlspecialchars($post['content'] ?? 'Содержание статьи скоро будет добавлено')); ?>
        </div>
        
        <!-- Кнопки поделиться -->
        <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid var(--gray-200);">
            <div style="display: flex; gap: 15px; align-items: center;">
                <span style="font-weight: 600;">Поделиться:</span>
                <a href="#" class="btn btn-secondary btn-sm">VK</a>
                <a href="#" class="btn btn-secondary btn-sm">Telegram</a>
                <a href="#" class="btn btn-secondary btn-sm">Email</a>
            </div>
        </div>
    </div>
</div>