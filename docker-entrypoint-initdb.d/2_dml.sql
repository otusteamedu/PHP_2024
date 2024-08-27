-- Insert data into cinema table
INSERT INTO "cinema" ("title", "location", "contacts") VALUES
('Central Cinema', '123 Main St, Springfield', 'contact@centralcinema.com, 555-1234'),
('Downtown Cinema', '456 Elm St, Metropolis', 'info@downtowncinema.com, 555-5678');

-- Insert data into screen_type table
INSERT INTO "screen_type" ("type", "price_factor") VALUES
('IMAX', 1.6),
('3D', 1.5),
('Standard', 1);

-- Insert data into screen table
INSERT INTO "screen" ("cinema_id", "title", "capacity", "type") VALUES
(1, 'Screen 1', 200, 1),
(1, 'Screen 2', 150, 2),
(2, 'Screen A', 100, 3);

-- Insert data into film table
INSERT INTO "film" ("title", "genre", "duration", "release_date", "description", "price") VALUES
('Avengers: Endgame', 'Action', 181, '2019-04-26', 'The Avengers take a final stand against Thanos.', 15),
('Inception', 'Sci-Fi', 148, '2010-07-16', 'A thief who steals corporate secrets through dream-sharing technology.', 15),
('The Lion King', 'Animation', 88, '1994-06-24', 'A young lion prince flees his kingdom after the murder of his father.', 17),
('Titanic', 'Romance', 195, '1997-12-19', 'A young couple’s romance blossoms during the ill-fated maiden voyage of the RMS Titanic.', 20),
('Jurassic Park', 'Adventure', 127, '1993-06-11', 'During a preview tour, a theme park suffers a major power breakdown that allows its cloned dinosaur exhibits to run amok.', 10);

-- Insert data into seat_type table
INSERT INTO "seat_type" ("type", "price_factor") VALUES
('Regular', 1),
('VIP', 1.5),
('Premium', 2);

-- Insert data into seat table
INSERT INTO "seat" ("screen_id", "block", "row_number", "seat_number", "seat_type") VALUES
-- Screen 1 Seats
(1, 'A', '1', '1', 1),
(1, 'A', '1', '2', 1),
(1, 'B', '2', '3', 2),
(1, 'B', '2', '4', 2),
(1, 'C', '3', '5', 3),
(1, 'C', '3', '6', 3),

-- Screen 2 Seats
(2, 'A', '1', '1', 1),
(2, 'A', '1', '2', 1),
(2, 'B', '2', '3', 2),
(2, 'B', '2', '4', 2),
(2, 'C', '3', '5', 3),
(2, 'C', '3', '6', 3),

-- Screen A Seats
(3, 'A', '1', '1', 1),
(3, 'A', '1', '2', 1),
(3, 'B', '2', '3', 2),
(3, 'B', '2', '4', 2),
(3, 'C', '3', '5', 3),
(3, 'C', '3', '6', 3);

-- Insert data into user table
INSERT INTO "user" ("name", "lastname") VALUES
('John', 'Doe'),
('Jane', 'Smith'),
('Alice', 'Johnson'),
('Bob', 'Brown'),
('Carol', 'White');

-- Insert data into customer table
INSERT INTO "customer" ("user_id", "bonuses", "membership_status") VALUES
(1, 100, 1),
(2, 50, 2),
(3, 75, 1),
(4, 20, 3),
(5, 10, 2);

-- Insert data into employer table
INSERT INTO "employer" ("user_id", "position_id", "cinema_id", "salary") VALUES
(1, 1, 1, 50000),
(2, 2, 2, 45000),
(3, 3, 1, 40000),
(4, 4, 2, 42000),
(5, 5, 1, 39000);
