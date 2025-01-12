DO
$$
    DECLARE
        theatre_id INT;
        movie_id   INT;
        show_id    INT;
        rows       INT = 100; -- Кол-во билетов в таблице tickets равно rows * 100
    BEGIN
        TRUNCATE theatres, movies, shows, tickets RESTART IDENTITY CASCADE;

        INSERT INTO theatres (title, location, capacity)
        VALUES ('Grand Cinema Theatre', 'Some location', 100);
        -- Получение последнего добавленного theatre_id для foreign key
        SELECT MAX(id) INTO theatre_id FROM theatres;

        INSERT INTO movies (id, title, genre)
        SELECT gs.id,
               random_string((1 + random() * 30)::integer),
               random_string((1 + random() * 30)::integer)
        FROM generate_series(1, 10) as gs(id);
        -- Получение последнего добавленного movie_id для foreign key
        SELECT MAX(id) INTO movie_id FROM movies;

        -- Создаем rows сеансов в таблице shows
        FOR i IN 1..rows
            LOOP
                INSERT INTO shows (movie_id, theatre_id, start)
                VALUES (floor(random() * movie_id + 1), theatre_id,
                        (now()::date - 30::int + (i * INTERVAL '1 day'))::date);
            END LOOP;

        -- Получаем все идентификаторы сеансов после их создания
        FOR show_id IN SELECT id FROM shows ORDER BY id DESC
            LOOP
                FOR j IN 1..100
                    LOOP
                        INSERT INTO tickets (show_id, seat, price, available)
                        VALUES (show_id::int, j, (100 + random() * (1000 - 100))::numeric(10, 2), random() < 0.4);
                    END LOOP;
            END LOOP;
    END
$$;