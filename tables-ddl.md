# DDL скрипты для создания таблиц для управления кинотеатром

Ссылка на представление [логической модели](https://drawsql.app/teams/dev-447/diagrams/cinema)

## Создание таблицы для хранения клиентов

```sql
CREATE TABLE `customers`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `firstname` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NULL,

    PRIMARY KEY(id),
    UNIQUE (email)
);
```

## Создание таблицы для хранения фильмов

```sql
CREATE TABLE `movies`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `duration_in_minutes` INT UNSIGNED NOT NULL,
    `release_date` DATE NOT NULL,
    `production_country` VARCHAR(255) NOT NULL,

    PRIMARY KEY(id)
);
```

## Создание таблицы для хранения жанров кино

```sql
CREATE TABLE `movie_genres`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,

    PRIMARY KEY(id)
);
```

## Создание таблицы для хранения связей фильмов и жанров

```sql
CREATE TABLE `movies_genres`
(
    `movie_id` INT UNSIGNED NOT NULL,
    `genre_id` INT UNSIGNED NOT NULL,

    PRIMARY KEY(`movie_id`, `genre_id`),
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES movie_genres(id) ON DELETE CASCADE
);
```

## Создание таблицы для хранения залов кинотеатра 

```sql
CREATE TABLE `halls`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,

    PRIMARY KEY(id)
);
```

## Создание таблицы для хранения типов сидений

```sql
CREATE TABLE `seat_types`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(20, 2) NOT NULL,

    PRIMARY KEY(id)
);
```

## Создание таблицы для хранения сидений в залах

```sql
CREATE TABLE `seats`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hall_id` INT UNSIGNED NOT NULL,
    `type_id` INT UNSIGNED NOT NULL,
    `row_number` INT UNSIGNED NOT NULL,
    `seat_number` INT UNSIGNED NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE,
    FOREIGN KEY (type_id) REFERENCES seat_types(id) ON DELETE CASCADE,
    UNIQUE (`hall_id`, `row_number`, `seat_number`)
);
```

## Создание таблицы для хранения сеансов просмотра фильма

```sql
CREATE TABLE `sessions`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hall_id` INT UNSIGNED NOT NULL,
    `movie_id` INT UNSIGNED NOT NULL,
    `date` DATE NOT NULL,
    `start_time` TIME NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    UNIQUE (`hall_id`, `date`, `start_time`)
);
```

## Создание таблицы для хранения статусов заказа

```sql
CREATE TABLE `order_statuses`
(
    `code` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,

    PRIMARY KEY(code)
);
```

## Создание таблицы для хранения заказов

```sql
CREATE TABLE `orders`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `status_code` VARCHAR(255) NOT NULL,
    `customer_id` INT UNSIGNED NULL,
    `grand_total` DECIMAL(20, 2) NOT NULL,
    `date` DATE NOT NULL DEFAULT(CURRENT_DATE),

    PRIMARY KEY(id),
    FOREIGN KEY (status_code) REFERENCES order_statuses(code) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
);
```

## Создание таблицы для хранения позиций в заказе

```sql
CREATE TABLE `order_items`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` INT UNSIGNED NOT NULL,
    `session_id` INT UNSIGNED NULL,
    `seat_id` INT UNSIGNED NULL,
    `price` DECIMAL(20, 2) NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE SET NULL,
    FOREIGN KEY (seat_id) REFERENCES seats(id) ON DELETE SET NULL
);
```
