-- create
DROP TABLE IF EXISTS "films" CASCADE;

CREATE TABLE "films" (
  id SERIAL PRIMARY KEY,
  name varchar(255) NOT NULL
);

DROP TABLE IF EXISTS "attribute_type" CASCADE;

CREATE TABLE "attribute_type" (
  id SERIAL PRIMARY KEY,
  name varchar(255) NOT NULL,
  data_type varchar(30) NOT NULL
);

DROP TABLE IF EXISTS "attribute" CASCADE;

CREATE TABLE "attribute" (
  id SERIAL PRIMARY KEY,
  name varchar(255) NOT NULL,
  attribute_type_id int NOT NULL,
  FOREIGN KEY ("attribute_type_id") REFERENCES "attribute_type"("id")
);

DROP TABLE IF EXISTS "attribute_value" CASCADE;

CREATE TABLE "attribute_value" (
  id SERIAL PRIMARY KEY,
  film_id int not null,
  attribute_id int not null,
  value_text text null,
  value_boolean boolean null,
  value_date date null,
  value_timestamp timestamp null,
  value_int int null,
  value_float float null,
  FOREIGN KEY ("film_id") REFERENCES "films"("id"),
  FOREIGN KEY ("attribute_id") REFERENCES "attribute"("id")
);