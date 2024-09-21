DROP TABLE IF EXISTS "films" CASCADE;

CREATE TABLE "films" (
    "id" integer primary key,
    "name" varchar(64) NOT NULL
);

DROP TABLE IF EXISTS "attribute_types" CASCADE;

CREATE TABLE "attribute_types" (
    "id" integer primary key,
    "name" varchar(64) NOT NULL,
    "type" varchar(32) NOT NULL
);

DROP TABLE IF EXISTS "attributes" CASCADE;

CREATE TABLE "attributes" (
    "id" integer primary key,
    "name" varchar(64) NOT NULL,
    "attribute_type_id" int NOT NULL,
    CONSTRAINT "fk_attribute_type_id" FOREIGN KEY ("attribute_type_id") REFERENCES "attribute_types" ("id") ON UPDATE NO ACTION ON DELETE NO ACTION
);

DROP TABLE IF EXISTS "attribute_values" CASCADE;

CREATE TABLE "attribute_values" (
    "id" integer primary key,
    "film_id" integer NOT NULL,
    "attribute_id" integer NOT NULL,
    "value_boolean" BOOLEAN NULL DEFAULT NULL,
    "value_text" TEXT NULL DEFAULT NULL,
    "value_date" DATE NULL DEFAULT NULL,
    "value_timestamp" TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT "fk_film_id" FOREIGN KEY ("film_id") REFERENCES "films" ("id") ON UPDATE NO ACTION ON DELETE NO ACTION,
    CONSTRAINT "fk_attribute_id" FOREIGN KEY ("attribute_id") REFERENCES "attributes" ("id") ON UPDATE NO ACTION ON DELETE NO ACTION
);