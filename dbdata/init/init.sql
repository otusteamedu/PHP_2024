CREATE TABLE IF NOT EXISTS tasks (
                                     id bigint PRIMARY KEY AUTO_INCREMENT,
                                     name varchar(255),
                                     description varchar(255),
                                     status varchar(255)
);