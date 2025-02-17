# EAVCINEMA Database Schema

## Описание

Схема базы данных `EAVCINEMA` предназначена для хранения информации о фильмах, их атрибутах, а также различных задачах и событиях, связанных с продвижением фильмов и их атрибутами. Основной принцип - использование подхода Entity-Attribute-Value (EAV), где атрибуты фильмов могут быть разнообразными и могут иметь разные типы данных.

## Таблицы

1. **films**
   - `film_id` (INT, PRIMARY KEY) — Уникальный идентификатор фильма
   - `title` (VARCHAR(255), NOT NULL) — Название фильма
   - `release_year` (INT) — Год выпуска фильма

2. **attribute_types**
   - `attribute_type_id` (INT, PRIMARY KEY) — Уникальный идентификатор типа атрибута
   - `type_name` (VARCHAR(50), NOT NULL) — Название типа атрибута (например, Текст, Логический, Дата, Изображение)

3. **attributes**
   - `attribute_id` (INT, PRIMARY KEY) — Уникальный идентификатор атрибута
   - `attribute_name` (VARCHAR(255), NOT NULL) — Название атрибута (например, Рецензия, Премия)
   - `attribute_type_id` (INT) — Идентификатор типа атрибута (ссылка на `attribute_types`)

4. **attribute_values**
   - `film_id` (INT) — Идентификатор фильма (ссылка на `films`)
   - `attribute_id` (INT) — Идентификатор атрибута (ссылка на `attributes`)
   - `value_text` (TEXT) — Для текстовых значений
   - `value_date` (DATE) — Для значений даты
   - `value_boolean` (BOOLEAN) — Для логических значений
   - `value_image` (BLOB) — Для изображений (например, для премий)
   - **PRIMARY KEY** (`film_id`, `attribute_id`) — Составной первичный ключ

5. **important_dates**
   - `film_id` (INT) — Идентификатор фильма (ссылка на `films`)
   - `attribute_id` (INT) — Идентификатор атрибута (ссылка на `attributes`)
   - `value_date` (DATE) — Дата значений
   - **PRIMARY KEY** (`film_id`, `attribute_id`) — Составной первичный ключ

6. **service_dates**
   - `film_id` (INT) — Идентификатор фильма (ссылка на `films`)
   - `attribute_id` (INT) — Идентификатор атрибута (ссылка на `attributes`)
   - `value_date` (DATE) — Дата значений
   - **PRIMARY KEY** (`film_id`, `attribute_id`) — Составной первичный ключ

## Представления

1. **marketing_data**
   Сбор данных для маркетинга, фильтруя только текстовые атрибуты (например, рецензии).

   ```sql
   CREATE VIEW marketing_data AS
   SELECT 
       f.title AS film, 
       at.attribute_name AS attribute_type,
       av.value_text AS attribute_value
   FROM films f
   JOIN attribute_values av ON f.film_id = av.film_id
   JOIN attributes at ON av.attribute_id = at.attribute_id
   WHERE at.attribute_type_id = (SELECT attribute_type_id FROM attribute_types WHERE type_name = 'Текст');
