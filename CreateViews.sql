create view public.view_tasks_templete(film, task, date_task) as
SELECT f.name        AS film,
       fa.name       AS task,
       fv.value_date AS date_task
FROM films_values fv
         LEFT JOIN films f ON f.uuid = fv.uuid_film
         LEFT JOIN films_attributes fa ON fa.uuid = fv.uuid_attribite
WHERE fv.value_date >= (now() - '34 years'::interval)
ORDER BY fv.value_date;

alter table public.view_tasks_templete
    owner to postgres;

create view public.view_tasks_today(film, task, date_task) as
SELECT f.name        AS film,
       fa.name       AS task,
       fv.value_date AS date_task
FROM films_values fv
         LEFT JOIN films f ON f.uuid = fv.uuid_film
         LEFT JOIN films_attributes fa ON fa.uuid = fv.uuid_attribite
WHERE fv.value_date >= now();

alter table public.view_tasks_today
    owner to postgres;

create view public.view_tasks_after_20days(film, task, date_task) as
SELECT f.name        AS film,
       fa.name       AS task,
       fv.value_date AS date_task
FROM films_values fv
         LEFT JOIN films f ON f.uuid = fv.uuid_film
         LEFT JOIN films_attributes fa ON fa.uuid = fv.uuid_attribite
WHERE fv.value_date >= (now() + '20 days'::interval)
ORDER BY fv.value_date;

alter table public.view_tasks_after_20days
    owner to postgres;

create view public.view_marketing(film, type, task, value_task, str_task, date_task, decimal_tsk) as
SELECT f.name           AS film,
       fta.name         AS type,
       fa.name          AS task,
       CASE
           WHEN fv.value_str IS NULL THEN
               CASE
                   WHEN fv.value_date IS NULL THEN fv.value_decimal::character varying
                   ELSE fv.value_date::character varying
                   END
           ELSE fv.value_str
           END          AS value_task,
       fv.value_str     AS str_task,
       fv.value_date    AS date_task,
       fv.value_decimal AS decimal_tsk
FROM films_values fv
         LEFT JOIN films f ON f.uuid = fv.uuid_film
         LEFT JOIN films_attributes fa ON fa.uuid = fv.uuid_attribite
         LEFT JOIN films_types_attributes fta ON fta.uuid = fa.uuid_type
ORDER BY fv.value_date;

alter table public.view_marketing
    owner to postgres;

