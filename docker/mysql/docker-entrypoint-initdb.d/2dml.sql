INSERT INTO boulder_users (external_id, name) VALUES
(104, 'Dmitry Ivanov'),
(105, 'Olga Petrov'),
(106, 'Sergey Sokolov'),
(107, 'Anna Kuznetsova'),
(108, 'Vladimir Lebedev'),
(109, 'Elena Smirnova'),
(110, 'Natalia Voronina');

INSERT INTO boulder_competitions (name, location, start_date, finish_date) VALUES
('Moscow Bouldering Cup', 'Moscow', '2024-10-15 09:00:00', '2024-10-16 17:00:00'),
('St. Petersburg Boulder Fest', 'St. Petersburg', '2024-11-20 10:00:00', '2024-11-21 18:00:00'),
('Ural Bouldering Championship', 'Yekaterinburg', '2024-12-10 08:30:00', '2024-12-11 16:00:00');

INSERT INTO boulder_problems (competition_id, name, grade, top_score, zone_score, max_attempts) VALUES
(1, 'Ural Rock 1', 'V6', 150, 75, 4),
(1, 'Ural Rock 2', 'V7', 170, 85, 6),
(1, 'Ural Rock 3', 'V5', 130, 65, 5),
(2, 'Moscow Wall 1', 'V4', 100, 50, 4),
(2, 'Moscow Wall 2', 'V6', 140, 70, 3),
(3, 'Nevsky Challenge 1', 'V3', 80, 40, 4),
(3, 'Nevsky Challenge 2', 'V5', 120, 60, 5);

INSERT INTO boulder_scores (user_id, problem_id, attempts, top_achieved, zone_achieved, score) VALUES
(1, 4, 3, TRUE, TRUE, 100),    -- Dmitry Ivanov on Moscow Wall 1
(2, 5, 2, TRUE, TRUE, 140),    -- Olga Petrov on Moscow Wall 2
(3, 6, 4, TRUE, TRUE, 80),     -- Sergey Sokolov on Nevsky Challenge 1
(4, 7, 5, FALSE, TRUE, 60),    -- Anna Kuznetsova on Nevsky Challenge 2
(5, 3, 6, FALSE, FALSE, 0),    -- Vladimir Lebedev on Ural Rock 3
(6, 1, 2, TRUE, TRUE, 150),    -- Elena Smirnova on Ural Rock 1
(7, 2, 3, TRUE, TRUE, 170),   -- Natalia Voronina on Ural Rock 2
(1, 6, 4, FALSE, TRUE, 40),    -- Dmitry Ivanov on Nevsky Challenge 1
(2, 3, 2, TRUE, TRUE, 130),    -- Olga Petrov on Ural Rock 3
(3, 5, 3, TRUE, TRUE, 120);    -- Sergey Sokolov on Nevsky Challenge 2
