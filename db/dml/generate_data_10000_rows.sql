/* Заполнение таблицы countries */
INSERT INTO countries ("name")
SELECT
    random_string((1 + random()*29)::integer)
FROM generate_series(1, 100);

/* Заполнение таблицы movies */
INSERT INTO movies ("name", "country_id", "year_of_creation", "duration", "description")
SELECT
    random_string((1 + random()*29)::integer),
    random_integer(1, 100),
    random_integer(1900, 2024),
    random_duration(),
    random_string((1 + random()*200)::integer)
FROM generate_series(1, 10000);

/* Заполнение таблицы movies_attributes_types */
INSERT INTO movies_attributes_types ("name", "type")
SELECT
    random_string((1 + random()*29)::integer),
    random_attribute_type()

FROM generate_series(1, 100);

/* Заполнение таблицы movies_attributes */
INSERT INTO movies_attributes ("type_id", "name")
SELECT
    random_integer(1, 100)::bigint,
    random_string((1 + random()*29)::integer)

FROM generate_series(1, 100);

/* Заполнение таблицы movies_attributes_values */
INSERT INTO movies_attributes_values (
    "movie_id", "attribute_id", "boolean_value", "text_value", "date_value"
    )
SELECT
    random_integer(1, 10000)::bigint,
    random_integer(1, 100)::bigint,
    random() > 0.5,
    random_text_value_or_null(),
    random_date_or_null()
FROM generate_series(1, 10000);

/* Заполнение таблицы cinemas */
INSERT INTO cinemas ("name")
SELECT
    random_string((1 + random()*29)::integer)

FROM generate_series(1, 10);

/* Заполнение таблицы halls */
INSERT INTO halls ("cinema_id")
SELECT
    random_integer(1, 10)::bigint
FROM generate_series(1, 100);

/* Заполнение таблицы genres */
INSERT INTO genres ("name")
SELECT
    random_string((1 + random()*29)::integer)

FROM generate_series(1, 1000);

/* Заполнение таблицы movies_genres */
INSERT INTO movies_genres ("genre_id", "movie_id")
SELECT
    random_integer(1, 1000)::bigint,
    random_integer(1, 10000)::bigint

FROM generate_series(1, 10000);

/* Заполнение таблицы movies_sessions */
INSERT INTO movies_sessions ("hall_id", "movie_id", "scheduled_at")
SELECT
    random_integer(1, 100)::bigint,
    random_integer(1, 10000)::bigint,
    random_timestamp()
FROM generate_series(1, 1000);

/* Заполнение таблицы seats */
DO
$$
BEGIN
FOR  hall_id IN 1..100
LOOP
    FOR  seat_id IN 1..10
    LOOP
        FOR  row_id IN 1..10
        LOOP
            INSERT INTO seats ("hall_id", "seat_number", "row_number")
            VALUES (hall_id, seat_id, row_id);
        END LOOP;
    END LOOP;
END LOOP;
END;
$$;

/* Заполнение таблицы tickets */
INSERT INTO tickets ("session_id", "seat_id", "price")
SELECT
    random_integer(2, 1000)::bigint,
    random_integer(1, 10000)::bigint,
    random_integer(250, 1000)::money
FROM generate_series(1, 10000);
