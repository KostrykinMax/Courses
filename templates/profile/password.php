<?php
$pageTitle = 'Смена пароля - LinguaPro';
?>

<div class="container" style="padding: 40px 0; max-width: 500px;">
    <div style="background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--border-radius); padding: 40px;">
        <h1 style="margin-bottom: 30px; text-align: center;">Смена пароля</h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div style="background: #FEE2E2; color: #991B1B; padding: 15px; border-radius: var(--border-radius-sm); margin-bottom: 20px;">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div style="background: #D1FAE5; color: #065F46; padding: 15px; border-radius: var(--border-radius-sm); margin-bottom: 20px;">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?= url('?page=password-change') ?>">
            <div class="form-group">
                <label>Текущий пароль</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Новый пароль</label>
                <input type="password" name="new_password" class="form-control" required minlength="6">
            </div>
            <div class="form-group">
                <label>Подтверждение</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Изменить пароль</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="<?= url('?page=profile') ?>" style="color: var(--primary);">← Вернуться в профиль</a>
        </div>
    </div>
</div>