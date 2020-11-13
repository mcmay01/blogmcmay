CREATE DATABASE `blogmcmay` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

CREATE TABLE `mc_blog`
(
    `id`          int(11)     NOT NULL AUTO_INCREMENT,
    `title`       varchar(40) NOT NULL,
    `filename`    varchar(40) NOT NULL,
    `file_type`   varchar(20) NOT NULL,
    `file_size`   varchar(20) NOT NULL,
    `content`     text                 DEFAULT NULL,
    `create_date` date        NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `mc_blog_comment`
(
    `id`          int(11)  NOT NULL AUTO_INCREMENT,
    `blog_id`     int(11)  NOT NULL,
    `filename`    varchar(40)       DEFAULT NULL,
    `file_type`   varchar(40)       DEFAULT NULL,
    `file_size`   varchar(20)       DEFAULT NULL,
    `comments`    text     NOT NULL,
    `create_date` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `mc_login`
(
    `id`           int(11)      NOT NULL AUTO_INCREMENT,
    `uname`        varchar(40)  NOT NULL,
    `passd`        varchar(255) NOT NULL,
    `salt`         varchar(255) NOT NULL,
    `date_created` date         NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `mc_login_uname_uindex` (`uname`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;