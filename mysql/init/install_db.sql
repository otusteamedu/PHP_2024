CREATE DATABASE IF NOT EXISTS hw1;
USE hw1;
CREATE TABLE helloTable
(
    id int auto_increment primary key,
    text varchar(30) null
);
INSERT INTO helloTable VALUES ('1', 'Hello1'), ('2', 'Hello2'), ('3', 'Hello3'), ('4', 'Hello4');