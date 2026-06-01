<?php

global $pdo;

// Create table if not exists
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) UNIQUE NOT NULL,
        location VARCHAR(255),
        year INT,
        category VARCHAR(100),
        description TEXT,
        content LONGTEXT,
        image VARCHAR(255),
        featured BOOLEAN DEFAULT FALSE,
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
        $stmt = $pdo->prepare('SELECT * FROM projects WHERE id = ?');
        $stmt->execute([$id]);
        $project = $stmt->fetch();
        respondJSON($project ?: ['error' => 'Not found']);
    } elseif ($slug) {
        $stmt = $pdo->prepare('SELECT * FROM projects WHERE slug = ?');
        $stmt->execute([$slug]);
        $project = $stmt->fetch();
        respondJSON($project ?: ['error' => 'Not found']);
    } else {
        $stmt = $pdo->query('SELECT * FROM projects ORDER BY year DESC');
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
        'INSERT INTO projects (title, slug, location, year, category, description, content, image, featured)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );

    $result = $stmt->execute([
        $title,
        $slug,
        $input['location'] ?? '',
        $input['year'] ?? date('Y'),
        $input['category'] ?? '',
        $input['description'] ?? '',
        $input['content'] ?? '',
        $input['image'] ?? '',
        $input['featured'] ? 1 : 0
    ]);

    if ($result) {
        respondJSON(['id' => $pdo->lastInsertId(), 'success' => true], 201);
    } else {
        respondError('Failed to create project', 500);
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
        'UPDATE projects SET title=?, slug=?, location=?, year=?, category=?, description=?, content=?, image=?, featured=?
         WHERE id=?'
    );

    $result = $stmt->execute([
        $input['title'] ?? '',
        $input['slug'] ?? '',
        $input['location'] ?? '',
        $input['year'] ?? date('Y'),
        $input['category'] ?? '',
        $input['description'] ?? '',
        $input['content'] ?? '',
        $input['image'] ?? '',
        $input['featured'] ? 1 : 0,
        $id
    ]);

    if ($result) {
        respondJSON(['success' => true]);
    } else {
        respondError('Failed to update project', 500);
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

    $stmt = $pdo->prepare('DELETE FROM projects WHERE id=?');
    if ($stmt->execute([$id])) {
        respondJSON(['success' => true]);
    } else {
        respondError('Failed to delete project', 500);
    }
} else {
    respondError('Method not allowed', 405);
}
