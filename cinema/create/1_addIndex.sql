create index idx_tickets_soldAt on tickets (soldAt);

create index idx_shows_startAt_date on shows ((startAt::date));

create index idx_tickets_showId_soldPrice_soldAt on tickets (showId, soldPrice, soldAt);

create index idx_tickets_showId_seatId on tickets (showId, seatId);