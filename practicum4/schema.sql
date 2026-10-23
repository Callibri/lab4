CREATE DATABASE IF NOT EXISTS practicum4
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE practicum4;

CREATE TABLE IF NOT EXISTS movies (
  id       INT AUTO_INCREMENT PRIMARY KEY,
  title    VARCHAR(255)  NOT NULL,
  director VARCHAR(255)  NOT NULL,
  `year`   SMALLINT      NOT NULL,
  genre    VARCHAR(100)  NOT NULL,
  rating   DECIMAL(3,1)  NOT NULL DEFAULT 0.0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO movies (title, director, `year`, genre, rating) VALUES
  ('Початок',           'Крістофер Нолан',   2010, 'Фантастика', 8.8),
  ('Зелена миля',       'Френк Дарабонт',    1999, 'Драма',      9.1),
  ('Темний лицар',      'Крістофер Нолан',   2008, 'Бойовик',    9.0),
  ('Форрест Гамп',      'Роберт Земекіс',    1994, 'Драма',      8.8),
  ('Матриця',           'Вачовскі',          1999, 'Фантастика', 8.7);
