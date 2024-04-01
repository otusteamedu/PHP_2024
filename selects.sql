-- 1. Выбор всех фильмов на сегодня
SELECT "Cinema_sessions"."session_start_at", "Cinema_sessions"."session_end_at", "Films"."name"
FROM public."Films"
    INNER JOIN public."Cinema_sessions" ON "Films"."id" = "Cinema_sessions"."film_id"
WHERE session_start_at::date = CURRENT_DATE::date;

-- 2. Подсчёт проданных билетов за неделю
SELECT "Cinema_sessions"."film_id", count("Tikets"."id")
FROM public."Cinema_sessions"
    INNER JOIN public."Tikets" ON "Cinema_sessions"."id"="Tikets"."session_id"
WHERE session_start_at::date between (CURRENT_DATE - '7 days'::interval)::date and CURRENT_DATE::date
GROUP BY "Cinema_sessions"."film_id";

-- 3. Формирование афиши (фильмы, которые показывают сегодня)
SELECT "Films"."name", "Films"."duration", "Manufacturers"."country", concat("Directors"."first_name",' ', "Directors"."last_name") as "derector","Films"."description", "Rental_companies"."name" as "rental_company", "Films"."age_limits", "Films"."actors",
       ("Films_attribute"."name", ' ',
        CASE WHEN "Films_attributeValue"."value_text" IS NOT NULL THEN "Films_attributeValue"."value_text"::TEXT
             WHEN "Films_attributeValue"."value_boolean" IS NOT NULL THEN "Films_attributeValue"."value_boolean"::TEXT
             WHEN "Films_attributeValue"."value_datetime" IS NOT NULL THEN "Films_attributeValue"."value_datetime"::TEXT
             WHEN "Films_attributeValue"."value_int" IS NOT NULL THEN "Films_attributeValue"."value_int"::TEXT
             WHEN "Films_attributeValue"."value_float" IS NOT NULL THEN "Films_attributeValue"."value_float"::TEXT
            END) as "attributes"
FROM public."Films"
    INNER JOIN public."Cinema_sessions" ON "Films"."id"="Cinema_sessions"."film_id"
    INNER JOIN public."Manufacturers" ON "Films"."manufacturer"="Manufacturers"."id"
    INNER JOIN public."Directors" ON "Films"."director"="Directors"."id"
    INNER JOIN public."Rental_companies" ON "Films"."rental_company"="Rental_companies"."id"
    INNER JOIN public."Films_attribute" ON "Films"."id"="Films_attribute"."film_id"
    INNER JOIN public."Films_attributeType" ON "Films_attribute"."id"="Films_attributeType"."attribute_id"
    INNER JOIN public."Films_attributeValue" ON "Films_attributeType"."id"="Films_attributeValue"."attributetype_id"
WHERE session_start_at::date = CURRENT_DATE::date
GROUP BY "Films"."name", "Films"."duration", "Manufacturers"."country", "Directors"."first_name", "Directors"."last_name", "Films"."description", "Rental_companies"."name", "Films"."age_limits", "Films"."actors", "Cinema_sessions"."film_id", "Films"."description", "Films"."age_limits", "Films"."actors", "attributes";

-- 4. Поиск 3 самых прибыльных фильмов за неделю
SELECT "Cinema_sessions"."film_id", sum("Tikets"."price")
FROM public."Cinema_sessions"
    INNER JOIN public."Tikets" ON "Cinema_sessions"."id"="Tikets"."session_id"
WHERE session_start_at::date between (CURRENT_DATE - '7 days'::interval)::date and CURRENT_DATE::date
GROUP BY "Cinema_sessions"."film_id"
ORDER BY sum("Tikets"."price") DESC
LIMIT 3;

-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT "Cinema_halls"."name", "Scheme_halls"."series", "Scheme_halls"."seat", "Scheme_halls"."status" FROM public."Cinema_halls"
    INNER JOIN public."Scheme_halls" ON "Cinema_halls"."id"="Scheme_halls"."hall_id"
    INNER JOIN public."Cinema_sessions" ON "Scheme_halls"."hall_id"="Cinema_sessions"."cinema_hall_id"
    INNER JOIN public."Tikets" ON "Cinema_sessions"."id"="Tikets"."session_id"
WHERE "Cinema_sessions"."cinema_hall_id"= (SELECT "Cinema_sessions"."cinema_hall_id" FROM public."Cinema_sessions" WHERE "Cinema_sessions"."id" = 6)
GROUP BY "Cinema_halls"."name", "Scheme_halls"."series", "Scheme_halls"."seat", "Scheme_halls"."status"
ORDER BY "Scheme_halls"."seat";

-- 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
SELECT min("Tikets"."price"),max("Tikets"."price") FROM "Tikets" WHERE "Tikets"."session_id" = 6;
