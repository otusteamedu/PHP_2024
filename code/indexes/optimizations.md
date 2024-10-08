Оптимизации бд:

### Склоняем планировщик к использованию индексов
```sql
SET random_page_cost = 1.0; 
```

### Ускоряем поиск по датам сеансов
```sql
create index idx_sessions_start_time on sessions ((start_time::date));
create index idx_sessions_end_time on sessions ((end_time::date));
```
    1. Выбор всех фильмов на сегодня (Execution Time: 58.684 ms -> 3.983 ms)
    3. Формирование афиши (фильмы, которые показывают сегодня) (Execution Time: 9.295 ms -> 1.096 ms)

### Ускоряем поиск по датам продажи
```sql
create index idx_tickets_purchased_at on tickets (purchased_at);
```
    2. Подсчёт проданных билетов за неделю (Execution Time: 6152.036 ms -> 191.993 ms)

### Индексируем места и сеансы билетов для вывода схемы зала и аналитики
```sql
create index idx_tickets_ticket_price_id_price_purchased_at on tickets (ticket_price_id, price, purchased_at);
create index concurrently idx_ticket_prices_id on ticket_prices(id);
```
    4. Поиск 3 самых прибыльных фильмов за неделю (Execution Time: 13374.227 ms -> 4995.157 ms)
    6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс (Execution Time: 0.051 ms -> 0.033 ms)

### Индексируем места и сеансы билетов для вывода схемы зала
```sql
create index idx_seats_row_number_seat_number on seats (row_number, seat_number);
```
    5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс (Execution Time: 35.067 ms -> 29.954 ms)
