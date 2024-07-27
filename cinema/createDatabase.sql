create table tickets(
  id serial primary key,
  showId integer not null,
  seatId integer not null,
  soldPrice integer not null,
  soldAt timestamp not null
);

create table shows(
  id serial primary key,
  movieId integer not null,
  hallId integer not null,
  startAt timestamp not null,
  extraPrice integer default 0 not null,
  maxDiscount integer default 0 not null
);

create table movies(
  id serial primary key,
  name varchar not null,
  duration integer default 0 not null,
  category varchar,
  origin varchar,
  releaseDate date
);

create table seats(
  id serial primary key,
  rowId integer not null,
  seat integer not null,
  extraPrice integer default 0 not null
);

create table rows(
  id serial primary key,
  hallId integer not null,
  row integer not null
);

create table halls(
  id serial primary key,
  name varchar,
  basePrice integer default 0 not null
);
