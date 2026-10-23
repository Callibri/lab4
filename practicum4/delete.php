<?php
declare(strict_types=1);
$pdo = require_once __DIR__ . '/db.php';
require_once __DIR__ . '/movies.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        deleteMovie($pdo, $id);
    }
}
header('Location: index.php');
exit;
