TRUNCATE "years" RESTART IDENTITY CASCADE;
INSERT INTO "years" (name)
    VALUES (2020), (2021), (2022), (2023), (2024);

TRUNCATE "countries" RESTART IDENTITY CASCADE;
INSERT INTO "countries" (name)
    VALUES ('Россия'), ('Австралия'), ('США'), ('Великобритания'), ('Новая Зеландия'), ('Канада'), ('Китай');

TRUNCATE "genres" RESTART IDENTITY CASCADE;
INSERT INTO "genres" (name)
    VALUES ('фантастика'), ('боевик'), ('драма'), ('приключения'), ('комедия'), ('семейный'), ('фэнтези'), ('мультфильм'), ('мелодрама');

TRUNCATE "age_limits" RESTART IDENTITY CASCADE;
INSERT INTO "age_limits" (name)
    VALUES ('0+'), ('6+'), ('12+'), ('16+'), ('18+');

TRUNCATE "films" RESTART IDENTITY CASCADE;
INSERT INTO "films" (name, duration, age_limit, description, year_id)
    VALUES
        ('Дюна 2', 166, (SELECT id FROM age_limits WHERE name = '12+'), '', (SELECT id FROM years WHERE name = '2024')),
        ('Дэдпул и Росомаха', 128, (SELECT id FROM age_limits WHERE name = '18+'), '', (SELECT id FROM years WHERE name = '2024')),
        ('Бременские музыканты', 116, (SELECT id FROM age_limits WHERE name = '6+'), '', (SELECT id FROM years WHERE name = '2023')),
        ('Кунг-фу Панда 4', 94, (SELECT id FROM age_limits WHERE name = '6+'), '', (SELECT id FROM years WHERE name = '2024')),
        ('Мастер и Маргарита', 157, (SELECT id FROM age_limits WHERE name = '18+'), '', (SELECT id FROM years WHERE name = '2023'));

TRUNCATE "films_countries" RESTART IDENTITY CASCADE;
INSERT INTO "films_countries" (film_id, country_id)
    VALUES
        ((SELECT id FROM films WHERE name = 'Дюна 2'), (SELECT id FROM countries WHERE name = 'США')),
        ((SELECT id FROM films WHERE name = 'Дэдпул и Росомаха'), (SELECT id FROM countries WHERE name = 'США')),
        ((SELECT id FROM films WHERE name = 'Дэдпул и Росомаха'), (SELECT id FROM countries WHERE name = 'Великобритания')),
        ((SELECT id FROM films WHERE name = 'Дэдпул и Росомаха'), (SELECT id FROM countries WHERE name = 'Австралия')),
        ((SELECT id FROM films WHERE name = 'Дэдпул и Росомаха'), (SELECT id FROM countries WHERE name = 'Новая Зеландия')),
        ((SELECT id FROM films WHERE name = 'Дэдпул и Росомаха'), (SELECT id FROM countries WHERE name = 'Канада')),
        ((SELECT id FROM films WHERE name = 'Бременские музыканты'), (SELECT id FROM countries WHERE name = 'Россия')),
        ((SELECT id FROM films WHERE name = 'Кунг-фу Панда 4'), (SELECT id FROM countries WHERE name = 'США')),
        ((SELECT id FROM films WHERE name = 'Кунг-фу Панда 4'), (SELECT id FROM countries WHERE name = 'Китай')),
        ((SELECT id FROM films WHERE name = 'Мастер и Маргарита'), (SELECT id FROM countries WHERE name = 'Россия'));

TRUNCATE "films_genres" RESTART IDENTITY CASCADE;
INSERT INTO "films_genres" (film_id, genre_id)
    VALUES
        ((SELECT id FROM films WHERE name = 'Дюна 2'), (SELECT id FROM genres WHERE name = 'фантастика')),
        ((SELECT id FROM films WHERE name = 'Дюна 2'), (SELECT id FROM genres WHERE name = 'боевик')),
        ((SELECT id FROM films WHERE name = 'Дюна 2'), (SELECT id FROM genres WHERE name = 'драма')),
        ((SELECT id FROM films WHERE name = 'Дюна 2'), (SELECT id FROM genres WHERE name = 'приключения')),
        ((SELECT id FROM films WHERE name = 'Дэдпул и Росомаха'), (SELECT id FROM genres WHERE name = 'фантастика')),
        ((SELECT id FROM films WHERE name = 'Дэдпул и Росомаха'), (SELECT id FROM genres WHERE name = 'боевик')),
        ((SELECT id FROM films WHERE name = 'Дэдпул и Росомаха'), (SELECT id FROM genres WHERE name = 'комедия')),
        ((SELECT id FROM films WHERE name = 'Дэдпул и Росомаха'), (SELECT id FROM genres WHERE name = 'приключения')),
        ((SELECT id FROM films WHERE name = 'Бременские музыканты'), (SELECT id FROM genres WHERE name = 'приключения')),
        ((SELECT id FROM films WHERE name = 'Бременские музыканты'), (SELECT id FROM genres WHERE name = 'семейный')),
        ((SELECT id FROM films WHERE name = 'Бременские музыканты'), (SELECT id FROM genres WHERE name = 'фэнтези')),
        ((SELECT id FROM films WHERE name = 'Бременские музыканты'), (SELECT id FROM genres WHERE name = 'комедия')),
        ((SELECT id FROM films WHERE name = 'Кунг-фу Панда 4'), (SELECT id FROM genres WHERE name = 'мультфильм')),
        ((SELECT id FROM films WHERE name = 'Кунг-фу Панда 4'), (SELECT id FROM genres WHERE name = 'фэнтези')),
        ((SELECT id FROM films WHERE name = 'Кунг-фу Панда 4'), (SELECT id FROM genres WHERE name = 'боевик')),
        ((SELECT id FROM films WHERE name = 'Кунг-фу Панда 4'), (SELECT id FROM genres WHERE name = 'комедия')),
        ((SELECT id FROM films WHERE name = 'Кунг-фу Панда 4'), (SELECT id FROM genres WHERE name = 'приключения')),
        ((SELECT id FROM films WHERE name = 'Кунг-фу Панда 4'), (SELECT id FROM genres WHERE name = 'семейный')),
        ((SELECT id FROM films WHERE name = 'Мастер и Маргарита'), (SELECT id FROM genres WHERE name = 'драма')),
        ((SELECT id FROM films WHERE name = 'Мастер и Маргарита'), (SELECT id FROM genres WHERE name = 'фэнтези')),
        ((SELECT id FROM films WHERE name = 'Мастер и Маргарита'), (SELECT id FROM genres WHERE name = 'мелодрама'));

TRUNCATE "halls" RESTART IDENTITY CASCADE;
INSERT INTO "halls" (name, capacity)
    VALUES
        ('Зал 1', 4000),
        ('Зал 2', 120000),
        ('Зал 3', 75000);

TRUNCATE "seats_type" RESTART IDENTITY CASCADE;
INSERT INTO "seats_type" (name)
    VALUES
        ('кресло'),
        ('диван');

TRUNCATE "users" RESTART IDENTITY CASCADE;
INSERT INTO "users" (login)
    VALUES
        ('test_user@test.com');

TRUNCATE "seats" RESTART IDENTITY CASCADE;
--hall-1 200x20 = 4 000
DO $$
begin 
FOR r IN 1..20 LOOP
            FOR p IN 1..200 LOOP
                INSERT INTO seats (hall_id, "row", "place", "seat_type")
                VALUES ((SELECT id FROM halls WHERE name = 'Зал 1'), r, p, (SELECT id FROM seats_type WHERE name = 'кресло'));
            END LOOP;
        END LOOP;
END $$;

--hall-2 400x300 = 120 000
DO $$
begin 
FOR r IN 1..400 LOOP
            FOR p IN 1..300 LOOP
                INSERT INTO seats (hall_id, "row", "place", "seat_type")
                VALUES ((SELECT id FROM halls WHERE name = 'Зал 2'), r, p, (SELECT id FROM seats_type WHERE name = 'кресло'));
            END LOOP;
        END LOOP;
END $$;

--hall-3 250x300 = 75 000
DO $$
begin 
FOR r IN 1..250 LOOP
            FOR p IN 1..300 LOOP
                INSERT INTO seats (hall_id, "row", "place", "seat_type")
                VALUES ((SELECT id FROM halls WHERE name = 'Зал 3'), r, p, (SELECT id FROM seats_type WHERE name = 'кресло'));
            END LOOP;
        END LOOP;
END $$;
