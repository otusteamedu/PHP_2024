Оптимизации бд:

### Склоняем планировщик к использованию индексов
```sql
SET random_page_cost = 1.0; 
```

### Ускоряем поиск по датам сеансов
```sql
create index idx_tickets_soldAt on tickets (soldAt) where soldAt is not null;
```
    1. Выбор всех фильмов на сегодня (Execution Time: 131.951 ms -> 0.087 ms)
    3. Формирование афиши (фильмы, которые показывают сегодня) (Execution Time: 134.460 ms -> 0.102 ms)

### Ускоряем поиск по датам продажи
```sql
create index idx_tickets_soldAt on tickets (soldAt) where soldAt is not null;
```
    2. Подсчёт проданных билетов за неделю (Execution Time: 244.918 ms -> 79.475 ms)

### Индексируем места и сеансы билетов для вывода схемы зала и аналитики
```sql
create index idx_tickets_showId_soldPrice_soldAt on tickets (showId, soldPrice, soldAt);
```
    4. Поиск 3 самых прибыльных фильмов за неделю (Execution Time: 585.159 ms -> 256.760 ms)
    6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс (Execution Time: 71.677 ms -> 0.069 ms)

### Индексируем места и сеансы билетов для вывода схемы зала
```sql
create index idx_tickets_showId_seatId on tickets (showId, seatId);
```
    5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс (Execution Time: 67.745 ms -> 2.092 ms)
