create table users(
  id serial primary key,
  name varchar not null,
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

create table attribute_types(
  id serial primary key,
  type varchar not null
);

create table attributes(
  id serial primary key,
  name varchar not null,
  typeId integer not null references attribute_types
);

create table movie_attributes(
  id serial primary key,
  movieId integer not null references movies,
  attributeId integer not null references attributes,
  value_boolean boolean,
  value_integer integer,
  value_float float,
  value_date date,
  value_varchar varchar
);

create index on movie_attributes(movieId);
create index on movie_attributes(attributeId);
