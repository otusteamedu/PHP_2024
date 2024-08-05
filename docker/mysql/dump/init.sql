CREATE TABLE `news`
(
    `id`    int          NOT NULL AUTO_INCREMENT,
    `url`   varchar(255) NOT NULL,
    `date`  datetime     NOT NULL,
    `title` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
