<?php
$pageTitle = 'Регистрация - LinguaPro';
?>

<div class="auth-container">
    <div class="auth-header">
        <h2>Создать аккаунт</h2>
        <p>Начните учить языки уже сегодня</p>
    </div>
    
    <div id="errorMessages" style="display: none; background: #FEE2E2; color: #991B1B; padding: 15px; border-radius: var(--border-radius-sm); margin-bottom: 20px;"></div>
    <div id="successMessage" style="display: none; background: #D1FAE5; color: #065F46; padding: 15px; border-radius: var(--border-radius-sm); margin-bottom: 20px;"></div>
    
    <form id="registerForm" class="auth-form">
        <div class="form-group">
            <label for="last_name">Фамилия *</label>
            <input type="text" id="last_name" name="last_name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="first_name">Имя *</label>
            <input type="text" id="first_name" name="first_name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="middle_name">Отчество</label>
            <input type="text" id="middle_name" name="middle_name" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль *</label>
            <input type="password" id="password" name="password" class="form-control" required minlength="6">
            <ul class="password-requirements">
                <li>Минимум 6 символов</li>
            </ul>
        </div>
        
        <div class="form-group">
            <label for="password_confirm">Подтверждение пароля *</label>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="agree" required>
                Я согласен с <a href="#">условиями обработки данных</a>
            </label>
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%;" id="submitBtn">Зарегистрироваться</button>
    </form>
    
    <div class="auth-footer">
        Уже есть аккаунт? <a href="<?php echo url('?page=login'); ?>">Войти</a>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const errorDiv = document.getElementById('errorMessages');
    const successDiv = document.getElementById('successMessage');
    
    errorDiv.style.display = 'none';
    successDiv.style.display = 'none';
    
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;
    
    if (password !== passwordConfirm) {
        errorDiv.textContent = 'Пароли не совпадают';
        errorDiv.style.display = 'block';
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Регистрация...';
    
    const formData = {
        last_name: document.getElementById('last_name').value,
        first_name: document.getElementById('first_name').value,
        middle_name: document.getElementById('middle_name').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
    };
    
    fetch('/LinguaPro/public/api/auth/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            successDiv.textContent = 'Регистрация успешна! Сейчас вы будете перенаправлены на страницу входа.';
            successDiv.style.display = 'block';
            
            setTimeout(() => {
                window.location.href = '/LinguaPro/public/?page=login';
            }, 2000);
        } else {
            if (data.errors) {
                errorDiv.innerHTML = data.errors.join('<br>');
            } else {
                errorDiv.textContent = data.message || 'Ошибка при регистрации';
            }
            errorDiv.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.textContent = 'Зарегистрироваться';
        }
    })
    .catch(error => {
        errorDiv.textContent = 'Ошибка соединения с сервером';
        errorDiv.style.display = 'block';
        submitBtn.disabled = false;
        submitBtn.textContent = 'Зарегистрироваться';
    });
});
</script>