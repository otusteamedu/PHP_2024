BEGIN;

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

CREATE TABLE IF NOT EXISTS public."Genres"
(
    id bigint NOT NULL,
    name character varying(100),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Cinema_halls"
(
    id bigint NOT NULL,
    name character varying(45),
    effects bigint NOT NULL,
    seats_count bigint,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Manufacturers"
(
    id bigint NOT NULL,
    country character varying(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Cinema_sessions"
(
    id bigint NOT NULL,
    session_start_at timestamp without time zone,
    session_end_at timestamp without time zone,
    film_id bigint NOT NULL,
    cinema_hall_id bigint NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT id UNIQUE (id)
);

CREATE TABLE IF NOT EXISTS public."Directors"
(
    id bigint NOT NULL,
    first_name character varying(45),
    last_nema character varying(45),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Effects"
(
    id bigint NOT NULL,
    name character varying(45) NOT NULL,
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
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Films_Genres"
(
    id bigint NOT NULL,
    film_id bigint,
    genre_id bigint,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Prices"
(
    id bigint NOT NULL,
    film_id bigint NOT NULL,
    base_price money,
    night_price money,
    day_price money,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Rental_companies"
(
    id bigint NOT NULL,
    name character varying(100) NOT NULL,
    phone character varying(45) NOT NULL,
    email character varying(45),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Scheme_halls"
(
    id bigint NOT NULL,
    hall_id bigint,
    series bigint NOT NULL,
    seat bigint NOT NULL,
    status boolean,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public."Tikets"
(
    id bigint NOT NULL,
    session_id bigint NOT NULL,
    price money,
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public."Films"
    ADD CONSTRAINT fk_films_1 FOREIGN KEY (rental_company)
    REFERENCES public."Rental_companies" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS fki_fk_films_1
    ON public."Films"(rental_company);


ALTER TABLE IF EXISTS public."Films"
    ADD CONSTRAINT fk_films_2 FOREIGN KEY (manufacturer)
    REFERENCES public."Manufacturers" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS fki_fk_films_2
    ON public."Films"(manufacturer);


ALTER TABLE IF EXISTS public."Films"
    ADD CONSTRAINT fk_films_3 FOREIGN KEY (director)
    REFERENCES public."Directors" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS fki_fk_films_3
    ON public."Films"(director);


ALTER TABLE IF EXISTS public."Cinema_halls"
    ADD CONSTRAINT "fk_Cinema_halls_1" FOREIGN KEY (effects)
    REFERENCES public."Effects" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS "fki_fk_Cinema_halls_1"
    ON public."Cinema_halls"(effects);


ALTER TABLE IF EXISTS public."Cinema_sessions"
    ADD CONSTRAINT "fk_Cinema_session_1" FOREIGN KEY (film_id)
    REFERENCES public."Films" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS "fki_fk_Cinema_session_1"
    ON public."Cinema_sessions"(film_id);


ALTER TABLE IF EXISTS public."Cinema_sessions"
    ADD CONSTRAINT "fk_Cinema_session_2" FOREIGN KEY (cinema_hall_id)
    REFERENCES public."Cinema_halls" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS "fki_fk_Cinema_session_2"
    ON public."Cinema_sessions"(cinema_hall_id);


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


ALTER TABLE IF EXISTS public."Films_Genres"
    ADD CONSTRAINT "fk_Films_Genres_1" FOREIGN KEY (genre_id)
    REFERENCES public."Genres" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS "fki_fk_Films_Genres_1"
    ON public."Films_Genres"(genre_id);


ALTER TABLE IF EXISTS public."Films_Genres"
    ADD CONSTRAINT "fk_Films_Genres_2" FOREIGN KEY (film_id)
    REFERENCES public."Films" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS "fki_fk_Films_Genres_2"
    ON public."Films_Genres"(film_id);


ALTER TABLE IF EXISTS public."Prices"
    ADD CONSTRAINT fk_prices_1 FOREIGN KEY (film_id)
    REFERENCES public."Films" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS fki_fk_prices_1
    ON public."Prices"(film_id);


ALTER TABLE IF EXISTS public."Scheme_halls"
    ADD CONSTRAINT "fk_Scheme_halls_1" FOREIGN KEY (hall_id)
    REFERENCES public."Cinema_halls" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS "fki_fk_Scheme_halls_1"
    ON public."Scheme_halls"(hall_id);


ALTER TABLE IF EXISTS public."Tikets"
    ADD CONSTRAINT "fk_Tikets_1" FOREIGN KEY (session_id)
    REFERENCES public."Cinema_sessions" (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE
    NOT VALID;
CREATE INDEX IF NOT EXISTS "fki_fk_Tikets_1"
    ON public."Tikets"(session_id);

END;
