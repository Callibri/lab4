<?php
declare(strict_types=1);

$file   = __DIR__ . DIRECTORY_SEPARATOR . 'practicum4.sqlite';
$isNew  = !file_exists($file);

$pdo = new PDO('sqlite:' . $file, null, null, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // помилки SQL -> PDOException
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // рядки як асоціативні масиви
]);

if ($isNew) {
    $pdo->exec('CREATE TABLE IF NOT EXISTS movies (
        id       INTEGER PRIMARY KEY AUTOINCREMENT,
        title    TEXT NOT NULL,
        director TEXT NOT NULL,
        "year"   INTEGER NOT NULL,
        genre    TEXT NOT NULL,
        rating   REAL NOT NULL DEFAULT 0
    )');
    $pdo->exec("INSERT INTO movies (title, director, \"year\", genre, rating) VALUES
        ('Початок',      'Крістофер Нолан', 2010, 'Фантастика', 8.8),
        ('Зелена миля',  'Френк Дарабонт',  1999, 'Драма',      9.1),
        ('Темний лицар', 'Крістофер Нолан', 2008, 'Бойовик',    9.0),
        ('Форрест Гамп', 'Роберт Земекіс',  1994, 'Драма',      8.8),
        ('Матриця',      'Вачовскі',        1999, 'Фантастика', 8.7)");
}

return $pdo;
