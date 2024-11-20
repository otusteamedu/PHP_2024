TRUNCATE TABLE tickets CASCADE;
TRUNCATE TABLE sessions CASCADE;
TRUNCATE TABLE seats CASCADE;
TRUNCATE TABLE movie_country CASCADE;
TRUNCATE TABLE movie_director CASCADE;
TRUNCATE TABLE movie_genre CASCADE;
TRUNCATE TABLE halls CASCADE;
TRUNCATE TABLE directors CASCADE;
TRUNCATE TABLE countries CASCADE;
TRUNCATE TABLE genres CASCADE;
TRUNCATE TABLE movies CASCADE;

DO $$
    DECLARE
directorCount CONSTANT integer := 1000;
        countryCount CONSTANT integer := 150;
        movieCount CONSTANT integer := 10000;
        genreCount CONSTANT integer := 15;
        hallCount CONSTANT integer := 5;
        rowCount CONSTANT integer := 10;
        seatInRowCount CONSTANT integer := 20;
        sessionCount CONSTANT integer := 50;
        seatInHallCount CONSTANT integer = rowCount * seatInRowCount;
        ticketCount CONSTANT integer := sessionCount * seatInHallCount;
BEGIN
        PERFORM insert_directors(directorCount);
        PERFORM insert_genres(genreCount);
        PERFORM insert_countries(countryCount);
        PERFORM insert_movies(movieCount);
        PERFORM insert_movies_directors(movieCount, directorCount);
        PERFORM insert_movies_countries(movieCount, countryCount);
        PERFORM insert_movies_genres(movieCount, genreCount);
        PERFORM insert_halls(hallCount);
        PERFORM insert_seats(hallCount, rowCount, seatInRowCount);
        PERFORM insert_sessions(sessionCount, movieCount, hallCount);
END
$$;