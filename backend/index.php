<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/auth/jwt.php';

// Parse URL
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', trim($requestUri, '/'));
$endpoint = end($parts);
$method = $_SERVER['REQUEST_METHOD'];

// Route requests
if ($endpoint === 'login' && $method === 'POST') {
    require __DIR__ . '/api/login.php';
}
elseif ($endpoint === 'blog-posts') {
    require __DIR__ . '/api/blog.php';
}
elseif ($endpoint === 'projects') {
    require __DIR__ . '/api/projects.php';
}
elseif ($endpoint === 'products') {
    require __DIR__ . '/api/products.php';
}
else {
    respondError('Endpoint not found', 404);
}
