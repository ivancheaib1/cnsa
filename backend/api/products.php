<?php

global $pdo;

// Create table if not exists
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) UNIQUE NOT NULL,
        subtitle VARCHAR(255),
        description LONGTEXT,
        icon VARCHAR(100),
        image VARCHAR(255),
        `order` INT DEFAULT 0,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch (Exception $e) {
    // Table might already exist
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

if ($method === 'GET') {
    $id = $_GET['id'] ?? null;
    $slug = $_GET['slug'] ?? null;

    if ($id) {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $product = $stmt->fetch();
        respondJSON($product ?: ['error' => 'Not found']);
    } elseif ($slug) {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE slug = ?');
        $stmt->execute([$slug]);
        $product = $stmt->fetch();
        respondJSON($product ?: ['error' => 'Not found']);
    } else {
        $stmt = $pdo->query('SELECT * FROM products ORDER BY `order` ASC');
        respondJSON($stmt->fetchAll());
    }
} elseif ($method === 'POST') {
    $token = getAuthToken();
    if (!verifyToken($token)) {
        respondError('Unauthorized', 401);
    }

    $title = $input['title'] ?? null;
    $slug = $input['slug'] ?? null;

    if (!$title || !$slug) {
        respondError('Title and slug required', 400);
    }

    $stmt = $pdo->prepare(
        'INSERT INTO products (title, slug, subtitle, description, icon, image, `order`)
         VALUES (?, ?, ?, ?, ?, ?, ?)'
    );

    $result = $stmt->execute([
        $title,
        $slug,
        $input['subtitle'] ?? '',
        $input['description'] ?? '',
        $input['icon'] ?? 'paint',
        $input['image'] ?? '',
        $input['order'] ?? 0
    ]);

    if ($result) {
        respondJSON(['id' => $pdo->lastInsertId(), 'success' => true], 201);
    } else {
        respondError('Failed to create product', 500);
    }
} elseif ($method === 'PUT') {
    $token = getAuthToken();
    if (!verifyToken($token)) {
        respondError('Unauthorized', 401);
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        respondError('ID required', 400);
    }

    $stmt = $pdo->prepare(
        'UPDATE products SET title=?, slug=?, subtitle=?, description=?, icon=?, image=?, `order`=?
         WHERE id=?'
    );

    $result = $stmt->execute([
        $input['title'] ?? '',
        $input['slug'] ?? '',
        $input['subtitle'] ?? '',
        $input['description'] ?? '',
        $input['icon'] ?? 'paint',
        $input['image'] ?? '',
        $input['order'] ?? 0,
        $id
    ]);

    if ($result) {
        respondJSON(['success' => true]);
    } else {
        respondError('Failed to update product', 500);
    }
} elseif ($method === 'DELETE') {
    $token = getAuthToken();
    if (!verifyToken($token)) {
        respondError('Unauthorized', 401);
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        respondError('ID required', 400);
    }

    $stmt = $pdo->prepare('DELETE FROM products WHERE id=?');
    if ($stmt->execute([$id])) {
        respondJSON(['success' => true]);
    } else {
        respondError('Failed to delete product', 500);
    }
} else {
    respondError('Method not allowed', 405);
}
