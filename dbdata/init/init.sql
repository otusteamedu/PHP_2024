CREATE TABLE IF NOT EXISTS users (
                                     id bigint PRIMARY KEY AUTO_INCREMENT,
                                     first_name varchar(255),
                                     last_name varchar(255),
                                     birthdate date
);

CREATE TABLE IF NOT EXISTS posts (
                                     id bigint PRIMARY KEY AUTO_INCREMENT,
                                     user_id bigint REFERENCES users (id),
                                     content text
);

/* Заполнение таблицы users */
INSERT INTO users (first_name, last_name, birthdate)
values
    ('some first name', 'some last name', DATE_SUB(NOW(), INTERVAL (FLOOR((RAND() * 30) + 1)) YEAR)),
    ('some first nameq', 'some last name', DATE_SUB(NOW(), INTERVAL (FLOOR((RAND() * 30) + 1)) YEAR)),
    ('some first name', 'some last name', DATE_SUB(NOW(), INTERVAL (FLOOR((RAND() * 30) + 1)) YEAR)),
    ('some first name', 'some last name', DATE_SUB(NOW(), INTERVAL (FLOOR((RAND() * 30) + 1)) YEAR)),
    ('some first name', 'some last name', DATE_SUB(NOW(), INTERVAL (FLOOR((RAND() * 30) + 1)) YEAR)),
    ('some first name', 'some last name', DATE_SUB(NOW(), INTERVAL (FLOOR((RAND() * 30) + 1)) YEAR)),
    ('some first name', 'some last name', DATE_SUB(NOW(), INTERVAL (FLOOR((RAND() * 30) + 1)) YEAR)),
    ('some first name', 'some last name', DATE_SUB(NOW(), INTERVAL (FLOOR((RAND() * 30) + 1)) YEAR)),
    ('some first name', 'some last name', DATE_SUB(NOW(), INTERVAL (FLOOR((RAND() * 30) + 1)) YEAR));

/* Заполнение таблицы posts */
INSERT INTO posts (user_id, content)
values
    (FLOOR((RAND() * 9) + 1), 'some post'),
    (FLOOR((RAND() * 9) + 1), 'some post'),
    (FLOOR((RAND() * 9) + 1), 'some post'),
    (FLOOR((RAND() * 9) + 1), 'some post'),
    (FLOOR((RAND() * 9) + 1), 'some post'),
    (FLOOR((RAND() * 9) + 1), 'some post'),
    (FLOOR((RAND() * 9) + 1), 'some post'),
    (FLOOR((RAND() * 9) + 1), 'some post'),
    (FLOOR((RAND() * 9) + 1), 'some post'),
    (FLOOR((RAND() * 9) + 1), 'some post');
