# DDL скрипты для проектирования EAV-хранения для базы данных кинотеатра

## Таблицы

- `eav_attribute_types`
- `movie_entities`
- `movie_entity_attributes`
- `movie_entity_attribute_values`

## Создание таблицы для хранения типов атрибутов

```postgresql
CREATE TABLE eav_attribute_types (
    id SMALLSERIAL,
    code VARCHAR(255) UNIQUE NOT NULL,
    label VARCHAR(255) NOT NULL,

    PRIMARY KEY(id)
);
```

Заполнение таблицы данными:

```postgresql
INSERT INTO eav_attribute_types
    (id, code, label)
VALUES
    (1, 'text', 'Long Text'),
    (2, 'integer', 'Number'),
    (3, 'date', 'Date'),
    (4, 'boolean', 'Boolean'),
    (5, 'varchar', 'Text')
;
```

## Создание таблицы для хранения фильмов

```postgresql
CREATE TABLE movie_entities (
    id SERIAL,
    title VARCHAR(255) NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_DATE,
    updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_DATE,

    PRIMARY KEY(id)
);
```

Заполнение таблицы данными:

```postgresql
INSERT INTO movie_entities
    (id, title)
VALUES
    (1, 'The Lord of the Rings: The Fellowship of the Ring'),
    (2, 'The Lord of the Rings: The Two Towers'),
    (3, 'The Lord of the Rings: The Return of the King')
;
```

## Создание таблицы для хранения атрибутов для сущности - фильмы

```postgresql
CREATE TABLE movie_entity_attributes (
    id SMALLSERIAL,
    type_id INTEGER NOT NULL,
    code VARCHAR(255) UNIQUE NOT NULL,
    label VARCHAR(255) NOT NULL,
    is_system BOOLEAN DEFAULT FALSE,
    is_required BOOLEAN DEFAULT FALSE,

    PRIMARY KEY(id),
    CONSTRAINT FK_MV_ENTT_ATTRS_TYPE_ID_EAV_ATTR_TPS_ID FOREIGN KEY(type_id) REFERENCES eav_attribute_types(id)
);
```

Заполнение таблицы данными:

```postgresql
INSERT INTO movie_entity_attributes
    (id, type_id, code, label, is_system, is_required)
VALUES
    (1, 1, 'review_imdb', 'Рецензия от IMDB', DEFAULT, DEFAULT),
    (2, 1, 'review_rotten_tomatos', 'Рецензия от Rotten Tomatos', DEFAULT, DEFAULT),
    (3, 4, 'has_oscar_award', 'Премия "Оскар"', DEFAULT, DEFAULT),
    (4, 3, 'release_date_worldwide', 'Дата мировой премьеры', DEFAULT, TRUE),
    (5, 3, 'release_date_russia', 'Дата премьеры в РФ', DEFAULT, DEFAULT),
    (6, 3, 'ads_start_date', 'Дата старта рекламной кампании', TRUE, DEFAULT),
    (7, 3, 'ads_end_date', 'Дата окончания рекламной кампании', TRUE, DEFAULT),
    (8, 3, 'sales_start_date', 'Дата начала продажи билетов', DEFAULT, DEFAULT),
    (9, 3, 'sales_end_date', 'Дата окончания продажи билетов', DEFAULT, DEFAULT),
    (10, 2, 'duration_in_minutes', 'Продолжительность (минуты)', DEFAULT, TRUE),
    (11, 2, 'title_in_russian', 'Русское название', DEFAULT, TRUE)
;
```

## Создание таблицы для хранения значений атрибутов для сущности - фильмы

```postgresql
CREATE TABLE movie_entity_attribute_values (
    id SERIAL,
    entity_id INTEGER NOT NULL,
    attribute_id INTEGER NOT NULL,
    value_varchar VARCHAR(255) NULL,
    value_text TEXT NULL,
    value_date DATE NULL,
    value_int INTEGER NULL,
    value_bool BOOLEAN NULL,

    PRIMARY KEY(id),
    CONSTRAINT FK_MV_ENTT_ATTR_VAL_ENTT_ID_MV_ENTTS_ID FOREIGN KEY(entity_id) REFERENCES movie_entities(id),
    CONSTRAINT FK_MV_ENTT_ATTR_VAL_ATTR_ID_MV_ENTT_ATTR_ID FOREIGN KEY(attribute_id) REFERENCES movie_entity_attributes(id)
);
```

Заполнение таблицы данными:

```postgresql
INSERT INTO movie_entity_attribute_values
    (entity_id, attribute_id, value_varchar, value_text, value_date, value_int, value_bool)
VALUES
    (1, 1, NULL, 'Очень длинная рецензия', NULL, NULL, NULL),
    (1, 2, NULL, 'Очень длинная рецензия', NULL, NULL, NULL),
    (1, 3, NULL, NULL, NULL, NULL, TRUE),
    (1, 4, NULL, NULL, '2001-12-10', NULL, NULL),
    (1, 5, NULL, NULL, '2002-03-01', NULL, NULL),
    (1, 6, NULL, NULL, '2024-09-01', NULL, NULL),
    (1, 7, NULL, NULL, '2024-10-01', NULL, NULL),
    (1, 8, NULL, NULL, '2024-09-10', NULL, NULL),
    (1, 9, NULL, NULL, '2024-10-01', NULL, NULL),
    (1, 10, NULL, NULL, NULL, 178, NULL),
    (1, 11, 'Властелин колец: Братство кольца', NULL, NULL, NULL, NULL),
    (2, 11, 'Властелин колец: Две башни', NULL, NULL, NULL, NULL),
    (2, 8, NULL, NULL, CURRENT_DATE, NULL, NULL),
    (3, 11, 'Властелин колец: Возвращение короля', NULL, NULL, NULL, NULL),
    (3, 8, NULL, NULL, CURRENT_DATE + INTERVAL '20 days', NULL, NULL)
;
```
