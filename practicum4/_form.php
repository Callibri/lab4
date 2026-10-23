<?php
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
?>
<?php if ($errors): ?>
  <div class="err"><ul>
    <?php foreach ($errors as $e): ?><li><?= $h($e) ?></li><?php endforeach; ?>
  </ul></div>
<?php endif; ?>

<form method="post" action="<?= $h($action) ?>">
  <label for="title">Назва</label>
  <input id="title" name="title" value="<?= $h($movie['title'] ?? '') ?>" required>

  <label for="director">Режисер</label>
  <input id="director" name="director" value="<?= $h($movie['director'] ?? '') ?>" required>

  <label for="year">Рік</label>
  <input id="year" name="year" type="number" value="<?= $h($movie['year'] ?? '') ?>" required>

  <label for="genre">Жанр</label>
  <input id="genre" name="genre" value="<?= $h($movie['genre'] ?? '') ?>" required>

  <label for="rating">Рейтинг (0–10)</label>
  <input id="rating" name="rating" type="number" step="0.1" min="0" max="10"
         value="<?= $h($movie['rating'] ?? '') ?>" required>

  <p><button type="submit"><?= $h($submitLabel) ?></button>
     <a href="index.php">Скасувати</a></p>
</form>
