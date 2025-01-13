-- View: Служебные задачи
CREATE OR REPLACE VIEW service_tasks AS
SELECT m.name      AS Фильм,
       STRING_AGG(CASE WHEN (av.value_date = CURRENT_DATE) THEN a.name || ' ' || av.value_date END,
                  ', ') AS "Актуально сегодня",
       STRING_AGG(CASE
                      WHEN (av.value_date >= (CURRENT_DATE + INTERVAL '20 DAYS'))
                          THEN a.name || ' ' || av.value_date END,
                  ', ') AS "Актуально через 20 дней"
FROM attribute_values av
         JOIN movies m ON av.movie_id = m.id
         JOIN attributes a ON av.attribute_id = a.id
         JOIN attribute_types at ON av.attribute_type_id = at.id
WHERE at.name = 'date'
GROUP BY m.id;

-- View: Маркетинговые данные
CREATE OR REPLACE VIEW all_attributes AS
SELECT m.name      AS фильм,
       at.name      AS "тип атрибута",
       a.name AS атрибут,
       CASE
           WHEN (av.value_text IS NOT NULL) THEN av.text
           WHEN (av.value_date IS NOT NULL) THEN TO_CHAR(av.value_date, 'dd-mm-yyy')
           WHEN (av.value_boolean IS NOT NULL) THEN (CASE WHEN av.value_boolean THEN 'есть' ELSE 'нет' END)
           WHEN (av.value_num IS NOT NULL) THEN TO_CHAR(av.num, 'FM99.99')
           END          AS значение
FROM attribute_values av
         JOIN movies m ON av.movie_id = m.id
         JOIN attributes a ON av.attribute_id = a.id
         JOIN attribute_types at ON av.attribute_type_id = at.id;