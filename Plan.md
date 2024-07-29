1. Создание таблиц и миграций: 
    currencies (code, title, type),
    rates (cur_from, cur_to, rate_f_t, rate_t_f),
    orders (order_id, status, cur_from, cur_to, amount_from, amount_to, rate),
    balances (cur_code, balance),
    settings (cur_from_code, cur_to_code, profit)
2. Создание чистой архитектуры (создание сущностей, Use Case-ов)
3. Заполнить базу тестовыми данными, ивлекать курсы обмена при получении GET на /api и отдавать json 