<?php
declare(strict_types=1);
$pdo = require_once __DIR__ . '/db.php';
require_once __DIR__ . '/movies.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$movie = findMovie($pdo, $id);

if ($movie === null) {
    http_response_code(404);
    exit('Фільм не знайдено. <a href="index.php">Назад</a>');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$data, $errors] = validateMovie($_POST);
    if (!$errors) {
        updateMovie($pdo, $id, $data);
        header('Location: index.php');
        exit;
    }
    $movie = $data; 
}

$action      = 'edit.php?id=' . $id;
$submitLabel = 'Зберегти';
require __DIR__ . '/_header.php';
echo '<h1>Редагувати фільм #' . $id . '</h1>';
require __DIR__ . '/_form.php';
require __DIR__ . '/_footer.php';
