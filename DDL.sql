CREATE TABLE IF NOT EXISTS films (
    id          varchar(32) UNIQUE PRIMARY KEY,
    name        text,
    cost        decimal(11,2),
    costLuxe    decimal(11,2)
);

CREATE TABLE IF NOT EXISTS sessions (
    id          varchar(32) UNIQUE PRIMARY KEY,
    filmId      varchar(32),
    time        time,
    FOREIGN KEY (filmId) REFERENCES films(id)
);

CREATE TABLE IF NOT EXISTS seats (
    id          SERIAL UNIQUE PRIMARY KEY,
    hall        integer,
    row         integer,
    seat        integer,
    luxe        boolean,
    booked      boolean DEFAULT false
);

CREATE TABLE IF NOT EXISTS payers (
    id          varchar(32) UNIQUE PRIMARY KEY,
    ticketCount integer
);

CREATE TABLE IF NOT EXISTS tickets (
    id          integer UNIQUE PRIMARY KEY,
    payerId     varchar(32),
    sessionId   varchar(32),
    seatId      integer,
    amount      decimal(11,2),
    FOREIGN KEY (payerId) REFERENCES payers(id),
    FOREIGN KEY (sessionId) REFERENCES sessions(id),
    FOREIGN KEY (seatId) REFERENCES seats(id)
);

CREATE TABLE IF NOT EXISTS orders (
    id          integer UNIQUE PRIMARY KEY,
    payerId     varchar(32),
    sum         decimal(11,2),
    createTime   timestamp,
    FOREIGN KEY (payerId) REFERENCES payers(id)
);

