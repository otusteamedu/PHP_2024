CREATE TABLE IF NOT EXISTS films (
    id          varchar(32) UNIQUE PRIMARY KEY,
    name        text,
    cost        decimal(11,2),
    costLuxe    decimal(11,2),
    genre       text,
    description text,
    releaseDate varchar(32),
    country     varchar(32)
);

CREATE TABLE IF NOT EXISTS sessions (
    id          varchar(32) UNIQUE PRIMARY KEY,
    filmId      varchar(32),
    timeBegin   time,
    timeEnd     time,
    FOREIGN KEY (filmId) REFERENCES films(id)
);

CREATE TABLE IF NOT EXISTS seats (
    id          SERIAL UNIQUE PRIMARY KEY,
    hall        integer,
    row         integer,
    seat        integer,
    luxe        boolean
);

CREATE TABLE IF NOT EXISTS orders (
    id          SERIAL PRIMARY KEY,
    payerId     varchar(32) UNIQUE,
    sum         decimal(11,2),
    ticketCount integer,
    createTime  timestamp
);

CREATE TABLE IF NOT EXISTS tickets (
    id          SERIAL PRIMARY KEY,
    payerId     varchar(32),
    sessionId   varchar(32),
    seatId      integer,
    amount      decimal(11,2),
    FOREIGN KEY (payerId) REFERENCES orders(payerId),
    FOREIGN KEY (sessionId) REFERENCES sessions(id),
    FOREIGN KEY (seatId) REFERENCES seats(id)
);