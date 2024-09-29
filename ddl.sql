CREATE TABLE movie (
	id SERIAL NOT NULL,
	name VARCHAR(50) NOT NULL,
	duration INTERVAL MINUTE NOT NULL,
	CONSTRAINT movie_pkey PRIMARY KEY(id)
);

CREATE TABLE session (
	id SERIAL NOT NULL,
	movie_id SERIAL NOT NULL,
	hall_id SERIAL NOT NULL,
	start TIMESTAMP NOT NULL,
	finish TIMESTAMP NOT NULL,
	CONSTRAINT session_pkey PRIMARY KEY(id)
);

CREATE INDEX ON session (movie_id);
CREATE INDEX ON session (hall_id);

CREATE TABLE hall (
	id SERIAL NOT NULL,
	name VARCHAR(50) NOT NULL,
	CONSTRAINT hall_pkey PRIMARY KEY(id),
	CONSTRAINT name UNIQUE(name)
);

CREATE TABLE price (
	id SERIAL NOT NULL,
	session_id SERIAL NOT NULL,
	seat_type_id SERIAL NOT NULL,
	value MONEY NOT NULL,
	CONSTRAINT price_pkey PRIMARY KEY(id)
);

CREATE INDEX ON price (session_id);
CREATE INDEX ON price (seat_type_id);

CREATE TABLE ticket (
	id SERIAL NOT NULL,
	session_id SERIAL NOT NULL,
	seat_id SERIAL NOT NULL,
	is_sold BOOLEAN NOT NULL,
	CONSTRAINT ticket_pkey PRIMARY KEY(id)
	CONSTRAINT ticket_unique UNIQUE(session_id, seat_id)
);

CREATE INDEX ON ticket (session_id);
CREATE INDEX ON ticket (seat_id);

CREATE TABLE seat_type (
	id SERIAL NOT NULL,
	name VARCHAR(50) NOT NULL,
	CONSTRAINT seat_type_pkey PRIMARY KEY(id)
);

CREATE TABLE seat (
	id SERIAL NOT NULL,
	hall_id SERIAL NOT NULL,
	horizont SMALLINT NOT NULL,
	vertical SMALLINT NOT NULL,
	seat_type_id SERIAL NOT NULL,
	CONSTRAINT seat_pkey PRIMARY KEY(id),
	CONSTRAINT seat_unique UNIQUE (hall_id, horizont, vertical)
);

CREATE INDEX ON seat (hall_id);
CREATE INDEX ON seat (seat_type_id);