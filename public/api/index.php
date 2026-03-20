<?php
// Главный роутер API
$request_uri = $_SERVER['REQUEST_URI'];

if (strpos($request_uri, '/api/auth/') !== false) {
    require_once 'auth/index.php';
} elseif (strpos($request_uri, '/api/user/') !== false) {
    require_once 'user/index.php';
} elseif (strpos($request_uri, '/api/avatar/') !== false) {
    require_once 'avatar/index.php';
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'API endpoint not found']);
}