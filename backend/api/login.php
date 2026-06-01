<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../auth/jwt.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['email']) || !isset($input['password'])) {
    respondError('Email and password required', 400);
}

$email = $input['email'];
$password = $input['password'];

// For demo: hardcoded admin user (in production, store hashed passwords in DB)
$adminEmail = getenv('ADMIN_EMAIL');
$adminPassword = getenv('ADMIN_PASSWORD');

if ($email === $adminEmail && $password === $adminPassword) {
    JWT::setSecret(getenv('JWT_SECRET'));

    $token = JWT::encode([
        'email' => $email,
        'role' => 'admin',
        'iat' => time(),
        'exp' => time() + (30 * 24 * 60 * 60) // 30 days
    ]);

    respondJSON([
        'success' => true,
        'token' => $token,
        'user' => [
            'email' => $email,
            'role' => 'admin'
        ]
    ]);
} else {
    respondError('Invalid credentials', 401);
}
