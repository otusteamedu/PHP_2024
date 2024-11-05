USE irayu_hw13;

GRANT ALL PRIVILEGES ON *.* TO 'yurta'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS boulder_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    external_id INT,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE boulder_competitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    location text,
    start_date DATETIME,
    finish_date DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE boulder_problems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_id INT,
    name VARCHAR(100),
    grade VARCHAR(10),
    top_score INT,
    zone_score INT,
    max_attempts INT,
    FOREIGN KEY (competition_id) REFERENCES boulder_competitions(id)
);
CREATE TABLE boulder_scores (
    user_id INT,
    problem_id INT,
    attempts INT,
    top_achieved BOOLEAN,
    zone_achieved BOOLEAN,
    score INT,
    PRIMARY KEY (user_id, problem_id),
    FOREIGN KEY (user_id) REFERENCES boulder_users(id),
    FOREIGN KEY (problem_id) REFERENCES boulder_problems(id)
);
