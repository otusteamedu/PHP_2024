CREATE VIEW marketing AS

select f.name as film_name, t.type as attribute_type, a.name as attribute_name,
       CASE
           WHEN v.v_date   IS NOT NULL THEN v.v_date::text
           WHEN v.v_text   IS NOT NULL THEN v.v_text
           WHEN v.v_bool   IS NOT NULL THEN v.v_bool::text
           WHEN v.v_int    IS NOT NULL THEN v.v_int::text
           WHEN v.v_float  IS NOT NULL THEN v.v_float::text
           END "value"
from films_entity as f
         inner join values v on f.id = v.entity_id
         inner join attributes a on a.id = v.attribute_id
         inner join attributes_types t on a.type = t.id