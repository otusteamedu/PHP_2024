DROP TABLE IF EXISTS news;
CREATE TABLE news (
    id bigint primary key auto_increment,
    date date not null,
    title varchar(255) not null,
    url varchar(255) not null
);
