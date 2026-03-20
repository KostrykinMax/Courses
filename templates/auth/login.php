<?php
$pageTitle = 'Вход - LinguaPro';
?>

<div class="auth-container">
    <div class="auth-header">
        <h2>Вход в личный кабинет</h2>
        <p>Введите ваши данные для входа</p>
    </div>
    
    <div id="errorMessages" style="display: none; background: #FEE2E2; color: #991B1B; padding: 15px; border-radius: var(--border-radius-sm); margin-bottom: 20px;"></div>
    <div id="successMessage" style="display: none; background: #D1FAE5; color: #065F46; padding: 15px; border-radius: var(--border-radius-sm); margin-bottom: 20px;"></div>
    
    <form id="loginForm" class="auth-form">
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль *</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="remember"> Запомнить меня
            </label>
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%;" id="submitBtn">Войти</button>
    </form>
    
    <div class="auth-footer">
        <p>Нет аккаунта? <a href="<?php echo url('?page=register'); ?>">Зарегистрироваться</a></p>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const errorDiv = document.getElementById('errorMessages');
    const successDiv = document.getElementById('successMessage');
    
    errorDiv.style.display = 'none';
    successDiv.style.display = 'none';
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Вход...';
    
    const formData = {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
    };
    
    fetch('/LinguaPro/public/api/auth/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            successDiv.textContent = 'Вход выполнен успешно! Перенаправление...';
            successDiv.style.display = 'block';
            
            setTimeout(() => {
                window.location.href = '/LinguaPro/public/?page=profile';
            }, 1000);
        } else {
            errorDiv.textContent = data.message || 'Неверный email или пароль';
            errorDiv.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.textContent = 'Войти';
        }
    })
    .catch(error => {
        errorDiv.textContent = 'Ошибка соединения с сервером';
        errorDiv.style.display = 'block';
        submitBtn.disabled = false;
        submitBtn.textContent = 'Войти';
    });
});
</script>