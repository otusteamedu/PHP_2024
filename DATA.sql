INSERT INTO Movies (name)
VALUES ('Иван Васильевич меняет профессию'),
       ('Superman');

INSERT INTO Attribute_types (name)
VALUES ('text'),
       ('boolean'),
       ('date'),
       ('timestamp'),
       ('float');

INSERT INTO Attributes (attribute_type_id, name)
VALUES (1, 'рецензии'),
       (2, 'премия'),
       (3, 'важные даты'),
       (4, 'служебные даты'),
       (5, 'рейтинг');

-- Иван Васильевич меняет профессию
INSERT INTO `Values` (movie_id, attribute_id, `value_text`)
VALUES (1, 1, 'Хороший новогодний фильм');

INSERT INTO `Values` (movie_id, attribute_id, `value_boolean`)
VALUES (1, 2, TRUE);

INSERT INTO `Values` (movie_id, attribute_id, `value_date`)
VALUES (1, 3, '1973-09-17');

INSERT INTO `Values` (movie_id, attribute_id, `value_timestamp`)
VALUES (1, 4, CURRENT_TIMESTAMP);

INSERT INTO `Values` (movie_id, attribute_id, `value_float`)
VALUES (1, 5, 7.47583);

-- Superman
INSERT INTO `Values` (movie_id, attribute_id, `value_text`)
VALUES (2, 1, 'Супергеройский фильм');

INSERT INTO `Values` (movie_id, attribute_id, `value_boolean`)
VALUES (2, 2, FALSE);

INSERT INTO `Values` (movie_id, attribute_id, `value_date`)
VALUES (2, 3, '2025-07-25');

INSERT INTO `Values` (movie_id, attribute_id, `value_timestamp`)
VALUES (2, 4, CURRENT_TIMESTAMP);

INSERT INTO `Values` (movie_id, attribute_id, `value_float`)
VALUES (2, 5, 6.3847);