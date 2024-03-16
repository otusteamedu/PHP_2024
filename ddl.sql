CREATE TABLE IF NOT EXISTS public."Films"
(
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    duration character varying(45),
    manufacturer bigint,
    director bigint,
    description character varying(255),
    rental_company bigint NOT NULL,
    age_limits bigint NOT NULL,
    actors text,
    film_links text,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Films_attributeType"
(
    id bigint NOT NULL,
    type character varying(100),
    attribute_id bigint,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Films_attribute"
(
    id bigint NOT NULL,
    film_id bigint NOT NULL,
    name character varying(200),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Films_arrtibuteValue"
(
    id bigint NOT NULL,
    value_text text,
    value_boolean boolean,
    value_datetime timestamp without time zone,
    attributetype_id bigint,
    value_int bigint,
    value_float double precision,
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public."Films_attributeType"
    ADD CONSTRAINT "fk_Films_attributeType_1" FOREIGN KEY (attribute_id)
    REFERENCES public."Films_attribute" (id) MATCH SIMPLE
    ON UPDATE CASCADE
       ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS "fki_fk_Films_attributeType_1"
    ON public."Films_attributeType"(attribute_id);


ALTER TABLE IF EXISTS public."Films_attribute"
    ADD CONSTRAINT "fk_Films_attribute_1" FOREIGN KEY (film_id)
    REFERENCES public."Films" (id) MATCH SIMPLE
    ON UPDATE CASCADE
       ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS "fki_fk_Films_attribute_1"
    ON public."Films_attribute"(film_id);


ALTER TABLE IF EXISTS public."Films_arrtibuteValue"
    ADD CONSTRAINT "fk_Films_attributeValue_1" FOREIGN KEY (attributetype_id)
    REFERENCES public."Films_attributeType" (id) MATCH SIMPLE
    ON UPDATE CASCADE
       ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS "fki_fk_Films_attributeValue_1"
    ON public."Films_arrtibuteValue"(attributetype_id);