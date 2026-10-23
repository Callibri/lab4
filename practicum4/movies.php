<?php
declare(strict_types=1);

/** SELECT * FROM movies */
function listMovies(PDO $pdo): array
{
    return $pdo->query('SELECT * FROM movies ORDER BY id')->fetchAll();
}

function findMovie(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM movies WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->fetch() ?: null;
}

function findByGenre(PDO $pdo, string $genre): array
{
    $stmt = $pdo->prepare('SELECT * FROM movies WHERE genre = :genre');
    $stmt->execute([':genre' => $genre]);
    return $stmt->fetchAll();
}

function topRated(PDO $pdo, int $limit): array
{
    $stmt = $pdo->prepare('SELECT * FROM movies ORDER BY rating DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function addMovie(PDO $pdo, array $m): int
{
    $stmt = $pdo->prepare(
        'INSERT INTO movies (title, director, "year", genre, rating)
         VALUES (:title, :director, :year, :genre, :rating)'
    );
    $stmt->execute([
        ':title'    => $m['title'],
        ':director' => $m['director'],
        ':year'     => $m['year'],
        ':genre'    => $m['genre'],
        ':rating'   => $m['rating'],
    ]);
    return (int)$pdo->lastInsertId();
}

function updateMovie(PDO $pdo, int $id, array $m): int
{
    $stmt = $pdo->prepare(
        'UPDATE movies
            SET title = :title, director = :director, "year" = :year,
                genre = :genre, rating = :rating
          WHERE id = :id'
    );
    $stmt->execute([
        ':title'    => $m['title'],
        ':director' => $m['director'],
        ':year'     => $m['year'],
        ':genre'    => $m['genre'],
        ':rating'   => $m['rating'],
        ':id'       => $id,
    ]);
    return $stmt->rowCount();
}

function deleteMovie(PDO $pdo, int $id): int
{
    $stmt = $pdo->prepare('DELETE FROM movies WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->rowCount();
}

function validateMovie(array $in): array
{
    $data = [
        'title'    => trim((string)($in['title'] ?? '')),
        'director' => trim((string)($in['director'] ?? '')),
        'year'     => trim((string)($in['year'] ?? '')),
        'genre'    => trim((string)($in['genre'] ?? '')),
        'rating'   => trim((string)($in['rating'] ?? '')),
    ];
    $errors = [];

    foreach (['title' => 'Назва', 'director' => 'Режисер', 'genre' => 'Жанр'] as $f => $label) {
        if ($data[$f] === '') {
            $errors[] = "$label обов'язкова.";
        } elseif (strlen($data[$f]) > 255) {
            $errors[] = "$label задовга.";
        }
    }
    $maxYear = (int)date('Y') + 5;
    if (filter_var($data['year'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1888, 'max_range' => $maxYear]]) === false) {
        $errors[] = "Рік має бути цілим числом від 1888 до $maxYear.";
    }
    $data['rating'] = str_replace(',', '.', $data['rating']);
    if (!is_numeric($data['rating']) || (float)$data['rating'] < 0 || (float)$data['rating'] > 10) {
        $errors[] = 'Рейтинг має бути числом від 0 до 10.';
    }
    return [$data, $errors];
}
