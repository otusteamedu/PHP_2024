DROP FUNCTION IF EXISTS get_random_integer;
DROP FUNCTION IF EXISTS get_random_unique_integers_array;
DROP FUNCTION IF EXISTS get_random_string;
DROP FUNCTION IF EXISTS get_random_director_count_for_movie;
DROP FUNCTION IF EXISTS get_random_country_count_for_movie;
DROP FUNCTION IF EXISTS get_hall_id_by_session_id;
DROP FUNCTION IF EXISTS get_seat_ids_range_by_hall_id;
DROP FUNCTION IF EXISTS get_seat_id_for_ticket;
DROP FUNCTION IF EXISTS insert_directors;
DROP FUNCTION IF EXISTS insert_countries;
DROP FUNCTION IF EXISTS insert_genres;
DROP FUNCTION IF EXISTS insert_movies;
DROP FUNCTION IF EXISTS insert_movies_directors;
DROP FUNCTION IF EXISTS insert_movies_countries;
DROP FUNCTION IF EXISTS insert_movies_genres;
DROP FUNCTION IF EXISTS inser_halls;
DROP FUNCTION IF EXISTS insert_seats;
DROP FUNCTION IF EXISTS insert_sessions;
DROP FUNCTION IF EXISTS insert_tickets;


CREATE OR REPLACE FUNCTION get_random_integer(min integer, max integer) RETURNS INTEGER AS $$
BEGIN
    RETURN min + round(random() * (max - min));
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_random_unique_integers_array(
    minRandomNumber integer,
    maxRandonNumber integer,
    requiredLength integer
) RETURNS integer[] AS $$
DECLARE
    result integer[] = '{}';
    number integer;
BEGIN
    <<outerWhile>>
    WHILE COALESCE(array_length(result, 1), 0) < requiredLength LOOP
        number := get_random_integer(minRandomNumber, maxRandonNumber);
        IF array_position(result, number) IS NOT NULL THEN
            CONTINUE outerWhile;
        END IF;
        result := result || number;
    END LOOP outerWhile;

    RETURN result;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_random_string(length integer) RETURNS text AS $$
DECLARE
chars text[] := '{0,1,2,3,4,5,6,7,8,9,А,Б,В,Г,Д,Е,Ё,Ж,З,И,Й,К,Л,М,Н,О,П,Р,С,Т,У,Ф,Х,Ц,Ч,Ш,Щ,Ъ,Ы,Ь,Э,Ю,Я,а,б,в,г,д,е,ё,ж,з,и,й,к,л,м,н,о,п,р,с,т,у,ф,х,ц,ч,ш,щ,ъ,ы,ь,э,ю,я}';
    result text := '';
    index integer;
BEGIN
    FOR i IN 1..length LOOP
        index := 1 + round(random() * (array_length(chars, 1) - 1));
        result := result || chars[index];
    END LOOP;
    RETURN result;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_random_director_count_for_movie() RETURNS integer AS $$
DECLARE
    randomNumber double precision;
BEGIN
    randomNumber := random();
    CASE
        WHEN randomNumber > 0.9 THEN
            RETURN 3;
        WHEN randomNumber > 0.8 THEN
            RETURN 2;
        ELSE
            RETURN 1;
    END CASE;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_random_country_count_for_movie() RETURNS integer AS $$
DECLARE
    randomNumber double precision;
BEGIN
    randomNumber := random();
    CASE
        WHEN randomNumber > 0.9 THEN
            RETURN 3;
        WHEN randomNumber > 0.8 THEN
            RETURN 2;
        ELSE
            RETURN 1;
    END CASE;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_seat_ids_range_by_hall_id(hallId integer, seatInHallCount integer) RETURNS integer[] AS $$
BEGIN
    RETURN ARRAY[(hallId - 1) * seatInHallCount + 1, hallId * seatInHallCount];
END
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_hall_id_by_session_id(sessionId integer, hallCount integer) RETURNS integer AS $$
DECLARE
    result integer;
BEGIN
    result := mod(sessionId, hallCount);
    IF result = 0 THEN
        result := hallCount;
    END IF;

    RETURN result;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_seat_id_for_ticket(
    ticketId bigint,
    sessionId integer,
    hallCount integer,
    seatInHallCount integer
) RETURNS integer AS $$
DECLARE
    hallId integer;
    seatIDs integer[];
    mod integer;
    seatOffset integer;
BEGIN
    hallId := get_hall_id_by_session_id(sessionId, hallCount);
    seatIDs := get_seat_ids_range_by_hall_id(hallId, seatInHallCount);
    mod := mod(ticketId, seatInHallCount);
    IF mod = 0 THEN
        seatOffset := seatInHallCount - 1;
    ELSE
        seatOffset := mod - 1;
    END IF;

    RETURN seatIDs[1] + seatOffset;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_directors(directorCount integer) RETURNS void AS $$
DECLARE
    firstNameLength integer;
    lastNameLength integer;
    fullNameLength integer;
    firstName text;
    lastName text;
    fullName text;
BEGIN
    FOR directorId IN 1..directorCount  LOOP
        firstNameLength := get_random_integer(5, 10);
        lastNameLength := get_random_integer(5, 10);
        fullNameLength := get_random_integer(10, 30);
        firstName :=  get_random_string(firstNameLength);
        lastName :=  get_random_string(lastNameLength);
        fullName :=  get_random_string(fullNameLength);
        INSERT INTO directors(id, first_name, last_name, full_name) VALUES
            (directorId, firstName, lastName, fullName);
        END LOOP;
    END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_countries(countryCount integer) RETURNS void AS $$
DECLARE
    nameLength integer;
BEGIN
    FOR countryId IN 1..countryCount LOOP
        nameLength := get_random_integer(5, 10);
        INSERT INTO countries(id, name) VALUES
            (countryId, get_random_string(nameLength));
    END LOOP;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_genres(genreCount integer) RETURNS void AS $$
DECLARE
    nameLength integer;
BEGIN
    FOR genreId IN 1..genreCount LOOP
        nameLength := get_random_integer(5, 10);
        INSERT INTO genres(id, name) VALUES
            (genreId, get_random_string(nameLength));
    END LOOP;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_movies(movieCount integer) RETURNS void AS $$
DECLARE
    titleLength integer;
    descriptionLength integer;
    title text;
    description text;
    releaseDate date;
    daysOffset integer;
    daysInterval interval;
    duration integer;
BEGIN
    FOR movieId IN 1..movieCount  LOOP
        titleLength := get_random_integer(5, 20);
        descriptionLength := get_random_integer(50, 500);
        title :=  get_random_string(titleLength);
        duration := get_random_integer(80, 180);
        daysOffset := get_random_integer(7, 365 * 20);
        daysInterval := (daysOffset || ' days')::interval;
        IF random() > 0.3 THEN
            releaseDate := (CURRENT_TIMESTAMP + daysInterval)::date;
        ELSE
            releaseDate := (CURRENT_TIMESTAMP - daysInterval)::date;
        END IF;

        description := get_random_string(descriptionLength);
        INSERT INTO movies(id, title, release_date, duration, description) VALUES
            (movieId, title, releaseDate, duration, description);
    END LOOP;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_movies_directors(movieCount integer, directorCount integer) RETURNS void AS $$
DECLARE
    directorIDs integer[];
BEGIN
    FOR movieId IN 1..movieCount LOOP
        directorIDs := get_random_unique_integers_array(1, directorCount, get_random_director_count_for_movie());
        FOR i IN 1..array_length(directorIDs, 1) LOOP
            INSERT INTO movies_directors(movie_id, director_id) VALUES
                (movieId, directorIDs[i]);
        END LOOP;
    END LOOP;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_movies_countries(movieCount integer, countryCount integer) RETURNS void AS $$
DECLARE
    countryIDs integer[];
BEGIN
    FOR movieId IN 1..movieCount LOOP
        countryIDs := get_random_unique_integers_array(1, countryCount, get_random_country_count_for_movie());
        FOR i IN 1..array_length(countryIDs, 1) LOOP
            INSERT INTO movies_countries(movie_id, country_id) VALUES
                (movieId, countryIDs[i]);
        END LOOP;
    END LOOP;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_movies_genres(movieCount integer, genryCount integer) RETURNS void AS $$
DECLARE
    genreIDs integer[];
    genreCountForMovie integer;
BEGIN
    FOR movieId IN 1..movieCount LOOP
        genreCountForMovie := get_random_integer(1, 5);
        genreIDs := get_random_unique_integers_array(1, genryCount, genreCountForMovie);
        FOR i IN 1..array_length(genreIDs, 1) LOOP
            INSERT INTO movies_genres(movie_id, genre_id) VALUES
                (movieId, genreIDs[i]);
        END LOOP;
    END LOOP;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_halls(hallCount integer) RETURNS void AS $$
DECLARE
    nameLength integer;
BEGIN
    FOR hallId IN 1..hallCount LOOP
        nameLength := get_random_integer(5, 10);
        INSERT INTO halls(id, name) VALUES
           (hallId, get_random_string(nameLength));
    END LOOP;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_seats(
    hallCount integer,
    rowCount integer,
    seatInRowCount integer
) RETURNS void AS $$
DECLARE
    seatId integer := 0;
BEGIN
    FOR hallId IN 1..hallCount LOOP
        FOR rowNumber in 1..rowCount LOOP
            FOR seatNumber in 1..seatInRowCount LOOP
                seatId := seatId + 1;
                INSERT INTO seats(id, hall_id, row_number, seat_number) VALUES
                    (seatId, hallId, rowNumber, seatNumber);
            END LOOP;
        END LOOP;
    END LOOP;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION insert_sessions(
    sessionCount integer,
    movieCount integer,
    hallCount integer
) RETURNS void AS $$
DECLARE
    movieId integer;
    hallId integer;
    startsAt timestamptz;
    endsAt timestamptz;
    startsAtIncreasing timestamptz;
    startsAtDecreasing timestamptz;
    duration integer;
BEGIN
    startsAtIncreasing := CURRENT_TIMESTAMP;
    startsAtDecreasing := CURRENT_TIMESTAMP;
    FOR sessionId in 1..sessionCount LOOP
        startsAtIncreasing := startsAtIncreasing + '30 minutes'::interval;
        startsAtDecreasing := startsAtDecreasing - '30 minutes'::interval;
        movieId = get_random_integer(1, movieCount);
        hallId = get_hall_id_by_session_id(sessionId, hallCount);
        IF mod(sessionId, 2) = 0 THEN
            startsAt := startsAtIncreasing;
        ELSE
            startsAt := startsAtDecreasing;
        END IF;
        duration := get_random_integer(80, 180);
        endsAt := startsAt + (duration || ' minutes')::interval;
        INSERT INTO sessions(id, movie_id, hall_id, starts_at, ends_at)
            VALUES(sessionId, movieId, hallId, startsAt, endsAt);
        END LOOP;
END
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insert_tickets(
    sessionCount integer,
    hallCount integer,
    seatInHallCount integer
) RETURNS void AS $$
DECLARE
    ticketId bigint;
    seatId integer;
    price integer;
    soldAt timestamptz;
    minutesBeforeCurrentDate integer;
    soldTicketsSessionPercent double precision;
BEGIN
    ticketId := 0;
    FOR sessionId in 1..sessionCount LOOP
        FOR seatInHall in 1..seatInHallCount LOOP
            ticketId := ticketId + 1;
            seatId = get_seat_id_for_ticket(ticketId, sessionId, hallCount, seatInHallCount);
            price := get_random_integer(600, 3000);
            soldTicketsSessionPercent := random();
            IF random() < soldTicketsSessionPercent THEN
                minutesBeforeCurrentDate := get_random_integer(1, 30 * 24 * 60);
                soldAt := CURRENT_TIMESTAMP - (minutesBeforeCurrentDate || ' minutes')::interval;
            ELSE
               soldAt := NULL;
            END IF;
            INSERT INTO tickets(id, session_id, seat_id, price, sold_at)
                VALUES(ticketId, sessionId, seatId, price, soldAt);
        END LOOP;
    END LOOP;
END
$$ LANGUAGE plpgsql;
