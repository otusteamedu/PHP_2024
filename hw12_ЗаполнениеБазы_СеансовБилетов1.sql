--Удаляем старые данные
DELETE FROM cinema_sessions;
DELETE FROM cinema_tickets;

--Заполняем на количество дней 30(примерно 27000  записей), 30*365(примерно 10 млн записей)
select fill_session_all_halls_random_films(30*365);
select fill_tickets_no_prices();
select fill_tickets_prices();
select fill_tickets_random_sold();
