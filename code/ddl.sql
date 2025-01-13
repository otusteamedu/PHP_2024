-- Проверка существует ли таблица movies и её удаление
DROP TABLE IF EXISTS public.movies CASCADE;
-- Создание таблицы movies (Фильмы)
CREATE TABLE public.movies
(
    "id"   BIGSERIAL    NOT NULL primary key,
    "name" VARCHAR(100) NOT NULL
);

-- Проверка существует ли таблица attribute_types и её удаление
DROP TABLE IF EXISTS public.attribute_types CASCADE;
-- Создание таблицы attribute_types (Типы атрибутов)
CREATE TABLE public.attribute_types
(
    "id"   BIGSERIAL    NOT NULL primary key,
    "name" VARCHAR(100) NOT NULL,
    "type" VARCHAR(50)  NOT NULL
);

-- Проверка существует ли таблица attributes и её удаление
DROP TABLE IF EXISTS public.attributes CASCADE;
-- Создание таблицы attributes (Аттрибуты) + связь с таблицей (attribute_types)
CREATE TABLE public.attributes
(
    "id"                BIGSERIAL    NOT NULL primary key,
    "name"              VARCHAR(100) NOT NULL,
    "attribute_type_id" BIGINT       NOT NULL,

    CONSTRAINT public_attributes_attribute_type_id_foreign FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Создание индекса для поля attribute_type_id в таблице attributes
CREATE INDEX public_attributes_attribute_type_id_index on attributes ("attribute_type_id");

-- Проверка существует ли таблица values и её удаление
DROP TABLE IF EXISTS public.values CASCADE;
-- Создание таблицы values (Значения) + связь с таблицами (attributes, movies)
CREATE TABLE public.values
(
    "id"            BIGSERIAL NOT NULL primary key,
    "attribute_id"  BIGINT    NOT NULL,
    "movie_id"      BIGINT    NOT NULL,
    "text_value"    TEXT      NULL DEFAULT NULL,
    "boolean_value" BOOLEAN   NULL DEFAULT NULL,
    "date_value"    DATE      NULL DEFAULT NULL,
    "integer_value" INTEGER   NULL DEFAULT NULL,
    "float_value"   FLOAT     NULL DEFAULT NULL,

    CONSTRAINT public_values_attribute_id_foreign FOREIGN KEY (attribute_id) REFERENCES attributes (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT public_values_movie_id_foreign FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Создание индекса для поля attribute_id в таблице values
CREATE INDEX public_values_attribute_id_index on values ("attribute_id");
-- Создание индекса для поля movie_id в таблице values
CREATE INDEX public_values_movie_id_index on values ("movie_id");


