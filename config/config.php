<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/LinguaPro/public');
}

// Базовые пути
define('ASSETS_URL', BASE_URL . '/assets');

// Определяем текущую страницу
$current_page = $_GET['page'] ?? 'home';

// Функция для генерации правильных URL
function asset($path) {
    return ASSETS_URL . '/' . ltrim($path, '/');
}

function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

function currentPage() {
    global $current_page;
    return $current_page;
}

function isActive($page) {
    return currentPage() === $page ? 'active' : '';
}