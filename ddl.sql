-- Создаем фильм
CREATE TABLE movie
(
    id           SERIAL PRIMARY KEY,
    title        VARCHAR(255) NOT NULL,
    release_date DATE,
    duration     INT,
    description  TEXT,
    rating       VARCHAR(50)
);

CREATE TABLE attribute_type
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(10)  NOT NULL,
    code VARCHAR(255) NOT NULL
);

CREATE TABLE attribute
(
    id                SERIAL PRIMARY KEY,
    name              VARCHAR(255) NOT NULL,
    code              VARCHAR(255) NOT NULL,
    attribute_type_id INT REFERENCES attribute_type (id) ON DELETE CASCADE
);

CREATE TABLE attribute_value
(
    id            SERIAL PRIMARY KEY,
    value_text    TEXT,
    value_float   REAL,
    value_boolean BOOLEAN DEFAULT false NOT NULL,
    value_date    DATE,
    value_integer INTEGER,
    attribute_id  INT REFERENCES attribute (id) ON DELETE CASCADE,
    movie_id      INT REFERENCES movie (id) ON DELETE CASCADE
);


-- Заполняем стандартные данные для атрибутов
INSERT INTO attribute_type (name, type, code)
VALUES ('Рецензии', 'text', 'reviews'),
       ('Премии', 'boolean', 'awards'),
       ('Важные даты', 'date', 'important_dates'),
       ('Служебные даты', 'date', 'service_dates');

INSERT INTO attribute (name, code, attribute_type_id)
VALUES ('Рецензия критиков', 'critics_review', (SELECT id FROM attribute_type WHERE code = 'reviews')),
       ('Отзыв неизвестной киноакадемии', 'unknown_academy_review',
        (SELECT id FROM attribute_type WHERE code = 'reviews')),
       ('Оскар', 'oscar', (SELECT id FROM attribute_type WHERE code = 'awards')),
       ('Ника', 'nika', (SELECT id FROM attribute_type WHERE code = 'awards')),
       ('Мировая премьера', 'world_premiere', (SELECT id FROM attribute_type WHERE code = 'important_dates')),
       ('Премьера в РФ', 'premiere_in_russia', (SELECT id FROM attribute_type WHERE code = 'important_dates')),
       ('Дата начала продажи билетов', 'ticket_sales_start_date',
        (SELECT id FROM attribute_type WHERE code = 'service_dates')),
       ('Когда запускать рекламу на ТВ', 'when_to_launch_tv_ads',
        (SELECT id FROM attribute_type WHERE code = 'service_dates'));


-- Создаем кинотеатр
CREATE TABLE theater
(
    id      SERIAL PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL
);

CREATE TABLE hall
(
    id         SERIAL PRIMARY KEY,
    theater_id INT REFERENCES theater (id) ON DELETE CASCADE,
    name       VARCHAR(255) NOT NULL,
    capacity   INT          NOT NULL
);

CREATE TABLE seat_type
(
    id   SERIAL PRIMARY KEY,
    type VARCHAR(50) NOT NULL
);

INSERT INTO seat_type (type)
VALUES ('low'),
       ('meddle'),
       ('high'),
       ('vip');

CREATE TABLE seat
(
    id           SERIAL PRIMARY KEY,
    hall_id      INT REFERENCES hall (id) ON DELETE CASCADE,
    seat_type_id INT REFERENCES seat_type (id) ON DELETE SET NULL,
    row_number   INT NOT NULL,
    col_number   INT NOT NULL
);

CREATE TABLE session
(
    id         SERIAL PRIMARY KEY,
    movie_id   INT REFERENCES movie (id) ON DELETE CASCADE,
    hall_id    INT REFERENCES hall (id) ON DELETE CASCADE,
    start_time TIMESTAMP NOT NULL,
    end_time   TIMESTAMP NOT NULL
);

CREATE TABLE price
(
    id           SERIAL PRIMARY KEY,
    session_id   INT REFERENCES session (id) ON DELETE CASCADE,
    seat_type_id INT REFERENCES seat_type (id) ON DELETE CASCADE,
    price        DECIMAL(10, 2) NOT NULL
);

CREATE TABLE ticket
(
    id         SERIAL PRIMARY KEY,
    session_id INT REFERENCES session (id) ON DELETE CASCADE,
    seat_id    INT REFERENCES seat (id) ON DELETE CASCADE,
    price      DECIMAL(10, 2) NOT NULL,
    sold_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Служебные скрипты заполнения данными
CREATE
OR REPLACE FUNCTION random_string(length INTEGER) RETURNS text AS
$$
DECLARE
chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  RESULT
text := '';
  i
integer := 0;
BEGIN
  IF
length < 0 THEN
    raise exception 'Given length cannot be less than 0';
END IF;
FOR i IN 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
END loop;
RETURN result;
END;
$$
language plpgsql;

CREATE
OR REPLACE FUNCTION random_between(low INTEGER, high INTEGER) RETURNS INTEGER AS
$$
BEGIN
RETURN floor(random() * (high - low + 1) + low);
END;
$$
language plpgsql;

CREATE
OR REPLACE FUNCTION random_date(day_start DATE, day_end DATE) RETURNS DATE AS
$$
BEGIN
RETURN (day_start::DATE + (random() * (day_end::DATE - day_start::DATE)) * INTERVAL '1 DAY')::DATE;
END;
$$
language plpgsql;

CREATE
OR REPLACE FUNCTION random_date(day_start TIMESTAMP, day_end TIMESTAMP) RETURNS TIMESTAMP AS
$$
BEGIN
RETURN (day_start::TIMESTAMP + (random() * (day_end::TIMESTAMP - day_start::TIMESTAMP)))::TIMESTAMP;
END;
$$
language plpgsql;
