<?php

global $pdo;

// Create table if not exists
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS blog_posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) UNIQUE NOT NULL,
        excerpt TEXT,
        content LONGTEXT,
        category VARCHAR(100),
        author VARCHAR(100),
        image VARCHAR(255),
        readTime VARCHAR(20),
        publishedAt DATETIME,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch (Exception $e) {
    // Table might already exist
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

if ($method === 'GET') {
    // Get all or by ID
    $id = $_GET['id'] ?? null;
    $slug = $_GET['slug'] ?? null;

    if ($id) {
        $stmt = $pdo->prepare('SELECT * FROM blog_posts WHERE id = ?');
        $stmt->execute([$id]);
        $post = $stmt->fetch();
        respondJSON($post ?: ['error' => 'Not found']);
    } elseif ($slug) {
        $stmt = $pdo->prepare('SELECT * FROM blog_posts WHERE slug = ?');
        $stmt->execute([$slug]);
        $post = $stmt->fetch();
        respondJSON($post ?: ['error' => 'Not found']);
    } else {
        $stmt = $pdo->query('SELECT * FROM blog_posts ORDER BY publishedAt DESC');
        respondJSON($stmt->fetchAll());
    }
} elseif ($method === 'POST') {
    // Verify token
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
        'INSERT INTO blog_posts (title, slug, excerpt, content, category, author, image, readTime, publishedAt)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );

    $result = $stmt->execute([
        $title,
        $slug,
        $input['excerpt'] ?? '',
        $input['content'] ?? '',
        $input['category'] ?? '',
        $input['author'] ?? '',
        $input['image'] ?? '',
        $input['readTime'] ?? '5 min',
        $input['publishedAt'] ?? date('Y-m-d H:i:s')
    ]);

    if ($result) {
        respondJSON(['id' => $pdo->lastInsertId(), 'success' => true], 201);
    } else {
        respondError('Failed to create post', 500);
    }
} elseif ($method === 'PUT') {
    // Verify token
    $token = getAuthToken();
    if (!verifyToken($token)) {
        respondError('Unauthorized', 401);
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        respondError('ID required', 400);
    }

    $stmt = $pdo->prepare(
        'UPDATE blog_posts SET title=?, slug=?, excerpt=?, content=?, category=?, author=?, image=?, readTime=?, publishedAt=?
         WHERE id=?'
    );

    $result = $stmt->execute([
        $input['title'] ?? '',
        $input['slug'] ?? '',
        $input['excerpt'] ?? '',
        $input['content'] ?? '',
        $input['category'] ?? '',
        $input['author'] ?? '',
        $input['image'] ?? '',
        $input['readTime'] ?? '5 min',
        $input['publishedAt'] ?? date('Y-m-d H:i:s'),
        $id
    ]);

    if ($result) {
        respondJSON(['success' => true]);
    } else {
        respondError('Failed to update post', 500);
    }
} elseif ($method === 'DELETE') {
    // Verify token
    $token = getAuthToken();
    if (!verifyToken($token)) {
        respondError('Unauthorized', 401);
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        respondError('ID required', 400);
    }

    $stmt = $pdo->prepare('DELETE FROM blog_posts WHERE id=?');
    if ($stmt->execute([$id])) {
        respondJSON(['success' => true]);
    } else {
        respondError('Failed to delete post', 500);
    }
} else {
    respondError('Method not allowed', 405);
}
