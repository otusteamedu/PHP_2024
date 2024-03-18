-- view служебных задач
CREATE VIEW service_task AS
SELECT
	mv.name as film,
	ma.name as attribute_name,
	CASE
		WHEN date_value::date = CURRENT_DATE
		THEN date_value
	ELSE NULL
	END today_task,
	CASE
		WHEN date_value::date <= (CURRENT_DATE + '20 days'::interval)
		THEN date_value
	ELSE NULL
	END twenty_days_interval_task
FROM movies_attributes_values mav
JOIN movies_attributes ma
    ON ma.id = mav.attribute_id
JOIN movies_attributes_types mat
    ON ma.type_id = mat.id AND mat.id = 4
JOIN movies mv
    ON mv.id = mav.movie_id;

-- View сборки данных для маркетинга в форме
CREATE VIEW movies_view (film, attribute_name, attribute_type, value) AS
SELECT
    mv.name,
    ma.name,
    mat.type,
    CASE
		WHEN mav.date_value IS NOT NULL THEN CAST (mav.date_value as text)
		WHEN mav.float_value IS NOT NULL THEN CAST (mav.float_value as text)
		WHEN mav.text_value IS NOT NULL THEN mav.text_value
		WHEN mav.boolean_value IS NOT NULL THEN CAST (mav.boolean_value as text)
	END as value
FROM movies mv
LEFT JOIN movies_attributes_values mav
    ON mav.movie_id = mv.id
LEFT JOIN movies_attributes ma
    ON ma.id = mav.attribute_id
LEFT JOIN movies_attributes_types mat
    ON ma.type_id = mat.id
ORDER BY mv.name;