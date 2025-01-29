-- Проверка существует ли таблица clients и её удаление
DROP TABLE IF EXISTS public.clients CASCADE;
-- Создание таблицы clients (Клиенты)
CREATE TABLE public.clients
(
    "id"      BIGSERIAL    NOT NULL primary key,
    "surname" VARCHAR(255) NOT NULL,
    "name"    VARCHAR(255) NOT NULL,
    "email"   VARCHAR(255) NOT NULL,
    "phone"   VARCHAR(50)  NOT NULL,
    "dob"     DATE         NOT NULL
);
