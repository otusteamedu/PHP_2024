CREATE VIEW VIEW1 ("фильм", "атрибут", "задачи актуальные на сегодня", "задачи актуальные через 20 дней") AS
SELECT "Films".name, "Films_attribute".name,
    CASE WHEN "Films_attributeValue".value_datetime::date = CURRENT_DATE THEN "Films_attributeValue".value_datetime::date ELSE NULL END,
	CASE WHEN "Films_attributeValue".value_datetime::date = (CURRENT_DATE + '20 days'::interval) THEN "Films_attributeValue".value_datetime::date ELSE NULL END
FROM "Films"
INNER JOIN "Films_attribute" ON "Films".id="Films_attribute".film_id
INNER JOIN "Films_attributeType" ON "Films_attribute".id="Films_attributeType".attribute_id
INNER JOIN "Films_attributeValue" ON "Films_attributeType".id="Films_attributeValue".attributetype_id;

CREATE VIEW VIEW2 ("фильм", "тип атрибута", "атрибут", "значение") AS
SELECT "Films".name, "Films_attributeType".type, "Films_attribute".name,
    CASE WHEN "Films_attributeValue".value_text IS NOT NULL THEN "Films_attributeValue".value_text::TEXT
        WHEN "Films_attributeValue".value_boolean IS NOT NULL THEN "Films_attributeValue".value_boolean::TEXT
        WHEN "Films_attributeValue".value_datetime IS NOT NULL THEN "Films_attributeValue".value_datetime::TEXT
        WHEN "Films_attributeValue".value_int IS NOT NULL THEN "Films_attributeValue".value_int::TEXT
        WHEN "Films_attributeValue".value_float IS NOT NULL THEN "Films_attributeValue".value_float::TEXT
    END
FROM "Films"
INNER JOIN "Films_attribute" ON "Films".id="Films_attribute".film_id
INNER JOIN "Films_attributeType" ON "Films_attribute".id="Films_attributeType".attribute_id
INNER JOIN "Films_attributeValue" ON "Films_attributeType".id="Films_attributeValue".attributetype_id;
