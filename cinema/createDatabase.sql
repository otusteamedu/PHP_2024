create table users(
  id serial primary key,
  name varchar,
  lastName varchar,
  phone varchar,
  email varchar
);

create table halls(
  id serial primary key,
  name varchar,
  basePrice integer default 0 not null
);

create table rows(
  id serial primary key,
  hallId integer not null references halls,
  row integer not null
);

create table seats(
  id serial primary key,
  rowId integer not null references rows,
  seat integer not null,
  extraPrice integer default 0 not null
);

create table movies(
  id serial primary key,
  name varchar not null,
  description varchar,
  duration integer default 0 not null,
  category varchar,
  origin varchar,
  releaseDate date
);

create table shows(
  id serial primary key,
  movieId integer not null references movies,
  hallId integer not null references halls,
  startAt timestamp not null,
  extraPrice integer default 0 not null,
  maxDiscount integer default 0 not null
);

create table tickets(
  id serial primary key,
  showId integer not null references shows,
  seatId integer not null references seats,
  soldPrice integer not null,
  soldAt timestamp not null,
  userId integer references users
);