CREATE DATABASE `lyrics_parser`;

CREATE TABLE IF NOT EXISTS `lyrics_parser`.`singer` (
  `id`   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100),
  PRIMARY KEY (`id`),
  UNIQUE(`name`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `lyrics_parser`.`song` (
  `id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`     VARCHAR(100),
  `lyrics`     TEXT DEFAULT NULL,
  `singer_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE(`title`, `singer_id`),
  CONSTRAINT `fk_singer` FOREIGN KEY (`singer_id`) REFERENCES `singer` (`id`)
  ON DELETE NO ACTION ON UPDATE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `lyrics_parser`.`user` (
  `id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`      VARCHAR(100),
  `password`  VARCHAR(100),
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


CREATE TABLE IF NOT EXISTS `lyrics_parser`.`user_song` (
  `user_id` INT(10) UNSIGNED NOT NULL,
  `song_id` INT(10) UNSIGNED NOT NULL,
  UNIQUE(`user_id`,`song_id`),
  CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
  ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_song` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`)
  ON DELETE NO ACTION ON UPDATE CASCADE
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;