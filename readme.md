# База данных для кинотеатра

Логическая модель базы данных для кинотеатра включает следующие сущности:

## Сущности и их атрибуты

### 1. Genres (Жанры)
- `id` (ИД) — Первичный ключ
- `name` (Название жанра)

### 2. Directors (Режиссеры)
- `id` (ИД) — Первичный ключ
- `name` (Имя режиссера)
- `birth_date` (Дата рождения)

### 3. Actors (Актеры)
- `id` (ИД) — Первичный ключ
- `name` (Имя актера)
- `birth_date` (Дата рождения)

### 4. Movies (Фильмы)
- `id` (ИД) — Первичный ключ
- `title` (Название фильма)
- `description` (Описание фильма)
- `genre_id` (Ссылка на жанр)
- `release_date` (Дата релиза)
- `duration` (Продолжительность фильма)
- `show_time_from` (Время начала показа)
- `show_time_to` (Время окончания показа)
- `director_id` (Ссылка на режиссера)

### 5. Halls (Кинозалы)
- `id` (ИД) — Первичный ключ
- `seats_count` (Количество мест)
- `hall_type` (Тип зала)

### 6. Schedules (Расписание)
- `id` (ИД) — Первичный ключ
- `movie_id` (Ссылка на фильм)
- `hall_id` (Ссылка на кинозал)
- `show_time` (Время показа)

### 7. MovieActors (Актерский состав)
- `movie_id` (Ссылка на фильм)
- `actor_id` (Ссылка на актера)
- Составной первичный ключ (`movie_id`, `actor_id`)

### 8. Tickets (Билеты)
- `id` (ИД) — Первичный ключ
- `schedule_id` (Ссылка на расписание)
- `price` (Цена билета)
- `sold_at` (Время продажи билета)

## Связи между сущностями

- **Movies** связаны с **Genres** через `genre_id`.
- **Movies** связаны с **Directors** через `director_id`.
- **Movies** связаны с **Actors** через таблицу **MovieActors**.
- **Schedules** связывает **Movies** и **Halls** через `movie_id` и `hall_id`.
- **Tickets** связаны с **Schedules** через `schedule_id`.

## DDL-скрипты

```sql
-- Таблица жанров
CREATE TABLE Genres (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Таблица режиссеров
CREATE TABLE Directors (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    birth_date DATE
);

-- Таблица актеров
CREATE TABLE Actors (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    birth_date DATE
);

-- Таблица фильмов
CREATE TABLE Movies (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    genre_id INT REFERENCES Genres(id),
    release_date DATE,
    duration INTERVAL,
    show_time_from TIMESTAMP,
    show_time_to TIMESTAMP,
    director_id INT REFERENCES Directors(id)
);

-- Таблица кинозалов
CREATE TABLE Halls (
    id SERIAL PRIMARY KEY,
    seats_count INT NOT NULL,
    hall_type VARCHAR(100) NOT NULL
);

-- Таблица расписания
CREATE TABLE Schedules (
    id SERIAL PRIMARY KEY,
    movie_id INT REFERENCES Movies(id),
    hall_id INT REFERENCES Halls(id),
    ticket_price DECIMAL(10, 2) NOT NULL;
    show_time TIMESTAMP NOT NULL
);

-- Таблица актерского состава
CREATE TABLE MovieActors (
    movie_id INT REFERENCES Movies(id),
    actor_id INT REFERENCES Actors(id),
    PRIMARY KEY (movie_id, actor_id)
);

-- Таблица билетов
CREATE TABLE Tickets (
    id SERIAL PRIMARY KEY,
    schedule_id INT REFERENCES Schedules(id),
    price DECIMAL(10, 2) NOT NULL,
    sold_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


##SQL для нахождения самого прибыльного фильма

```sql
SELECT
    m.title AS movie_title,
    SUM(t.price) AS total_revenue
FROM
    Movies m
JOIN Schedules s ON m.id = s.movie_id
JOIN Tickets t ON s.id = t.schedule_id
GROUP BY
    m.title
ORDER BY
    total_revenue DESC
LIMIT 1;
