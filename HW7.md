# Схема данных для системы управления кинотеатром

https://drawsql.app/teams/dev-280/diagrams/hw7

## DDL

```sql
CREATE TABLE `movie`
(
    `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title`    VARCHAR(100) NOT NULL,
    `duration` INT          NOT NULL
);
CREATE TABLE `customer`
(
    `id`    INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`  VARCHAR(100) NOT NULL,
    `phone` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL
);
CREATE TABLE `order_ticket`
(
    `order_id`  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ticket_id` INT NOT NULL
);
CREATE TABLE `auditorium`
(
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL
);
CREATE TABLE `screening`
(
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `movie_id`      INT       NOT NULL,
    `auditorium_id` INT       NOT NULL,
    `start_time`    TIMESTAMP NOT NULL
);
ALTER TABLE
    `screening`
    ADD INDEX `screening_movie_id_index`(`movie_id`);
ALTER TABLE
    `screening`
    ADD INDEX `screening_auditorium_id_index`(`auditorium_id`);
CREATE TABLE `ticket`
(
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `screening_id` INT NOT NULL,
    `seat_id`      INT NOT NULL
);
CREATE TABLE `order`
(
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT       NOT NULL,
    `created_at`  TIMESTAMP NOT NULL
);
CREATE TABLE `seat`
(
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `auditorium_id` INT NOT NULL,
    `row_number`    INT NOT NULL,
    `seat_number`   INT NOT NULL,
    `type_id`       INT NOT NULL
);
CREATE TABLE `type`
(
    `id`    INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`  VARCHAR(100) NOT NULL,
    `price` INT          NOT NULL
);
ALTER TABLE
    `screening`
    ADD CONSTRAINT `screening_auditorium_id_foreign` FOREIGN KEY (`auditorium_id`) REFERENCES `auditorium` (`id`);
ALTER TABLE
    `seat`
    ADD CONSTRAINT `seat_auditorium_id_foreign` FOREIGN KEY (`auditorium_id`) REFERENCES `auditorium` (`id`);
ALTER TABLE
    `seat`
    ADD CONSTRAINT `seat_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);
ALTER TABLE
    `order_ticket`
    ADD CONSTRAINT `order_ticket_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);
ALTER TABLE
    `screening`
    ADD CONSTRAINT `screening_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`);
ALTER TABLE
    `ticket`
    ADD CONSTRAINT `ticket_screening_id_foreign` FOREIGN KEY (`screening_id`) REFERENCES `screening` (`id`);
ALTER TABLE
    `order_ticket`
    ADD CONSTRAINT `order_ticket_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`);
ALTER TABLE
    `ticket`
    ADD CONSTRAINT `ticket_seat_id_foreign` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`id`);
ALTER TABLE
    `order`
    ADD CONSTRAINT `order_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);
```

## SQL для нахождения самого прибыльного фильма

```sql
SELECT m.title       AS MovieTitle,
       SUM(ty.price) AS TotalRevenue
FROM movie m
         JOIN
     screening s ON m.id = s.movie_id
         JOIN
     ticket ti ON s.id = ti.screening_id
         JOIN
     order_ticket ot ON ti.id = ot.ticket_id
         JOIN
     `order` o ON ot.order_id = o.id
         JOIN
     seat se ON ti.seat_id = se.id
         JOIN
     type ty ON se.type_id = ty.id
GROUP BY m.id
ORDER BY TotalRevenue DESC LIMIT 1;
```
