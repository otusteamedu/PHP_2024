CREATE INDEX idx_film_id ON attribute_values(film_id);
CREATE INDEX idx_attribute_id ON attribute_values(attribute_id);
CREATE INDEX idx_value_date ON attribute_values(value_date);
CREATE INDEX idx_value_int ON attribute_values(value_int);  -- Новый индекс для целых значений
