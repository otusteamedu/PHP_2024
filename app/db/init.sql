CREATE TABLE "news" (
                         "id" serial PRIMARY KEY,
                         "name" varchar(255) NOT NULL,
                         "category_id" integer,
                         "date" date,
                         "author" varchar(255),
                         "text" varchar
);

CREATE TABLE "category" (
                         "id" serial PRIMARY KEY,
                         "name" varchar(255)
);

CREATE TABLE "subscription" (
                                "id" serial PRIMARY KEY,
                                "category_id" integer
);

ALTER TABLE "news" ADD FOREIGN KEY ("category_id") REFERENCES "category" ("id");

ALTER TABLE "subscription" ADD FOREIGN KEY ("category_id") REFERENCES "category" ("id");

INSERT INTO "category" (name) VALUES ('Политика'), ('Спорт'), ('Юмор');