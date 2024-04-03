create index ix_film on film using btree(id);
create index ix_attribute_type on attribute_type using btree(id);
create index ix_film_attribute on film_attribute using btree(id);
create index ix_film_value on film_value using btree(film_id, film_attribute_id);

create index ix_film_value_timestamp on film_value using btree(value_timestamp);
create index ix_film_value_varchar on film_value using btree(value_varchar);
create index ix_film_value_integer on film_value using btree(value_integer);
create index ix_film_value_float on film_value using btree(value_float);
create index ix_film_value_bool on film_value using btree(value_bool);