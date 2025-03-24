CREATE TABLE if not exists users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(100) NOT NULL,
                       email VARCHAR(100) UNIQUE NOT NULL,
                       profile_id INT NULL
);

CREATE TABLE if not exists profiles (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          user_id INT NOT NULL,
                          bio TEXT,
                          FOREIGN KEY (user_id) REFERENCES users(id)
);

DROP TABLE profiles;
DROP TABLE users;