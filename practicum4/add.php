<?php
declare(strict_types=1);
$pdo = require_once __DIR__ . '/db.php';
require_once __DIR__ . '/movies.php';

$errors = [];
$movie  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$movie, $errors] = validateMovie($_POST);
    if (!$errors) {
        addMovie($pdo, $movie);
        header('Location: index.php');
        exit;
    }
}

$action      = 'add.php';
$submitLabel = 'Додати';
require __DIR__ . '/_header.php';
echo '<h1>Додати фільм</h1>';
require __DIR__ . '/_form.php';
require __DIR__ . '/_footer.php';
