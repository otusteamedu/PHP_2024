# SQL скрипт для нахождения самого прибыльного фильма

```sql
SELECT
    `movies`.`name` AS `movie`,
    SUM(`order_items`.`price`) AS `revenue`
FROM
    `movies`
    JOIN `sessions` ON `movies`.`id` = `sessions`.`movie_id`
    JOIN `order_items` ON `sessions`.`id` = `order_items`.`session_id`
    JOIN `orders` ON `order_items`.`order_id` = `orders`.`id`
WHERE
    `orders`.`status_code` = "completed"
GROUP BY
    `movies`.`id`
ORDER BY
    `revenue` DESC
LIMIT 1;
```
