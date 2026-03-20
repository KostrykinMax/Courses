<?php
$request_uri = $_SERVER['REQUEST_URI'];

if (strpos($request_uri, '/api/auth/register') !== false) {
    require_once 'register.php';
} elseif (strpos($request_uri, '/api/auth/login') !== false) {
    require_once 'login.php';
} elseif (strpos($request_uri, '/api/auth/logout') !== false) {
    require_once 'logout.php';
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'API endpoint not found']);
}