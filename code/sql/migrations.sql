create table if not exists movie
(
    id
    serial
    primary
    key,
    title
    varchar
(
    255
) unique
    );
create index if not exists ix_movie_id on movie using hash(id);

create table if not exists attribute_type
(
    id
    serial
    primary
    key,
    type_name
    varchar
(
    255
) unique
    );
create index if not exists ix_attribute_type_id on attribute_type using hash(id);

create table if not exists attribute
(
    id
    serial
    primary
    key,
    title
    varchar
(
    255
) unique,
    name varchar
(
    255
) unique,
    type_id integer references attribute_type
(
    id
)
    );
create index if not exists ix_attribute_id on attribute using hash(id);

create table if not exists attribute_value
(
    id
    serial
    primary
    key,
    attribute_id
    integer
    references
    attribute
(
    id
),
    movie_id integer references movie
(
    id
),
    text_value text DEFAULT NULL,
    bool_value bool DEFAULT NULL,
    timestamp_value timestamp DEFAULT NULL,
    float_value numeric DEFAULT NULL
    );
create index if not exists ix_attribute_value_movie on attribute_value using hash (movie_id);
create index if not exists ix_attribute_value_attribute on attribute_value using hash (attribute_id);
create index if not exists ix_attribute_value_timestamp_value on attribute_value (timestamp_value);
