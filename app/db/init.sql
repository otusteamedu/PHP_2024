CREATE TABLE "message" (
    "id" serial PRIMARY KEY,
    "status_id" integer NOT NULL,
    "message" varchar(255) NOT NULL
);

CREATE TABLE "status" (
  "id" serial PRIMARY KEY,
  "name" varchar(255) NOT NULL
);

ALTER TABLE "message" ADD FOREIGN KEY ("status_id") REFERENCES "status" ("id");

INSERT INTO status (name)  VALUES ('Создано'), ('Загружено'), ('Выполнено')