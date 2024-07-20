/**
  Можно установить индекс на дату, так как она обладает большой селективностью.
  Но я бы изменил запрос на where purchased_at, вместо where date(purchased_at) так же, и индекс был бы обычным,
  а не функциональным.
 */
CREATE INDEX idx_tickets_purchased_at_date ON tickets (DATE(purchased_at));
