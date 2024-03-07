CREATE
OR REPLACE FUNCTION eliminate_overlapping_sessions () RETURNS TRIGGER AS $$
BEGIN
  IF EXISTS (
    SELECT 1
    FROM sessions ss
    WHERE ss.hall_id = NEW.hall_id
    AND tsrange(ss.start_time, ss.end_time) && tsrange(NEW.start_time, NEW.end_time)
    AND ss.session_id <> NEW.session_id
  ) THEN
    RAISE EXCEPTION 'Screening overlaps with existing screenings in the same hall';
  END IF;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER overlapping_sessions_trigger BEFORE INSERT
OR
UPDATE ON sessions FOR EACH ROW
EXECUTE FUNCTION eliminate_overlapping_sessions ();

CREATE
OR REPLACE FUNCTION check_unique_film () RETURNS TRIGGER AS $$
BEGIN
  IF EXISTS (
      SELECT 1
      FROM films
      WHERE title = NEW.title
      AND release_date = NEW.release_date
    ) THEN
    RAISE EXCEPTION 'This film with the same title and release date already exists';
  END IF;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER unique_film_trigger BEFORE INSERT
OR
UPDATE ON films FOR EACH ROW
EXECUTE FUNCTION check_unique_film ();