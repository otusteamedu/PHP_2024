CREATE TABLE film 
(
    Id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    price NUMERIC
);

CREATE TABLE hall
(
    Id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    status_ratio NUMERIC --status_ratio э{1.0, 1.2, 3.0}
                    --standart = 1.0
                    --FULL HD = 1.2 
                    -- 3D = 3.0
);

CREATE TABLE session
(
    Id SERIAL PRIMARY KEY,
    time_display TIMESTAMP,
    time_ratio NUMERIC, -- status_ratio э{1.0, 1.5, 2.0} 
                        -- 1.0 утро буднего дня
                        -- 1.5  вечер буднего дня / утро выходного
                        -- 2.0  вечер выходного дня
    film_id INTEGER,
    hall_id INTEGER,
    FOREIGN KEY (film_id) REFERENCES film (Id) ON DELETE CASCADE,
    FOREIGN KEY (hall_id) REFERENCES hall (Id) ON DELETE CASCADE
);

CREATE TABLE site
(
    Id SERIAL PRIMARY KEY,
    site_row INTEGER,
    site_number INTEGER,
    status_ratio NUMERIC -- status_ratio э{1.0, 1.5, 2.0} 
                        --standart = 1.0
                        --vip = 1.5 
                        --chill zone = 2.0
);

CREATE TABLE ticket
(
    Id SERIAL PRIMARY KEY,
    site_id INTEGER,
    session_id INTEGER,
    FOREIGN KEY (site_id) REFERENCES site (Id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES session (Id) ON DELETE CASCADE,
    price NUMERIC  -- = film.price * hall.status_ratio * site.status_ratio * session.time_ratio
);

CREATE TABLE buyer
(
    Id SERIAL PRIMARY KEY,
    name VARCHAR(150),
    ticket_id INTEGER,
    FOREIGN KEY (ticket_id) REFERENCES ticket (Id) ON DELETE CASCADE
);
