CREATE DATABASE cinema ENCODING = 'UTF8'
;

CREATE TABLE
    public.cinema_halls (
        id BIGINT NOT NULL DEFAULT NEXTVAL('cinema_halls_id_seq'::regclass),
        NAME CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
        CONSTRAINT cinema_halls_pk PRIMARY KEY (id)
    )
;

CREATE TABLE
    public.seats (
        id BIGINT NOT NULL DEFAULT NEXTVAL('seats_id_seq'::regclass),
        cinema_hall_id BIGINT NOT NULL,
        "row" CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
        "number" CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
        TYPE CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
        CONSTRAINT seats_pk PRIMARY KEY (id),
        CONSTRAINT seats_unique UNIQUE (cinema_hall_id, "row", "number"),
        CONSTRAINT seats_cinema_halls_fk FOREIGN KEY (cinema_hall_id) REFERENCES public.cinema_halls (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE RESTRICT,
        CONSTRAINT seats_check CHECK (
            TYPE::TEXT = ANY (
                ARRAY[
                    'first'::CHARACTER VARYING::TEXT,
                    'second'::CHARACTER VARYING::TEXT,
                    'third'::CHARACTER VARYING::TEXT
                ]
            )
        )
    )
;

CREATE TABLE
    public.movies (
        id BIGINT NOT NULL DEFAULT NEXTVAL('movies_id_seq'::regclass),
        NAME CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
        "from" date NOT NULL,
        "to" date NOT NULL,
        CONSTRAINT movies_pk PRIMARY KEY (id)
    )
;

CREATE TABLE
    public.prices (
        id BIGINT NOT NULL DEFAULT NEXTVAL('prices_id_seq'::regclass),
        date_from date NOT NULL,
        movie_id BIGINT NOT NULL,
        TYPE CHARACTER VARYING COLLATE pg_catalog."default" NOT NULL,
        price NUMERIC(10, 2) NOT NULL,
        CONSTRAINT prices_pk PRIMARY KEY (id),
        CONSTRAINT prices_unique UNIQUE (
            movie_id,
            TYPE,
            date_from
        ),
        CONSTRAINT prices_movies_fk FOREIGN KEY (movie_id) REFERENCES public.movies (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
        CONSTRAINT prices_check CHECK (
            TYPE::TEXT = ANY (
                ARRAY[
                    'first'::CHARACTER VARYING::TEXT,
                    'second'::CHARACTER VARYING::TEXT,
                    'third'::CHARACTER VARYING::TEXT
                ]
            )
        )
    )
;

CREATE TABLE
    public.shows (
        id BIGINT NOT NULL DEFAULT NEXTVAL('shows_id_seq'::regclass),
        movie_id BIGINT NOT NULL,
        cinema_hall_id BIGINT NOT NULL,
        "from" TIME WITHOUT TIME ZONE NOT NULL,
        "to" TIME WITHOUT TIME ZONE NOT NULL,
        CONSTRAINT shows_pk PRIMARY KEY (id),
        CONSTRAINT shows_cinema_halls_fk FOREIGN KEY (cinema_hall_id) REFERENCES public.cinema_halls (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION,
        CONSTRAINT shows_movies_fk FOREIGN KEY (movie_id) REFERENCES public.movies (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
        CONSTRAINT shows_check CHECK ("to" > "from")
    )
;

CREATE TABLE
    public.tickets (
        id BIGINT NOT NULL DEFAULT NEXTVAL('tickets_id_seq'::regclass),
        show_id BIGINT NOT NULL,
        seat_id BIGINT NOT NULL,
        is_sold BOOLEAN NOT NULL DEFAULT FALSE,
        CONSTRAINT tickets_pk PRIMARY KEY (id),
        CONSTRAINT tickets_shows_fk FOREIGN KEY (show_id) REFERENCES public.shows (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE RESTRICT
    )
;

CREATE INDEX tickets_show_id_idx ON public.tickets USING btree (show_id ASC NULLS LAST)
WITH
    (deduplicate_items = TRUE) TABLESPACE pg_default
;

CREATE TABLE
    public.sales (
        id BIGINT NOT NULL DEFAULT NEXTVAL('sales_id_seq'::regclass),
        date date NOT NULL,
        amount NUMERIC(15, 2) NOT NULL,
        ticket_id BIGINT NOT NULL,
        CONSTRAINT sales_pk PRIMARY KEY (id),
        CONSTRAINT sales_tickets_fk FOREIGN KEY (ticket_id) REFERENCES public.tickets (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE RESTRICT
    )
;

CREATE INDEX sales_date_idx ON public.sales USING btree (date ASC NULLS LAST)
WITH
    (deduplicate_items = TRUE) TABLESPACE pg_default
;

CREATE
OR REPLACE FUNCTION public.random_between (low INTEGER, high INTEGER) RETURNS INTEGER LANGUAGE 'plpgsql' COST 100 VOLATILE STRICT PARALLEL UNSAFE AS $BODY$
BEGIN
   RETURN floor(random()* (high-low + 1) + low);
END;
$BODY$
;

CREATE
OR REPLACE FUNCTION public.random_date (day_shift INTEGER) RETURNS TIMESTAMP WITHOUT TIME ZONE LANGUAGE 'plpgsql' COST 100 VOLATILE PARALLEL UNSAFE AS $BODY$
begin
  return (now() + (8 - day_shift) * INTERVAL '1 DAYS')::timestamp;
end;
$BODY$
;

CREATE
OR REPLACE FUNCTION public.random_string (LENGTH INTEGER) RETURNS TEXT LANGUAGE 'plpgsql' COST 100 VOLATILE PARALLEL UNSAFE AS $BODY$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
begin
  if length < 0 then
    raise exception 'Given length cannot be less than 0';
  end if;
  for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  end loop;
  return result;
end;
$BODY$
;