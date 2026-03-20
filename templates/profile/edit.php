<?php
$user = $user ?? [];
?>

<div class="container" style="padding: 40px 0; max-width: 600px;">
    <h1 style="margin-bottom: 40px;">Редактирование профиля</h1>
    
    <?php if (isset($_SESSION['error'])): ?>
    <div style="background: #FEE2E2; color: #991B1B; padding: 15px; border-radius: var(--border-radius-sm); margin-bottom: 20px;">
        <?php 
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
    </div>
    <?php endif; ?>
    
    <a href="<?php echo url('?page=profile'); ?>" class="btn btn-secondary" style="margin-bottom: 30px;">← Вернуться</a>
    
    <form method="POST" action="<?php echo url('?page=edit-profile'); ?>">
        <div class="form-group">
            <label>Фамилия *</label>
            <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Имя *</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Отчество</label>
            <input type="text" name="middle_name" class="form-control" value="<?php echo htmlspecialchars($user['middle_name'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="<?php echo url('?page=profile'); ?>" class="btn btn-secondary">Отмена</a>
    </form>
</div>