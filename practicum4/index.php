<?php
declare(strict_types=1);
$pdo = require_once __DIR__ . '/db.php';
require_once __DIR__ . '/movies.php';

$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');

$genre = trim((string)($_GET['genre'] ?? ''));
$top   = (int)($_GET['top'] ?? 0);

if ($genre !== '') {
    $title  = 'Фільми жанру: ' . $genre;
    $movies = findByGenre($pdo, $genre);
} elseif ($top > 0) {
    $title  = "Топ-$top за рейтингом";
    $movies = topRated($pdo, $top);
} else {
    $title  = 'Усі фільми';
    $movies = listMovies($pdo);
}

require __DIR__ . '/_header.php';
?>
<h1>Кінотека</h1>

<form method="get" action="index.php">
  <input name="genre" placeholder="Жанр, напр. Драма" value="<?= $h($genre) ?>" style="width:220px">
  <button type="submit">Знайти за жанром</button>
  <a href="index.php?top=3">Топ-3</a> ·
  <a href="index.php?top=5">Топ-5</a> ·
  <a href="index.php">Усі</a>
</form>

<h2><?= $h($title) ?></h2>
<p><a href="add.php">+ Додати фільм</a></p>

<table>
  <tr><th>ID</th><th>Назва</th><th>Режисер</th><th>Рік</th><th>Жанр</th><th>Рейтинг</th><th>Дії</th></tr>
  <?php foreach ($movies as $m): ?>
    <tr>
      <td><?= $h($m['id']) ?></td>
      <td><?= $h($m['title']) ?></td>
      <td><?= $h($m['director']) ?></td>
      <td><?= $h($m['year']) ?></td>
      <td><?= $h($m['genre']) ?></td>
      <td><?= $h($m['rating']) ?></td>
      <td>
        <a href="edit.php?id=<?= (int)$m['id'] ?>">Редагувати</a> |
        <form class="inline" method="post" action="delete.php"
              onsubmit="return confirm('Видалити фільм «<?= $h(addslashes($m['title'])) ?>»?');">
          <input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
          <button class="link" type="submit">Видалити</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$movies): ?>
    <tr><td colspan="7">Нічого не знайдено.</td></tr>
  <?php endif; ?>
</table>
<?php require __DIR__ . '/_footer.php';
